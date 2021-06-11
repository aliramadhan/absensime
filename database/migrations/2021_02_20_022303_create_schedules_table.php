<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users');
            $table->string('employee_name')->nullable();
            $table->foreignId('shift_id')->constrained('shifts');
            $table->date('date');
            $table->string('shift_name')->nullable();
            $table->integer('workhour')->default(0);
            $table->integer('timer')->default(0);
            $table->string('status')->default('Not sign in');
            $table->string('status_depart')->nullable();
            $table->string('note')->nullable();
            $table->string('position_start')->nullable();
            $table->string('position_stop')->nullable();
            $table->string('current_position')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('stoped_at')->nullable();
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
        Schema::dropIfExists('schedules');
    }
}
