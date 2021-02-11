<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('policy_id');
            $table->text('policy_name');
            $table->text('process_name');
            $table->text('process_id');
            $table->text('task_name');
            $table->text('task_id');
            $table->text('widget_name');
            $table->text('widget_title');
            $table->text('widget_type');
            $table->text('widget_id');
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
        Schema::dropIfExists('widgets');
    }
}
