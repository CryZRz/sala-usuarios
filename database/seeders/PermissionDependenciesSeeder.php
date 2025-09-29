<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionDependenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dependencies = [
            [
                "id" => 1,
                "permission_id" => 19,
                "depends_on_permission_id" => 25,
            ],
            [
                "id" => 2,
                "permission_id" => 26,
                "depends_on_permission_id" => 25,
            ],
            [
                "id" => 3,
                "permission_id" => 19,
                "depends_on_permission_id" => 35,
            ],
            [
                "id" => 4,
                "permission_id" => 19,
                "depends_on_permission_id" => 36,
            ],
            [
                "id" => 5,
                "permission_id" => 1,
                "depends_on_permission_id" => 5,
            ],
            [
                "id" => 6,
                "permission_id" => 32,
                "depends_on_permission_id" => 17,
            ],
            [
                "id" => 7,
                "permission_id" => 8,
                "depends_on_permission_id" => 11,
            ],
            [
                "id" => 8,
                "permission_id" => 8,
                "depends_on_permission_id" => 15,
            ],
            [
                "id" => 11,
                "permission_id" => 18,
                "depends_on_permission_id" => 25,
            ],
            [
                "id" => 13,
                "permission_id" => 18,
                "depends_on_permission_id" => 35,
            ],
            [
                "id" => 14,
                "permission_id" => 18,
                "depends_on_permission_id" => 7,
            ],
            [
                "id" => 15,
                "permission_id" => 20,
                "depends_on_permission_id" => 36,
            ],
            [
                "id" => 16,
                "permission_id" => 7,
                "depends_on_permission_id" => 36,
            ],
        ];

        foreach ($dependencies as $dependency) {
            Db::table('permission_dependencies')->insert($dependency);
        }
    }
}
