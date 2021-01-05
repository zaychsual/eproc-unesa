<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEKualifikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_lembar_kualifikasi', function (Blueprint $table) {
            $table->integer('surat_pernyataan')->default(0);
            $table->integer('kapasitas_hukum')->default(0);
            $table->integer('memiliki_tdp')->default(0);
            $table->integer('mempunyai_tempat_usaha')->default(0);
            $table->integer('mempunyai_perjanjian_konsorsium')->default(0);
            $table->integer('laporan_keuangan_akhir_tahun')->default(0);
            $table->integer('memiliki_skn')->default(0);
            $table->integer('type')->default(0);
        });
        
        Schema::create('mtd_lembar_kualifikasi', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
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
        Schema::table('e_lembar_kualifikasi', function (Blueprint $table) {
            //
        });
    }
}
