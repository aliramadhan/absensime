<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->enum('status',['Work','Rest','Overtime'])->default('Work');
            $table->datetime('started_at');
            $table->datetime('stoped_at')->nullable();
            $table->enum('location',['WFO','WFH','Business Travel','Remote'])->default('WFO');
            $table->string('position')->nullable();
            $table->string('task')->nullable();
            $table->string('task_desc')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('history_schedules');
    }
}
