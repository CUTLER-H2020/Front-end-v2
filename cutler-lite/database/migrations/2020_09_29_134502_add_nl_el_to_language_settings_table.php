<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNlElToLanguageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('language_settings', function (Blueprint $table) {
            $table->longText('nl')->nullable()->after('it');
            $table->longText('gr')->nullable()->after('nl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('language_settings', function (Blueprint $table) {
            $table->dropColumn('nl');
            $table->dropColumn('gr');
        });
    }
}
