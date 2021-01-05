<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidasiPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validasi_pakets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('category_id');
            $table->uuid('jenis_pengadaan_id')->nullable();
            $table->decimal('nilai_hps', 13, 2)->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->string('userid_created')->nullable();
            $table->string('userid_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validasi_pakets');
    }
}
