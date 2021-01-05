<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEPaketHpsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_paket_hps_detail', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->text('jenis_barang_jasa')->nullable();
            $table->string('satuan', 100)->nullable();
            $table->integer('qty');
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('pajak')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        Schema::create('e_paket_file', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id');
            $table->string('files')->nullable();
            $table->string('ukuran_file_dok')->nullable();
            $table->string('tipe_file_dok')->nullable();
            $table->datetime('tanggal_upload')->nullable();
            $table->integer('tipe')->nullable();
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
        Schema::dropIfExists('e_paket_hps_detail');
    }
}
