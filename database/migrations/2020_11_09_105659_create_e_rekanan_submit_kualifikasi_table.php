<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateERekananSubmitKualifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_rekanan_submit_kualifikasi_izin_usaha', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('izin_usaha_id')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_kualifikasi_pajak', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('pajak_id')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_kualifikasi_ta', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('mt_tenaga_ahli_id')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_kualifikasi_dukungan_bank', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->string('nama_bank', 100)->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->date('tanggal')->nullable();
            $table->bigInteger('nilai')->default(0);
            $table->string('file_bukti_dukungan_bank')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_kualifikasi_syarat_lain', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->string('file_syarat_lain')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_kualifikasi_pengalaman', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('mt_pengalaman_id')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_kualifikasi_peralatan', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('mt_peralatan_id')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_rekanan_submit_penawaran', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->integer('masa_berlaku')->nullable();
            $table->string('file_jadwal_penyerahan')->nullable();
            $table->string('file_brosur')->nullable();
            $table->string('file_tenaga_teknis')->nullable();
            $table->integer('is_setuju')->default(0);
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
        Schema::dropIfExists('e_rekanan_submit_kualifikasi');
    }
}
