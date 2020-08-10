<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Kullanici;
use App\Models\Siparis;
use App\Models\Urun;
use Cache;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        // $bitisZamani = now()->addMinutes(10);
        // $istatistikler= Cache::remember('istatistikler', $bitisZamani , function () {
        // return     [
        //         'bekleyen_siparis' => Siparis::where('durum','Siparişiniz alındı')->count()
        // ];
        // });
        // view()->share('istatistikler', $istatistikler);

        //Cache::forget('istatistikler');  //  Belirli cache i siler
        //Cache::flush();      // Tüm Cache i siler

            view()->composer(['yonetim*'], function ($view) {

        $bitisZamani = now()->addMinutes(10);
        $istatistikler= Cache::remember('istatistikler', $bitisZamani , function () {
        return     [
                'bekleyen_siparis' => Siparis::where('durum','Siparişiniz alındı')->count(),
                'tamamlanan_siparis' => Siparis::where('durum','Siparişiniz tamamlandı')->count(),
                'toplam_urun' => Urun::count(),
                'toplam_kullanici' => Kullanici::count(),
                'toplam_kategori'=>Kategori::count()
        ];
        });


            $view->with('istatistikler',$istatistikler);
            });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
