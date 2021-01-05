<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaketRekananAddFewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_paket_rekanan', function (Blueprint $table) {
            $table->integer('is_negoisasi')->default(0);
            $table->integer('is_kirim_undangan')->default(0);
        });

        Schema::table('e_rekanan_submit_penawaran', function (Blueprint $table) {
            $table->integer('is_negoisasi')->default(0);
        });

        Schema::table('e_paket', function (Blueprint $table) {
            $table->string('link_pembelian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paket_rekanan', function (Blueprint $table) {
            //
        });
    }
}
