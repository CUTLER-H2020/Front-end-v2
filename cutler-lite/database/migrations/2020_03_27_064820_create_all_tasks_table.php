<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->text('xml_task_name');
            $table->text('xml_task_id');
            $table->text('definition_id');
            $table->text('instance_id');
            $table->text('process_name');
            $table->text('phase')->nullable();
            $table->text('description')->nullable();
            $table->text('assignee')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 => Bekliyor, 1 => İşlemde, 2 => Tamamlanmış');
            $table->string('started_at')->nullable();
            $table->string('finished_at')->nullable();
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
        Schema::dropIfExists('all_tasks');
    }
}
