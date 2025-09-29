<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddRoleToUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $role = Role::where("name", "SysAdmin")->first();
        $user->roles()->attach($role->id,[
            "created_by" => 1,
        ]);
    }
}
