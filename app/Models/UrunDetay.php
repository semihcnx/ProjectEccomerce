<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class UrunDetay extends Model
{
    protected $table='urun_detay';
    protected  $guarded = [];

    public $timestamps=false;  //oluştuma ve silme tarıhi kullanma demek

    public function urun()
    {
        return $this->belongsTo('App\Models\Urun');
    }

}
