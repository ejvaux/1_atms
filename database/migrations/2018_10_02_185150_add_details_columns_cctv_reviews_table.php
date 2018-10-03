<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsColumnsCctvReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cctv_reviews', function (Blueprint $table) {
            $table->text('root')->nullable()->after('assigned_to');
            $table->text('action')->nullable()->after('root');
            $table->text('result')->nullable()->after('action');
            $table->text('recommend')->nullable()->after('result');
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
}
