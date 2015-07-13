<?php

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
        Schema::create('tickets', function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->text('subject');
            $table->text('body');
            $table->integer('zendesk_ticket_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tickets');
    }
}
