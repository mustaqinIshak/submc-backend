<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileCompany extends Model
{
    //
    protected $table = "profile_company";

    protected $fillable = [
        "name", "alamat", "nomor_hp", "instagram", "twitter", "facebook", "youtube"
    ];
}
