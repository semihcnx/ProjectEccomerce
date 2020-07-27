<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class KullaniciController extends Controller
{
    public function oturumac()
    {

        if(request()->isMethod('POST')) {

            $this->validate(request(),[
                'email' =>'required|email',
                'sifre'=>'required'
            ]);

            $credentials = [
                'email' => request()->get('email'),
                'password' =>request()->get('sifre'),
                'yonetici_mi' => 1
            ];


                if (Auth::guard('yonetici')->attempt($credentials,request()->has('benihatirla')))
                {
                    return redirect()->route('yonetim.anasayfa');
                }

                else {
                    return back()->withInput()->withErrors(['email'=>'Giriş Hatalı!!']);

                }
        }

        return view('yonetim.oturumac');
    }


    public function oturumkapat(){
        Auth::guard('yonetici')->logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }


}
