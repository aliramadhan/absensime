<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('role', ['Admin', 'Catering','Employee'])->default('Employee');
            $table->string('division')->default('Support');
            $table->string('position')->nullable();
            $table->string('roles')->default('Employee');
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('number_phone')->nullable();
            $table->string('code_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->boolean('can_order')->default(0);
            $table->boolean('can_order_directly')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamp('last_seen')->nullable();
            $table->timestamp('joined_at')->useCurrent();
            $table->integer('leave_count')->default(0);
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
        Schema::dropIfExists('users');
    }
}
