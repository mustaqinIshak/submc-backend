<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //
    protected $table = "size";

    protected $fillable = [
        "produkId", "barcode", "name" , "jumlah" 
      ];
}
