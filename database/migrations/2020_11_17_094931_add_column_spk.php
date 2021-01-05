<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSpk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_kontrak_spk', function (Blueprint $table) {
            $table->string('nama_bank', 100)->nullable();
            $table->string('no_rek', 100)->nullable();
            $table->string('nama_ppk', 100)->nullable();
            $table->text('alamat_penyedia')->nullable();
            // $table->date('spk_wkt_penyelesaian')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_kontrak_spk', function (Blueprint $table) {
            //
        });
    }
}
