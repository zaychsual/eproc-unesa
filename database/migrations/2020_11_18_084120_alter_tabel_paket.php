<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTabelPaket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_paket_diteruskan', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('pengendali_kualitas_id')->nullable();
            $table->date('tanggal')->nullable();
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
        Schema::table('e_paket', function (Blueprint $table) {
            //
        });
    }
}
