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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string("kodeTransaksi", 255);
            $table->integer("idProduk", false, true);
            $table->integer("idSize", false, true);
            $table->integer("hargaSatuan", false, true);
            $table->integer("jumlahBarang", false, true);
            $table->integer("diskon", false, true);
            $table->integer("total", false, true);
            $table->string("note", 255);
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
        Schema::dropIfExists('transaksi');
    }
}
