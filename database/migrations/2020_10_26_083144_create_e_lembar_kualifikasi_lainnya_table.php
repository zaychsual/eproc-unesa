<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateELembarKualifikasiLainnyaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_lembar_kualifikasi_lainnya', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->text('syarat')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::table('e_lembar_kualifikasi', function (Blueprint $table) {
            $table->string('pajak_tahun_terakhir')->nullable();
            $table->string('pengalaman_kerja_detail')->nullable();
            $table->integer('tenaga_ahli')->default(0);
            $table->integer('tenaga_teknis')->default(0);
            $table->integer('kemampuan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_lembar_kualifikasi_lainnya');
    }
}
