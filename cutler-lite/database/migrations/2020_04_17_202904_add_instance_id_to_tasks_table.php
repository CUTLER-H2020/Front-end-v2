<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddInstanceIdToTasksTable
 */
class AddInstanceIdToTasksTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('instance_id')->after('phase');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('instance_id');
        });
    }
}
