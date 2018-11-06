<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCctvReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cctv_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_id');
            $table->integer('user_id');
            $table->integer('department_id');
            $table->integer('priority_id');
            $table->integer('status_id')->default(6);
            $table->text('subject');
            $table->mediumText('message');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('location');
            $table->integer('assigned_to')->nullable();
            $table->string('start_at')->nullable();
            $table->string('finish_at')->nullable();
            $table->timestamps();
            $table->unique('request_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cctv_reviews');
    }
}
