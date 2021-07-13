<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id_role' => 1,
            'nama' => 'Super Admin CAPITAL',
            'email' => 'admin',
            'password' => bcrypt('admin')
        ]);
    }
}
