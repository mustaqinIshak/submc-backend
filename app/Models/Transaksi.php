<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $fillable = [
        "idKodeTransaksi", 
        "idProduk" , 
        "idSize", 
        "hargaSatuan", 
        "jumlahBarang", 
        "diskon", 
        "diskon_amount",
        "total", 
        "note"
      ];
}
