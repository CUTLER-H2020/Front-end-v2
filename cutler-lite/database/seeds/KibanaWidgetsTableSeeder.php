<?php

use Illuminate\Database\Seeder;

class KibanaWidgetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kibana_widgets')->delete();
        
        \DB::table('kibana_widgets')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'panel_0',
                'type' => 'visualization',
                'title' => 'Dashboard1',
                'dashboard_id' => '4ec53b40-8af5-11e9-9662-1150f2a70f9f',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'panel_1',
                'type' => 'visualization',
                'title' => 'Dashboard2',
                'dashboard_id' => 'b13ec6a0-8af6-11e9-9662-1150f2a70f9f',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'panel_2',
                'type' => 'visualization',
                'title' => 'Dashboard3',
                'dashboard_id' => 'd0ee6410-8b41-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'panel_3',
                'type' => 'visualization',
                'title' => 'Dashboard4',
                'dashboard_id' => '3c703600-8b42-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'panel_4',
                'type' => 'visualization',
                'title' => 'Dashboard5',
                'dashboard_id' => '0dec1970-8b42-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'panel_5',
                'type' => 'visualization',
                'title' => 'Dashboard6',
                'dashboard_id' => 'f6c97810-8af5-11e9-9662-1150f2a70f9f',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'panel_6',
                'type' => 'visualization',
                'title' => 'Dashboard7',
                'dashboard_id' => 'd5a6dbb0-8b44-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'panel_7',
                'type' => 'visualization',
                'title' => 'Dashboard8',
                'dashboard_id' => 'c0ef7f40-8b4b-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'panel_8',
                'type' => 'visualization',
                'title' => 'Dashboard9',
                'dashboard_id' => '26347c20-8b4c-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 17,
                'name' => 'panel_9',
                'type' => 'visualization',
                'title' => 'Dashboard10',
                'dashboard_id' => '4dc2faf0-8b4c-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 18,
                'name' => 'panel_10',
                'type' => 'visualization',
                'title' => 'Dashboard11',
                'dashboard_id' => 'e59ba9d0-8af7-11e9-9662-1150f2a70f9f',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 19,
                'name' => 'panel_11',
                'type' => 'visualization',
                'title' => 'Dashboard12',
                'dashboard_id' => 'e4f60aa0-8b5d-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 20,
                'name' => 'panel_12',
                'type' => 'visualization',
                'title' => 'Dashboard13',
                'dashboard_id' => '39cae2c0-8b46-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 21,
                'name' => 'panel_13',
                'type' => 'visualization',
                'title' => 'Dashboard14',
                'dashboard_id' => '8e7c2520-8b61-11e9-97a1-772a1a403f87',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 22,
                'name' => 'panel_14',
                'type' => 'search',
                'title' => 'Dashboard15',
                'dashboard_id' => 'bc58ac70-8c24-11e9-a83d-2f8034612cde',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 23,
                'name' => 'panel_15',
                'type' => 'visualization',
                'title' => 'Dashboard16',
                'dashboard_id' => '8556b990-8c26-11e9-a83d-2f8034612cde',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 24,
                'name' => 'panel_16',
                'type' => 'visualization',
                'title' => 'Dashboard17',
                'dashboard_id' => '7153b2b0-e345-11e9-96ca-49308b9425ed',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 25,
                'name' => 'panel_17',
                'type' => 'visualization',
                'title' => 'Dashboard18',
                'dashboard_id' => '4c4f92d0-e346-11e9-96ca-49308b9425ed',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 26,
                'name' => 'panel_18',
                'type' => 'visualization',
                'title' => 'Dashboard19',
                'dashboard_id' => '5959c7b0-e347-11e9-96ca-49308b9425ed',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 27,
                'name' => 'panel_19',
                'type' => 'visualization',
                'title' => 'Dashboard20',
                'dashboard_id' => 'b88315a0-e353-11e9-96ca-49308b9425ed',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}