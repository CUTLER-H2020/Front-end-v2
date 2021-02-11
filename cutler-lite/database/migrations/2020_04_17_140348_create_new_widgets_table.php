<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateNewWidgetsTable
 */
class CreateNewWidgetsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('new_widgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('xml_process_id');
            $table->string('xml_process_name');
            $table->string('xml_process_key');
            $table->string('task_name');
            $table->string('task_phase');
            $table->string('widget_name');
            $table->string('widget_title');
            $table->string('widget_type');
            $table->string('widget_id');
            $table->string('dashboard_id')->nullable();
            $table->string('dashboard_title')->nullable();
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
        Schema::dropIfExists('new_widgets');
    }
}
