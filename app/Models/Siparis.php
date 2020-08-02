<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siparis extends Model
{

    protected $table = 'siparis';
    protected $fillable =['sepet_id','siparis_tutari','adsoyad','adres','telefon','ceptelefonu','banka','taksit','durum'];  //sadece belirtilen hücrelerin eklenebilmesini sağlıyor.

    const CREATED_AT = 'olusturma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';


    public function sepet()
        {
        return $this->belongsTo('App\Models\Sepet');
        }

}