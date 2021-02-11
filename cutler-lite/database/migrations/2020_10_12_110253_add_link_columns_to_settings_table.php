<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('link_title_1')->nullable()->after('maps_iframe_url');
            $table->longText('link_1')->nullable()->after('link_title_1');
            $table->longText('link_title_2')->nullable()->after('link_1');
            $table->longText('link_2')->nullable()->after('link_title_2');
            $table->longText('link_title_3')->nullable()->after('link_2');
            $table->longText('link_3')->nullable()->after('link_title_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('link_title_1');
            $table->dropColumn('link_1');
            $table->dropColumn('link_title_2');
            $table->dropColumn('link_2');
            $table->dropColumn('link_title_3');
            $table->dropColumn('link_3');
        });
    }
}
