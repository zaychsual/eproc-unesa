<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEPaketsAddCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_paket', function (Blueprint $table) {
            $table->integer('category_id')->default(0);
        });

        Schema::create('e_paket_category', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_pakets', function (Blueprint $table) {
            //
        });
    }
}
