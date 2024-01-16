<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategori extends Model
{
    //

    protected $table = "sub_categories";

    protected $fillable = [
        "id_categori", "name"
    ];
}
