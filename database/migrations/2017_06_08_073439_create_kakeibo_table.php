<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKakeiboTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('kakeibo', function(Blueprint $table) {
               $table->string('title');
               $table->integer('price');
               $table->date('purchased_at');
               $table->dateTime('created_at');
               $table->dateTime('updated_at');
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('kakeibo');
    }
}
