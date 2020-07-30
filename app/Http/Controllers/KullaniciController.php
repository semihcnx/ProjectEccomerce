<?php

namespace App\Http\Controllers;
use App\Models;
use App\Models\Kullanici;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\KullaniciKayitMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Sepet;
use App\Models\SepetUrun;
use App\Models\KullaniciDetay;

class KullaniciController extends Controller
{
    public function __construct() {
        $this->middleware('guest')->except('oturumukapat');

    }


    public function giris_form() {
    return view('kullanici.oturumac');
    }
    public function giris() {
        $this->validate(\request(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
            $credentials= [
                'email'=>request('email'),
                'password'=>request('password'),
                'aktif_mi'=>1
            ];

        if (auth()->attempt($credentials,request()->has('benihatirla'))) {
            request()->session()->regenerate(); //Session Bilgilerini Güncelle

            $aktif_sepet_id=Sepet::aktif_sepet_id();
            if(is_null($aktif_sepet_id)) {
                    $aktif_sepet=Sepet::create(['kullanici_id'=>auth()->id()]);
                    $aktif_sepet_id=$aktif_sepet->id;
            }

            session()->put('aktif_sepet_id',$aktif_sepet_id);
            if(Cart::count()>0){

                foreach (Cart::content() as $cartItem)
                {
                    SepetUrun::updateOrCreate(
                        ['sepet_id'=>$aktif_sepet_id,'urun_id'=>$cartItem->id->id],
                        ['adet'=>$cartItem->qty,'fiyati'=>$cartItem->price,'durum'=>'Beklemede']
                    );
                }
            }

            Cart::destroy();
            $sepetUrunler= SepetUrun::with('urun')->where('sepet_id',$aktif_sepet_id)->get();
            foreach ($sepetUrunler as $sepetUrun)
            {
                Cart::add($sepetUrun->urun->id,$sepetUrun->urun->urun_adi,$sepetUrun->adet,$sepetUrun->urun->fiyati,['slug'=>$sepetUrun->urun->slug]);
            }


            return redirect()->intended('/');  //Kullanici giriş izni istediği sayfaya geri dönmek için kullanıliır.
        }
        else {
            $errors= ['email'=>'Hatalı Giriş'];
            return back()->withErrors($errors);

        }
    }

    public function kaydol_form() {
        return view('kullanici.kaydol');

    }
    public function  kaydol()
    {
        $this->validate(\request(),[
           'adsoyad'=>'required|min:5|max:60',
            'email'=>'required|email|unique:kullanici',
            'password'=>'required|confirmed|min:5|max:15'
        ]);

        $kullanici =Kullanici::create([
            'adsoyad'               =>request('adsoyad'),
            'email'                 =>request('email'),
            'password'                 =>Hash::make(request('password')),
            'aktivasyon_anahtari'   =>Str::random(60),
            'aktif_mi'=> 0

        ]);
        $kullanici->detay()->save(new KullaniciDetay());

        Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));
        auth()->login($kullanici);
        return redirect()->route('anasayfa');
    }

    public function aktiflestir($anahtar){

        $kullanici= Kullanici::where('aktivasyon_anahtari',$anahtar)->first();

        if(!is_null($kullanici))
        {
            $kullanici->aktivasyon_anahtari=null;
            $kullanici->aktif_mi=1;
            $kullanici->save();
            return redirect()->to('/')
                ->with('mesaj','Kullanici başarıyla aktifleştirildi')
                ->with('mesaj_tur','success');
        }
        else {
            return redirect()->to('/')
                ->with('mesaj','Kullanici kaydınız gerçekleştirilemedi')
                ->with('mesaj_tur','danger');
        }

    }

    public function oturumukapat(){
        auth()->logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('anasayfa');

    }


}
