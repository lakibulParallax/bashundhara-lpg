<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->id();
            $table->integer('meter_type')->nullable()->comment('1: pre paid; 2: post paid');
            $table->string('number')->nullable();
            $table->string('snd')->nullable();
            $table->string('building')->nullable();
            $table->string('flat_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('last_reading')->nullable();
            $table->date('last_reading_date')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('meters');
    }
}
