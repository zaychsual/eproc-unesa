<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEPaketRekananAddFewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_paket_rekanan', function (Blueprint $table) {
            $table->integer('is_winner')->default(0);
            $table->integer('urutan_pemenang')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_paket_rekanan', function (Blueprint $table) {
            //
        });
    }
}
