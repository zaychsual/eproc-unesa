<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEvaluasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('e_evaluasi_administrasi');
        Schema::drop('e_evaluasi_harga');
        Schema::drop('e_evaluasi_kualifikasi');
        Schema::drop('e_evaluasi_teknis');

        Schema::create('e_evaluasi_penawarans', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('dokumen_penawaran_id')->nullable();
            $table->integer('is_penawaran')->default(0);
            $table->integer('is_lulus')->default(0);
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
        Schema::table('e_evaluasi_administrasi', function (Blueprint $table) {
            //
        });
    }
}
