<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeterReadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meter_readers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meter_id')->nullable();
            $table->foreign('meter_id')->references('id')->on('meters')->onDelete('cascade');
            $table->unsignedBigInteger('reader_id')->nullable();
            $table->foreign('reader_id')->references('id')->on('admins')->onDelete('cascade');
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
        Schema::dropIfExists('meter_readers');
    }
}
