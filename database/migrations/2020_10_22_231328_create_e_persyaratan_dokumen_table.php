<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEPersyaratanDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_persyaratan_dokumen', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->string('masa_berlaku')->nullable();
            $table->string('penawaran')->nullable();
            $table->string('jaminan')->nullable();
            $table->string('pengiriman_barang')->nullable();
            $table->string('brosur')->nullable();
            $table->string('jaminan_purnajual')->nullable();
            $table->string('tenaga_teknis')->nullable();
            $table->integer('tipe')->default(0);
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
        Schema::dropIfExists('e_persyaratan_dokumen');
    }
}
