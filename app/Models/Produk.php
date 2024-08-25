<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    //

    protected $table = "produk";

    protected $fillable = [
        "name",
        "barcode", 
        "harga",
        "id_categori", 
        "id_sub_categori",  
        "deskripsi", 
        "color", 
        "type", 
        "jenis_bahan",  
        "link_shoope",
        "sale",
        "start_sale",
        "end_sale",
        "status",
        "id_brand",
        "jumlah_sale",
    ];
}
