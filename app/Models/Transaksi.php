<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $fillable = [
        "kodeTransaksi", 
        "idProduk" , 
        "idSize", 
        "hargaSatuan", 
        "jumlahBarang", 
        "diskon", 
        "total", 
        "note"
      ];
}
