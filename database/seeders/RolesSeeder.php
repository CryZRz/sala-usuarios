<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            "name" => "SysAdmin",
            "description" => "Administrador",
        ]);

        //Esto puede llegar a ser costoso
        $permissions = Permission::all()->pluck('id')->mapWithKeys(function ($id) {
            return [$id => ['created_by' => 1]];
        })->toArray();

        $role->permissions()->sync($permissions);
    }
}
