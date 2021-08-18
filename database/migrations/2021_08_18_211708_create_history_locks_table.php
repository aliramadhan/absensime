<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryLocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_locks', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('request_id')->nullable();
            $table->date('date');
            $table->string('reason');
            $table->boolean('is_requested')->default(0);
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
        Schema::dropIfExists('history_locks');
    }
}
