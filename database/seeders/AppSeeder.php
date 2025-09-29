<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ModulesSeeder::class,
            UserSeeder::class,
            PermissionsSeeder::class,
            PermissionDependenciesSeeder::class,
            RolesSeeder::class,
            AddRoleToUser::class,
            AddComputerUses::class,
        ]);
    }
}
