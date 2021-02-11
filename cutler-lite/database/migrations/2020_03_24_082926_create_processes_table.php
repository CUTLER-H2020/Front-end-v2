<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_user_id');
            $table->text('xml_process_id');
            $table->text('xml_process_name');
            $table->text('xml_instance_id')->nullable();
            $table->text('xml_definition_id')->nullable();
            $table->bigInteger('policy_id')->nullable();
            $table->text('policy_name')->nullable();
            $table->tinyInteger('started')->default(0);
            $table->integer('started_user_id')->nullable();
            $table->string('started_at')->nullable();
            $table->tinyInteger('completed')->default(0);
            $table->string('completed_at')->nullable();
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
        Schema::dropIfExists('processes');
    }
}
