<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siparis;

class SiparisController extends Controller
{
    public function index()
    {
        if(request()->filled('aranan'))
        {

            request()->flash();  //aranan değierin görünmesi için flashla sessiona alıyoruz
            $aranan= request('aranan');
            //Kullanıcı hem adsoyada göre hemde emaile göre arıyor
           $listele= Siparis::with('sepet.kullanici')->where('adsoyad','like',"%$aranan%")
           ->orWhere('id',$aranan)
           ->orderByDesc('id')
           ->paginate(8) //Sayfalama yaptırma komutu
           ->appends('aranan',$aranan);  //sayfalama da 2. sayfanın doğru sayfalama yapması için ekledik

        }
        else {
            $listele= Siparis::with('sepet.kullanici')
            ->orderByDesc('id')
            ->paginate(8);
        }


        return view('yonetim.siparis.index',compact('listele'));
    }

    public function form($id = 0)
    {


        if ($id >0)
        {
            $entry= Siparis::with('sepet.sepet_urunler.urun')->find($id);

        }

        $kategoriler= Siparis::all();

        return view('yonetim.siparis.form', compact('entry'));
    }

    public function kaydet($id = 0)
    {




        $this->validate(request(),[
            'adsoyad'=>'required',
            'adres' => 'required',
            'telefon' => 'required',
            'durum' => 'required'

        ]);

        $data = request()->only('adsoyad','adres','telefon','ceptelefonu','durum');   //only formdaki name ile db deki isim aynı ise kullanılır. Kısa yoldur.



         if($id >0)
        {
            //Güncelle
          $entry = Siparis::where('id',$id)->firstOrFail();
           $entry->update($data);


           // Save() Komutu nesneleri kaydeder. Update ve Crate ise dizileri kaydededer! Önemli!!
        }


        return redirect()->route('yonetim.siparis.duzenle',$entry->id)
        ->with('mesaj','Güncellendi')
        ->with('mesaj_tur','success');
    }

    public function sil($id)
    {
        $sil= Siparis::destroy($id);



        return redirect()->route('yonetim.siparis')
        ->with('mesaj_tur','success')
        ->with('mesaj','Kayıt Silindi');
    }
}
