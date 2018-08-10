<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnClosedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('closed_tickets', function (Blueprint $table) {
            $table->integer('assigned_to')->nullable()->after('message');
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
