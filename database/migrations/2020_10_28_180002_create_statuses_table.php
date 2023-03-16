<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('statuses')) {
            Schema::create('statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *2020_10_28_180002_create_statuses_table
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
