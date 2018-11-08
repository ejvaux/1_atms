<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRejectedRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejected_requests', function (Blueprint $table) {
            $table->integer('id')->unique();
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
            $table->text('root')->nullable();
            $table->text('action')->nullable();
            $table->text('result')->nullable();
            $table->text('recommend')->nullable();
            $table->string('start_at')->nullable();
            $table->string('finish_at')->nullable();
            $table->mediumText('attach')->nullable();
            $table->boolean('approved')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('rejected_requests');
    }
}
