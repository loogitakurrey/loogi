<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_rate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->unique();
            $table->string('INR');
            $table->string('USD');
            $table->string('EUR');
            $table->string('GBP');
            $table->string('ILS');
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
        Schema::dropIfExists('current_rate');
    }
}
