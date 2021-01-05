<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateELembarKualifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_lembar_kualifikasi', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->integer('memiliki_npwp')->default(0);
            $table->integer('melunasi_pajak_akhir_tahun')->default(0);
            $table->integer('dalam_pengawasan')->default(0);
            $table->integer('daftar_hitam')->default(0);
            $table->integer('pengalaman_kerja')->default(0);
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
        Schema::dropIfExists('e_lembar_kualifikasi');
    }
}
