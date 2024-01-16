<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string("name", 255);
            $table->string("barcode", 255);
            $table->integer("harga", false, true);
            $table->bigInteger("id_categori", false, true);
            $table->bigInteger("id_sub_categori", false, true)->nullable();
            $table->string("deskripsi", 255)->nullable();
            $table->string("color", 255)->nullable();
            $table->string("type", 255)->nullable();
            $table->string("jenis_bahan", 255)->nullable();
            $table->string("link_shoope", 255)->nullable();
            $table->integer("sale",false, true)->nullable();
            $table->date("start_sale")->nullable();
            $table->date("end_sale")->nullable();
            $table->integer("status", false, true);
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
        Schema::dropIfExists('produk');
    }
}
