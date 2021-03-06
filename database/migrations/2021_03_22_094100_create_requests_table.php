<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->string('employee_name')->nullable();
            $table->date('date');
            $table->string('type');
            $table->text('format')->nullable();
            $table->text('desc');
            $table->integer('time')->nullable();
            $table->boolean('is_cancel_order')->default(0);
            $table->boolean('is_check_half')->default(0);
            $table->string('change_catering')->nullable();
            $table->enum('status',['Waiting','Decline','Accept'])->default('Waiting');
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
        Schema::dropIfExists('requests');
    }
}
