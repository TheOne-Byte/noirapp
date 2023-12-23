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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('excerpt')->nullable();
            $table->string('body')->nullable();
            $table->decimal('price')->nullable();
            $table->string('email')->unique();
            $table->foreignId('category_id')->nullable();
            $table->foreignId('permission_id')->nullable();
            $table->foreignId('role_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('idcardnumber')->nullable();
            $table->bigInteger('norekening')->nullable();
            $table->string('idcardstatcode');
            $table->integer('points')->nullable();
            $table->boolean('ban_status')->nullable()->default(false);
            $table->integer('report_times')->nullable();
            $table->integer('unban_times')->nullable();
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
};
