<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'id' => 1,
                'role' => 'Super Admin'
            ],
            [
                'id' => 2,
                'role' => 'Admin'
            ],
            [
                'id' => 3,
                'role' => 'User'
            ]
        ];
        foreach ($data as $dt) {
            Role::create($dt);
        }
    }

}
