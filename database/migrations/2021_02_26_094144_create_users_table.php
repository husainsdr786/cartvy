<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('type')->default(2);
            $table->string('profile_image')->nullable();
            $table->string('profile_image_name')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->string('user_unique_id')->unique();
            $table->tinyInteger('is_admin')->default(0); 
            $table->unsignedBigInteger('parent_id')->default(0);
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
        Schema::dropIfExists('users');
    }
}
