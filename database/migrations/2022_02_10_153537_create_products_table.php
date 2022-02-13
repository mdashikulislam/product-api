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
            $table->id();
            $table->string('title')->nullable();
            $table->string('mpn')->nullable();
            $table->string('asin')->nullable();
            $table->string('barcode')->nullable();
            $table->string('model')->nullable();
            $table->string('category')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('gender')->nullable();
            $table->string('material')->nullable();
            $table->string('size')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('contributors')->nullable();
            $table->string('ingredients')->nullable();
            $table->date('release_date')->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->text('images')->nullable();
            $table->text('stores')->nullable();
            $table->text('reviews')->nullable();
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
