<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('role_id');
            $table->foreignId('user_id');
            $table->decimal('price');
            $table->string('imageprofile');
            $table->string('image');
            $table->string('video');
            $table->bigInteger('norekening');
            $table->string('statcode',5);
            $table->string('body',100);
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
        Schema::dropIfExists('permissions');
    }
};
