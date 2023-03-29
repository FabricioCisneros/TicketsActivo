<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReasignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reasignacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('destination_department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('reassigned_by_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lifted_by_id')->constrained('users');
            $table->text('description');
            $table->timestamp('date')->nullable();
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
        Schema::dropIfExists('reasignacion');
    }
}
