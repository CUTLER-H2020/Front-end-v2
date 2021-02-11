<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkColumnsToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->tinyInteger('link1')->default(0)->after('maps');
            $table->tinyInteger('link2')->default(0)->after('link1');
            $table->tinyInteger('link3')->default(0)->after('link2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('link1');
            $table->dropColumn('link2');
            $table->dropColumn('link3');
        });
    }
}
