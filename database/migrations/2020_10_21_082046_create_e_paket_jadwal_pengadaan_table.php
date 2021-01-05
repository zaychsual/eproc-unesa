<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEPaketJadwalPengadaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_paket_jadwal_pengadaan', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->dateTime('dok_penawaran_mulai');
            $table->dateTime('dok_penawaran_selesai');
            $table->dateTime('dok_pembukaan_penawaran_mulai');
            $table->dateTime('dok_pembukaan_penawaran_selesai');
            $table->dateTime('dok_evaluasi_penawaran_mulai');
            $table->dateTime('dok_evaluasi_penawaran_selesai');
            $table->dateTime('dok_klarifikasi_teknis_mulai');
            $table->dateTime('dok_klarifikasi_teknis_selesai');
            $table->dateTime('dok_ttd_kontrak_mulai');
            $table->dateTime('dok_ttd_kontrak_selesai');
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
        Schema::dropIfExists('e_paket_jadwal_pengadaan');
    }
}
