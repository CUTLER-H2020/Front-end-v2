<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('assignee')->nullable();
            $table->text('xml_definition_id'); // xml api aracılığı ile gelen değer
            $table->text('xml_task_name'); // xml api aracılığı ile gelen değer
            $table->text('xml_task_id'); // xml api aracılığı ile gelen değer
            $table->text('xml_process_id'); // xml api aracılığı ile gelen değer
            $table->text('process_name'); // sistemin içinde olan değer
            $table->string('phase');
            $table->text('description');
            $table->tinyInteger('last_task')->default(0);
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
        Schema::dropIfExists('tasks');
    }
}
