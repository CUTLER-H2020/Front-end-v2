<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Turkish',
                'code' => 'tr',
                'status' => 1,
                'icon' => 'tr.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'English',
                'code' => 'en',
                'status' => 1,
                'icon' => 'us.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'German',
                'code' => 'de',
                'status' => 0,
                'icon' => 'de.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Italian',
                'code' => 'it',
                'status' => 0,
                'icon' => 'it.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Dutch',
                'code' => 'nl',
                'status' => 0,
                'icon' => 'nl.png',
                'created_at' => NULL,
                'updated_at' => '2020-09-29 13:48:24',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Greek',
                'code' => 'gr',
                'status' => 0,
                'icon' => 'gr.png',
                'created_at' => NULL,
                'updated_at' => '2020-09-29 13:48:25',
            ),
        ));
        
        
    }
}