<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users');
            $table->string('employee_name')->nullable();
            $table->foreignId('menu_id')->constrained('menus');
            $table->string('menu_name')->nullable();
            $table->string('order_number')->unique();
            $table->date('order_date');
            $table->enum('serving',['S','M','L','XL'])->default('M');
            $table->boolean('is_sauce')->default(0);
            $table->enum('shift',['Pagi','Siang','Sore','Malam'])->default('Pagi');
            $table->boolean('status')->default(false);
            $table->text('review')->nullable();
            $table->string('stars', 5)->nullable();
            $table->timestamp('reviewed_at')->nullable()->default(null);
            $table->float('fee')->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
