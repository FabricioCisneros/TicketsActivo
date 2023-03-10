<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporteTicket', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->text('razonReporte');
            $table->text('tituloReporte');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('reportedBy_id');
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('agent_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('reportedBy_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporte_ticket');
    }
}
