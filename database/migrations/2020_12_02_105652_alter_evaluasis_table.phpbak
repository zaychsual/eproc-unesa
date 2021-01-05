<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEvaluasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_evaluasi_penilaian', function (Blueprint $table) {
            $table->integer('is_doc_type')->default(    1);
        });

        Schema::table('e_evaluasi_kualifikasis', function (Blueprint $table) {
            $table->dropColumn('alasan_tidak_lulus');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_evaluasi_penilaian', function (Blueprint $table) {
            //
        });
    }
}
