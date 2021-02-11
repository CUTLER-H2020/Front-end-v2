<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'Admin',
                'surname' => 'User',
                'email' => 'admin@cutler.com',
                'group_id' => 1,
                'is_online' => 0,
                'ip_address' => '127.0.0.1',
                'email_verified_at' => NULL,
                'password' => '$2y$10$VW5gLjbNS1ExJuvlfqkwYOebsRayafQ/qGVguj62lX7OT8i5D0x3m',
                'remember_token' => NULL,
                'created_at' => '2020-03-20 08:00:27',
                'updated_at' => '2020-07-09 12:08:22',
            ),
            1 => 
            array (
                'id' => 5,
                'name' => 'Sampas',
                'surname' => 'Admin',
                'email' => 'sampas@cutler.com',
                'group_id' => 1,
                'is_online' => 0,
                'ip_address' => '127.0.0.1',
                'email_verified_at' => NULL,
                'password' => '$2y$10$BryyO.XF8gkeGDNDeNnxI./G2c8vj506maTKzUZXTzZMXwwpuPA0y',
                'remember_token' => NULL,
                'created_at' => '2020-07-09 12:08:15',
                'updated_at' => '2020-07-09 12:08:34',
            ),
        ));
        
        
    }
}