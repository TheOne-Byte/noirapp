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
        Schema::create('updatesingleblade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // Foreign key referencing users table
            $table->text('bio')->nullable();
            $table->string('image_path')->nullable(); // Column to store the path of the uploaded image
            $table->string('video_path')->nullable(); // Column to store the path of the uploaded video
            $table->boolean('is_approved')->default(false); // Field to indicate whether the request is approved by admin
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
        //
    }
};
