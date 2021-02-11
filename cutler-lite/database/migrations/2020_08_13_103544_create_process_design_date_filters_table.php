<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessDesignDateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_design_date_filters', function (Blueprint $table) {
            $table->id();
            $table->text('xml_process_id');
            $table->text('xml_process_name');
            $table->text('xml_process_key');
            $table->text('task_name');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('last_selection')->nullable();
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
        Schema::dropIfExists('process_design_date_filters');
    }
}
