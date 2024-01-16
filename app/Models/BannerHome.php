<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerHome extends Model
{
    //

    protected $table = "banner_home";

    protected $fillable = [
        "gambar",
        "link"
    ];
}
