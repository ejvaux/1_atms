<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('vehicle_request_serial');
            $table->text('user');
            $table->string('position');
            $table->text('purpose');
            $table->date('requested_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('department_id');
            $table->string('driver')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('created_by');
            $table->integer('approval_id');
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
        Schema::dropIfExists('vehicle_requests');
    }
}
