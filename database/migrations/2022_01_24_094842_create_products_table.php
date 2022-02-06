<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            Schema::dropIfExists('products');
            $table->id();
            $table->unsignedBigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');//onDelete('set null');
            $table->unsignedBigInteger('discount_id')->unsigned()->nullable();
            $table->foreign('discount_id')->references('id')->on('discounts');//onDelete('set null');
            $table->string('code');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('description');
            $table->decimal('price',10,2);
            $table->enum('unit',['gram','piece']);
            $table->boolean('availability')->default(1);
            $table->string('image'); // primary image
            //$table->float('discount')->default(0);
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
        Schema::dropIfExists('products');
    }
}
