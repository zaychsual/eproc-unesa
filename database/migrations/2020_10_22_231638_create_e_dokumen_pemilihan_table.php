<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEDokumenPemilihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_dokumen_pemilihan', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->string('nomor_dokumen')->nullable();
            $table->string('tanggal_dokumen')->nullable();
            $table->string('dokumen')->nullable();
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
        Schema::dropIfExists('e_dokumen_pemilihan');
    }
}
