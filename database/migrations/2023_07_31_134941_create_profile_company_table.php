<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_company', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("alamat");
            $table->string("nomor_hp");
            $table->string("instagram")->nullable();
            $table->string("twitter")->nullable();
            $table->string("facebook")->nullable();
            $table->string("youtube")->nullable();
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
        Schema::dropIfExists('profile_company');
    }
}
