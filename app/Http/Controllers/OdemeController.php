<?php

namespace App\Http\Controllers;

use App\Models\Siparis;
use Illuminate\Http\Request;
use Cart;

class OdemeController extends Controller
{
    public function index () {

        if(!auth()->check()){

            return redirect()->route('kullanici.oturumac')
                ->with('mesaj_tur','info')
                ->with('mesaj','Ödeme yapabilmek için giriş yapmanız gerekmektedir.');

        }

        else if(count(Cart::content())== 0){
            return redirect()->route('anasayfa')
                ->with('mesaj_tur','info')
                ->with('mesaj','Ödeme yapabilmek için sepete ekleme yapınız.');
        }
            $kullanici_detay= auth()->user()->detay;

        return view('odeme',compact('kullanici_detay'));
    }

    public function odemeyap()
    {
        //sanal post bağlı olmadığı için bankadan olumlu cevap aldığımız varsayarak hareket ediyırouz
        $siparis= request()->all();
        $siparis['sepet_id']=session('aktif_sepet_id');
        $siparis['banka']='Garanti';
        $siparis['taksit']=1;
        $siparis['durum']='Siparis Alındı';
        $siparis['siparis_tutari']=Cart::subtotal(); //kdvsiz toplam tutarı aldık.

        Siparis::create($siparis);
        Cart::destroy();
        session()->forget('aktif_sepet_id');

        return redirect()->route('siparisler')
            ->with('mesaj_tur','success')
            ->with('mesaj','Ödemeniz başarılı bir şekilde gerçekleşti');
    }

}
