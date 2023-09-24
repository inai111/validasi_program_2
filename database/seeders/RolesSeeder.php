<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'administrative',
                'name_code' => 'admin',
                'description' => 'Administrative',
            ],
            [
                'name' => 'kepala bagian',
                'name_code' => 'kabag',
                'description' => 'Kepala Bagian',
            ],
            [
                'name' => 'direksi',
                'name_code' => 'direct',
                'description' => 'Direksi',
            ],
            [
                'name' => 'staff',
                'name_code' => 'staff',
                'description' => 'Staff',
            ],
        ]);

        for ($i = 0; $i < 25; $i++) {
            $data [] = [
                'user_id' => fake()->numberBetween(1, 30),
                'role_id' => fake()->numberBetween(1, 4),
            ];
        }
        DB::table('user_role')->insert($data);
    }
}
