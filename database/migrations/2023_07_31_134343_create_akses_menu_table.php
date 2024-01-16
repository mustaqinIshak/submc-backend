<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAksesMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_menu', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("id_menu", false, true);
            $table->bigInteger("id_role", false,true);
            $table->integer("act_create", false, true);
            $table->integer("act_read", false, true);
            $table->integer("act_update", false, true);
            $table->integer("act_delete", false, true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akses_menu');
    }
}
