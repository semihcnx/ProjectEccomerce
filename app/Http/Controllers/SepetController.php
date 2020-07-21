<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\Urun;
use Cart;
use Illuminate\Http\Request;
use Validator;

class SepetController extends Controller
{
    public function __construct()
    {
     // $this->middleware('auth');
    }

    public function index() {

        return view('sepet');
    }

    public function ekle() {
    $urun= Urun::find(\request('id'));
    $cartItem= Cart::add($urun,$urun->urun_adi,1,$urun->fiyati,['slug'=>$urun->slug]);

    if(auth()->check()){
        $aktif_sepet_id=session('aktif_sepet_id');
        if(!isset($aktif_sepet_id)){
            $aktif_sepet= Sepet::create([
            'kullanici_id'=>auth()->id()
        ]);
        $aktif_sepet_id= $aktif_sepet->id;
        session()->put('aktif_sepet_id',$aktif_sepet_id);
        }
        SepetUrun::updateOrCreate(
            ['sepet_id'=>$aktif_sepet_id,'urun_id'=>$urun->id],
            ['adet'=>$cartItem->qty,'fiyati'=>$urun->fiyati,'durum'=>'Beklemede']
        );


    }
    return redirect()->route('sepet')
        ->with('mesaj_tur','success')
        ->with('mesaj','Ürün Sepete Eklendi');
    }

    public function kaldir($rowid) {
        if(auth()->check())
        {
            $aktif_sepet_id= session('aktif_sepet_id');
            $cardItem= Cart::get($rowid);
            $deneme=$cardItem->id;
            SepetUrun::where('sepet_id',$aktif_sepet_id)->where('urun_id',$deneme->id)->delete();
        }

        Cart::remove($rowid);
        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj','Sepetten ürün kaldırıldı');


    }
    public function bosalt(){
        if(auth()->check()){
            $aktif_sepet_id=session('aktif_sepet_id');

            SepetUrun::where('sepet_id',$aktif_sepet_id)->delete();
        }
        Cart::destroy();
        return redirect()->route('sepet')
            ->with('mesaj_tur','success')
            ->with('mesaj','Ürün Sepetten Kaldırıldı');
    }

    public function guncelle($rowid) {
        $validator = Validator::make(\request()->all(),[
           'adet'=>'required|numeric|between:0,5'
        ]);

        if($validator->fails()){
            session()->flash('mesaj_tur','danger');
            session()->flash('mesaj','Adet 1 ile 5 arasında olmalıdır');
            return response()->json(['success'=>false]);
        }


        if(auth()->check()) {
            $aktif_sepet_id = session('aktif_sepet_id');
            $cardItem = Cart::get($rowid);
            $deneme = $cardItem->id;

            if(request('adet')==0) {
                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $deneme->id)->delete();
            }
            else {

                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $deneme->id)
                    ->update(['adet' => \request('adet')]);
            }
        }

        Cart::update($rowid,request('adet'));
        session()->flash('mesaj_tur','success');
        session()->flash('mesaj','Adet Bilgisi Güncellendi');

        return response()->json(['success'=>true]);
    }

}
