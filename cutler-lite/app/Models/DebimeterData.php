<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebimeterData extends Model
{
    protected $table = "debimeter_datas";
    protected $fillable = [
        'kayitid',
        'islemtarihi',
        'tarih',
        'istekid',
        'kutuid',
        'gelenipadresi',
        'reg0',
        'reg1',
        'reg2',
        'reg3',
        'reg4',
        'reg5',
        'reg6',
        'reg7',
        'reg8',
        'reg9',
        'instant_flow',
        'actual_flow'
    ];
}
