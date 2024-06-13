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
        Schema::create('c_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->nullable();

            $table->string('banner_heading')->nullable();
            $table->string('banner_description')->nullable();
            $table->string('banner_picture')->nullable();

            $table->string('about_heading')->nullable();
            $table->string('about_description')->nullable();
            $table->string('about_picture')->nullable();

            $table->string('gallery_heading')->nullable();
            $table->string('gallery_description')->nullable();
            $table->string('gallery_picture')->nullable();

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
        Schema::dropIfExists('c_m_s');
    }
};
