<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kullanici extends Authenticatable




{
    use SoftDeletes;
    protected $table = 'kullanici';
    //izin verdiklerimizi fillable içine yazıyoruz.
    protected $fillable = ['adsoyad', 'email', 'password','aktivasyon_anahtari','aktif_mi'];
    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';
    protected $hidden = ['password', 'aktivasyon_anahtari'];


    public function detay()
    {
        return $this->hasOne('App\Models\KullaniciDetay');
    }

}
