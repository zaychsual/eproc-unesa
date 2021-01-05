<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekananSubmitDokumenPenawaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_rekanan_submit_dokumen_penawaran', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('paket_id')->nullable();
            $table->uuid('mt_rekanan_id')->nullable();
            $table->uuid('dokumen_penawaran_id')->nullable();
            $table->string('file');
            $table->string('file_size')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('is_dokumen')->nullable();
            $table->timestamps();
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
        });

        // Schema::create('rekanan_submit_dokumen_penawaran_file_zip', function (Blueprint $table) {
        //     $table->uuid('id');
        //     $table->primary('id');
        //     $table->uuid('paket_id')->nullable();
        //     $table->uuid('mt_rekanan_id')->nullable();
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekanan_submit_dokumen_penawaran');
    }
}
