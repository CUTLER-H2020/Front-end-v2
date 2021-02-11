<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('kibana_ip')->nullable();
            $table->string('kibana_port')->nullable();
            $table->string('kibana_username')->nullable();
            $table->string('kibana_pass')->nullable();
            $table->string('kibana_widget_url')->nullable();
            $table->string('kafka_ip')->nullable();
            $table->string('kafka_port')->nullable();
            $table->string('kafka_topic')->nullable();
            $table->string('camunda_ip')->nullable();
            $table->string('camunda_port')->nullable();
            $table->string('camunda_username')->nullable();
            $table->string('camunda_pass')->nullable();
            $table->string('maps_iframe_url')->nullable();
            $table->string('smtp_server_name')->nullable();
            $table->string('smtp_port_number')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_pass')->nullable();
            $table->string('login_bg')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
