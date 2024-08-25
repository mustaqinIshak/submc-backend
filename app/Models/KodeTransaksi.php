<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KodeTransaksi extends Model
{
    //
    protected $fillable = [
        "idUser", 
        "kode", 
        "note", 
        "idTax", 
        "jumlahBarang", 
        "amount", 
        "status"
      ];
      public static function generateTransactionCode()
      {
          return Str::uuid();
      }
}
