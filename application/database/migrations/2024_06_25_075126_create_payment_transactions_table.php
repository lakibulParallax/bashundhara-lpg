<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 255)->nullable();
            $table->string('amount')->nullable();
            $table->string('merchant_code', 255)->nullable();
            $table->string('session_id', 255)->nullable();
            $table->string('bill_no', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('transaction_ref', 255)->nullable();
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
        Schema::dropIfExists('payment_transactions');
    }
}
