<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekananSubmitKualifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_rekanan_submit_kualifikasi', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->integer('submit_kualifikasi')->default(0);
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekanan_submit_kualifikasi');
    }
}
