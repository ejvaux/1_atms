<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeclinedTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declined_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_id');
            $table->integer('user_id');
            $table->integer('department_id');
            $table->integer('category_id');
            $table->integer('priority_id');
            $table->integer('status_id');
            $table->text('subject');
            $table->mediumText('message');
            $table->integer('assigned_to')->nullable();
            $table->text('root')->nullable();
            $table->text('action')->nullable();
            $table->text('result')->nullable();
            $table->text('recommend')->nullable();
            $table->string('start_at')->nullable();
            $table->string('finish_at')->nullable();
            $table->string('attach')->nullable();
            $table->timestamps();
            $table->unique('ticket_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declined_tickets');
    }
}
