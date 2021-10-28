<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string("fcmToken", 512)->nullable();
            $table->string("device", 512)->nullable();
            $table->ipAddress("ip")->nullable();
            $table->string("access_token", 1024)->nullable();
            $table->string("refresh_token", 1024)->nullable();
            $table->timestamp("last_active")->useCurrent();
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
        Schema::dropIfExists('sessions');
    }
}
