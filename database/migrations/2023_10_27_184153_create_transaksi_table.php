<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string("idKodeTransaksi", 255);
            $table->integer("idProduk", false, true);
            $table->integer("idSize", false, true);
            $table->integer("hargaSatuan", false, true);
            $table->integer("jumlahBarang", false, true);
            $table->integer("diskon", false, true);
            $table->integer("diskon_amount", false, true);
            $table->integer("total", false, true);
            $table->string("note", 255)->nullable();
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
        Schema::dropIfExists('transaksis');
    }
}
