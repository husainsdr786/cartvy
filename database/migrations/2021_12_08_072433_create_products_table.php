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
            $table->string('name');
            $table->integer('price');
            $table->longText('description');
            $table->integer('stock')->default(1);
            $table->integer('offer')->default(0)->comment('%');
            $table->integer('user_id')->unsigned()->comment('user Id');
            $table->integer('category_id')->unsigned()->comment('Category Id');
            $table->tinyInteger('status')->default(1)->comment('1:Active,0:In-active');
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
