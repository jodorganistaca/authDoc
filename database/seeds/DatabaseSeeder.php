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
        // $this->call(UsersTableSeeder::class);

        DB::table('admins')->insert([
            'name' => 'Daniel Admin',
            'email' => 'daniel@adm.com.br',
            'password' => Hash::make('1235678'),
            
        ]);
    }
}
