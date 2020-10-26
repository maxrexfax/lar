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
            $table->string('login')->unique();
            $table->string('password')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('is_eaten')->nullable();
            $table->dateTime('last_logined_date')->nullable();
            $table->string('last_logined_ip')->nullable();
            $table->string('last_logined_city')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_city_id_foreign');
        });
        Schema::drop('users');
    }
}
