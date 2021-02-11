<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'kibana_ip' => 'http://92.45.59.250',
                'kibana_port' => '5601',
                'kibana_username' => 'elastic',
                'kibana_pass' => 'C@tler2020',
                'kibana_widget_url' => 'http://92.45.59.250:8000/kibana',
                'kafka_ip' => 'deneme',
                'kafka_port' => 'deneme',
                'kafka_topic' => 'deneme',
                'camunda_ip' => '92.45.59.250',
                'camunda_port' => '8004',
                'camunda_username' => NULL,
                'camunda_pass' => NULL,
                'maps_iframe_url' => 'https://cutler-app.azurewebsites.net/',
                'smtp_server_name' => 'deneme',
                'smtp_port_number' => 'deneme',
                'smtp_username' => 'deneme',
                'smtp_pass' => 'deneme',
                'login_bg' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-07 13:51:45',
            ),
        ));
        
        
    }
}