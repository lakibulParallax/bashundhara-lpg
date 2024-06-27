<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meter_id')->nullable();
            $table->foreign('meter_id')->references('id')->on('meters')->onDelete('cascade');
            $table->unsignedBigInteger('payment_transaction_id')->nullable();
            $table->foreign('payment_transaction_id')->references('id')->on('payment_transactions')->onDelete('cascade');
            $table->string('present_reading')->default(0);
            $table->string('previous_reading')->default(0);
            $table->string('consumption')->default(0);
            $table->string('unit_price')->default(0);
            $table->string('service_charge')->default(0);
            $table->string('amount')->default(0);
            $table->string('penalty_for_late_payment')->default(0);
            $table->string('total_after_final_payment_date')->default(0);
            $table->string('bill_month')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('meter_reading_date')->nullable();
            $table->date('final_payment_date')->nullable();
            $table->boolean('payment_status')->default(0)->comment('0: unpaid; 1: paid');
            $table->dateTime('payment_time')->nullable();
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
        Schema::dropIfExists('bills');
    }
}
