<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
