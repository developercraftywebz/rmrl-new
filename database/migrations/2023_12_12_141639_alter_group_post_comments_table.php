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
        Schema::table('group_post_comments', function (Blueprint $table) {
            $table->unsignedInteger('post_id')->nullable()->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->longText('comment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_post_comments', function (Blueprint $table) {
            $table->unsignedInteger('post_id')->change();
            $table->unsignedBigInteger('user_id')->change();
            $table->longText('comment')->change();
        });
    }
};
