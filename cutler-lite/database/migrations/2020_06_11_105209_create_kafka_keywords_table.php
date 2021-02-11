<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKafkaKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kafka_keywords', function (Blueprint $table) {
            $table->id();
            $table->text('xml_task_id');
            $table->string('keyword');
            $table->string('start_date');
            $table->string('end_date');
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('started_by');
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
        Schema::dropIfExists('kafka_keywords');
    }
}
