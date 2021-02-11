<?php

use Illuminate\Database\Seeder;

class PoliciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('policies')->delete();
        
        \DB::table('policies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 4,
                'user_group_id' => 1,
                'name' => 'Deneme',
                'feature' => 'Deneme',
                'goal' => 'Deneme',
                'action' => 'Deneme',
                'impact' => 'Deneme',
                'created_at' => '2020-04-30 14:31:26',
                'updated_at' => '2020-04-30 14:31:26',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 4,
                'user_group_id' => 1,
                'name' => 'asd',
                'feature' => 'asd',
                'goal' => 'asd',
                'action' => 'asd',
                'impact' => 'asd',
                'created_at' => '2020-05-05 11:40:19',
                'updated_at' => '2020-05-05 11:40:19',
            ),
        ));
        
        
    }
}