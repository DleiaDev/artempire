<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('profile')->default('https://res.cloudinary.com/markowebdev-com/image/upload/v1584615714/artempire/profiles/default.png');
            $table->string('background')->default('https://res.cloudinary.com/markowebdev-com/image/upload/v1584534850/artempire/backgrounds/default.jpg');
            $table->string('fullName');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('verified')->default(false);
            $table->rememberToken();
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
