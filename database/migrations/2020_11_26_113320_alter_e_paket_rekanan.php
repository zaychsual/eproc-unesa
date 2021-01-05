<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEPaketRekanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_paket_rekanan', function (Blueprint $table) {
            // $table->uuid('tahapan_id')->nullable();
            $table->integer('status_tahapan')->default(0);
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
