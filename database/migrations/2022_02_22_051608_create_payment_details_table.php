<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');//onDelete('set null');
            $table->unsignedBigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');//onDelete('set null');
            $table->decimal('amount',10,2);
            $table->string('provider');
            $table->enum('status',['pending' , 'success' , 'failed']);
            $table->string('code',100)->nullable(); // The payment id provided by the payment gateway   
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
        Schema::dropIfExists('payment_details');
    }
}