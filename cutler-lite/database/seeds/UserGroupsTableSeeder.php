<?php

use Illuminate\Database\Seeder;

class UserGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('user_groups')->delete();

        \DB::table('user_groups')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Pilot Administrators',
                'permissions' => '["policy.create","policy.destroy","policy.edit","policy.index","process.index","start-process","document.index","entry-statistics","page-statistics","users-statistics","user-statistics-show","kafka.messages","kafka.topics","process-design.index","process-design.index","settings.edit","task.index","user-group.index","user.index"]',
                'created_at' => '2020-03-19 11:36:40',
                'updated_at' => '2020-05-05 11:17:15',
            ),
            1 =>
            array (
                'id' => 5,
                'name' => 'Data Scientist',
                'permissions' => '["policy.create","policy.destroy","policy.edit","policy.index","process-design.index","process-design.index","process-design.details","process-design.tasks"]',
                'created_at' => '2020-05-04 14:16:41',
                'updated_at' => '2020-05-05 11:23:24',
            ),
            2 =>
            array (
                'id' => 6,
                'name' => 'Policy Makers',
                'permissions' => '["policy.index","process.index","start-process","process.index"]',
                'created_at' => '2020-05-04 14:20:22',
                'updated_at' => '2020-05-07 10:28:33',
            ),
        ));


    }
}
