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
        Schema::table('group_post_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('group_post_comment_id')->nullable()->after('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_post_likes', function (Blueprint $table) {
            $table->dropColumn('group_post_comment_id');
        });
    }
};
