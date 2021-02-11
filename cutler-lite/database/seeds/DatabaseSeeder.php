<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserGroupsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
//        $this->call(PoliciesTableSeeder::class);
        $this->call(KibanaWidgetsTableSeeder::class);
        $this->call(LanguageSettingsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
    }
}
