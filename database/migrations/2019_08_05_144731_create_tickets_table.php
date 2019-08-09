<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('ticket_id')->nullable();
            $table->string('title');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('category_id');
            $table->text('message');
            $table->string('priority')->default('LOW');
            $table->boolean('is_assigned')->default(false);
            $table->integer('assigned_to')->nullable();
            $table->unsignedInteger('status_id')->default(1);
            $table->timestamps();

            // $table->foreign('category_id')->references('id')->on('categories');
            // $table->foreign('status_id')->references('id')->on('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
