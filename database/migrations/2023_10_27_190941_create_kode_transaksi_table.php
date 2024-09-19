<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKodeTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kode_transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer("idUser", false, true);
            $table->string("kode", 255);
            $table->string("note", 255)->nullable();
            $table->integer("idTax", false, true);
            $table->integer("amount", false, true);
            $table->string("status", 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kode_transaksi');
    }
}
