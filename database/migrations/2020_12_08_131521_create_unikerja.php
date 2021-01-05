<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnikerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_unit_kerja', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('nama')->nullable();
            $table->string('email')->unique();
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('laman')->nullable();
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
        Schema::dropIfExists('mt_unit_kerja');
    }
}
