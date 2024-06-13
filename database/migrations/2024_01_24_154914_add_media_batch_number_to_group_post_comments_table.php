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
            $table->unsignedBigInteger('media_batch_number')->nullable()->after('user_id');
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
            $table->dropColumn('media_batch_number');
        });
    }
};
