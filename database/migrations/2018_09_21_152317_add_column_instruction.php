<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInstruction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('instruction')->nullable()->after('recommend');
        });
        Schema::table('closed_tickets', function (Blueprint $table) {
            $table->text('instruction')->nullable()->after('recommend');
        });
        Schema::table('declined_tickets', function (Blueprint $table) {
            $table->text('instruction')->nullable()->after('recommend');
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
