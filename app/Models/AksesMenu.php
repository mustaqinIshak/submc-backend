<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesMenu extends Model
{
    //
    protected $table = "akses_menu";

    protected $fillable = [
        "id_menu", "id_role", "act_create", "act_read", "act_update", "act_delete"
    ];

    public $timestamps = false;
}
