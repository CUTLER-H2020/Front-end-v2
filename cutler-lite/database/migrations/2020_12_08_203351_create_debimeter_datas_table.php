<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebimeterDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debimeter_datas', function (Blueprint $table) {
            $table->id();
            $table->string('kayitid')->nullable();
            $table->string('islemtarihi')->nullable();
            $table->string('tarih')->nullable();
            $table->string('istekid')->nullable();
            $table->string('kutuid')->nullable();
            $table->string('gelenipadresi')->nullable();
            $table->string('reg0')->nullable();
            $table->string('reg1')->nullable();
            $table->string('reg2')->nullable();
            $table->string('reg3')->nullable();
            $table->string('reg4')->nullable();
            $table->string('reg5')->nullable();
            $table->string('reg6')->nullable();
            $table->string('reg7')->nullable();
            $table->string('reg8')->nullable();
            $table->string('reg9')->nullable();
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
        Schema::dropIfExists('debimeter_datas');
    }
}
