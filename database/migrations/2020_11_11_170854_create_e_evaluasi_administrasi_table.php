<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEEvaluasiAdministrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_evaluasi_administrasi', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->integer('masa_berlaku_penawaran')->default(0);
            $table->integer('penawaran')->default(0);
            $table->text('alasan_tidak_lulus')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_evaluasi_kualifikasi', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->integer('persayaratan_kualifikasi')->default(0);
            $table->integer('siup')->default(0);
            $table->integer('lunas_pajak_tahun_terakhir')->default(0);
            $table->integer('tidak_masuk_daftar_hitam')->default(0);
            $table->integer('memiliki_npwp')->default(0);
            $table->integer('tidak_dalam_pengawasan')->default(0);
            $table->text('alasan_tidak_lulus')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_evaluasi_teknis', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->integer('spesifikasi_teknis_identitas')->default(0);
            $table->text('alasan_tidak_lulus')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_evaluasi_harga', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->integer('daftar_kuantitas_n_harga')->default(0);
            $table->integer('penilaian')->default(0);
            $table->bigInteger('harga_terkoreksi')->default(0);
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
        Schema::dropIfExists('e_evaluasi_administrasi');
    }
}
