<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Urun;
use App\Models\UrunDetay;

class UrunController extends Controller
{
    public function index()
    {
        if(request()->filled('aranan'))
        {

            request()->flash();  //aranan değierin görünmesi için flashla sessiona alıyoruz
            $aranan= request('aranan');
            //Kullanıcı hem adsoyada göre hemde emaile göre arıyor
           $listele= Urun::where('urun_adi','like',"%$aranan%")
           ->orWhere('aciklama','like',"%$aranan%")
           ->orderByDesc('id')
           ->paginate(8) //Sayfalama yaptırma komutu
           ->appends('aranan',$aranan);  //sayfalama da 2. sayfanın doğru sayfalama yapması için ekledik

        }
        else {
            $listele= Urun::orderByDesc('id')->paginate(8);
        }


        return view('yonetim.urun.index',compact('listele'));
    }

    public function form($id = 0)
    {

        $entry= new Urun;
        $urun_kategorileri = [];
        if ($id >0)
        {
            $entry= Urun::find($id);
            $urun_kategorileri= $entry->kategoriler()->pluck('kategori_id')->all();   //pluck komutu istenilen hücreyi  almasını sağlıyor.
        }

        $kategoriler= Kategori::all();

        return view('yonetim.urun.form', compact('entry','kategoriler','urun_kategorileri'));
    }

    public function kaydet($id = 0)
    {
        $data = request()->only('urun_adi','slug','aciklama','fiyati');   //only formdaki name ile db deki isim aynı ise kullanılır. Kısa yoldur.
        if (!request()->filled('slug'))
        {
            $data['slug'] =  str_slug(request('urun_adi'));  //str_slug slug yaratmak için özel fonksyion
            request()->merge(['slug'=>$data['slug']]);    //data slug içindeki slug bilgsini kontrol yapabilmesi için merge ile requeste aktardık.
        }


        $this->validate(request(),[
            'urun_adi'=>'required',
            'fiyati' => 'required',
            'slug' =>(request('original_slug')!= request('slug') ? 'unique:urun,slug' : '')
        ]);

         $data_detay= request()->only('goster_slider','goster_gunun_firsati','goster_one_cikan','goster_cok_satan','goster_indirimli');
        $kategoriler = request('kategoriler');

       //dd($kategoriler);
         if($id >0)
        {
            //Güncelle
          $entry = Urun::where('id',$id)->firstOrFail();
           $entry->update($data);
           $entry->detay()->update($data_detay);
           $entry->kategoriler()->sync($kategoriler);  // Kategori dizisinden gelene değerleri senkron ediyor.


           // Save() Komutu nesneleri kaydeder. Update ve Crate ise dizileri kaydededer! Önemli!!
        }
        else
        {
            //Kaydet
            $entry=Urun::create($data);
            $entry->detay()->create($data_detay);
            $entry->kategoriler()->attach($kategoriler);
         }

        if(request()->hasFile('urun_resmi'))
        {
            $this->validate(request(), [

                'urun_resmi' => 'image|mimes:gif,jpeg,jpg,png |max:2048'
            ]);

            $urun_resmi = request()->urun_resmi;
            $dosyaadi= $entry->id . '-' . time() . '.' .$urun_resmi->extension();   // Özelleştirilimiş isim
            //$dosyadi= $urun_resmi->getClientOriginalName();  // Dosyannın Orjinal İsmini Alıyor
            //$dosyaadi= $urun_resmi->hashName();  //Rasgele Dosya Adı oluşturuyor

            if($urun_resmi->isValid() )  //Dosyanın geçici alana yüklenip yüklenmediğini kontrol ediyor
            {
                $urun_resmi->move('uploads/urunler', $dosyaadi);   //move komutu ile belitilen adrese yükleme yapıyoruz

                UrunDetay::updateOrCreate(
                    ['urun_id' => $entry->id],
                    ['urun_resmi' =>$dosyaadi]
            );
            }

        }


        return redirect()->route('yonetim.urun.duzenle',$entry->id)
        ->with('mesaj',($id>0 ? 'Güncellendi' : 'Kaydedildi'))
        ->with('mesaj_tur','success');
    }

    public function sil($id)
    {
        $urun= Urun::find($id);
        $urun->kategoriler()->detach();   //Many To Many Yapıda oluğu için detach donksiyonu ile sildirdik.
        $urun->detay()->delete();   // Bire Bire yapısında olduğu için delete ile sildik.
        $urun->delete();


        return redirect()->route('yonetim.urun')
        ->with('mesaj_tur','success')
        ->with('mesaj','Kayıt Silindi');
    }
}
