<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlowColumnsToDebimeterDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debimeter_datas', function (Blueprint $table) {
            $table->string('instant_flow')->default(0)->after('reg9');
            $table->string('actual_flow')->default(0)->after('instant_flow');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debimeter_datas', function (Blueprint $table) {
            $table->dropColumn('instant_flow');
            $table->dropColumn('actual_flow');
        });
    }
}
