<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'group' => 'User',
                'name' => 'User List',
                'code' => 'user.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'group' => 'Process Design',
                'name' => 'Process Design',
                'code' => 'process-design.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'group' => 'Policies',
                'name' => 'Policies',
                'code' => 'policy.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'group' => 'Processes',
                'name' => 'Processes List',
                'code' => 'process.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'group' => 'User Group',
                'name' => 'User Group List',
                'code' => 'user-group.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'group' => 'Tasks',
                'name' => 'Tasks List',
                'code' => 'task.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 9,
                'group' => 'Settings',
                'name' => 'Settings Edit',
                'code' => 'settings.edit',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'id' => 10,
                'group' => 'Documents',
                'name' => 'Documents Index',
                'code' => 'document.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'id' => 15,
                'group' => 'Process Design',
                'name' => 'Process Design',
                'code' => 'process-design.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'id' => 16,
                'group' => 'Process Design',
                'name' => 'Process Design Details',
                'code' => 'process-design.details',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'id' => 17,
                'group' => 'Process Design',
                'name' => 'Process Design Tasks',
                'code' => 'process-design.tasks',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'id' => 19,
                'group' => 'Policies',
                'name' => 'Add New Policy',
                'code' => 'policy.create',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'id' => 20,
                'group' => 'Policies',
                'name' => 'Edit',
                'code' => 'policy.edit',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array (
                'id' => 21,
                'group' => 'Policies',
                'name' => 'Delete',
                'code' => 'policy.destroy',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array (
                'id' => 22,
                'group' => 'Policies',
                'name' => 'Start New Process',
                'code' => 'start-process',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array (
                'id' => 23,
                'group' => 'Policies',
                'name' => 'Process List',
                'code' => 'process.index',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}
