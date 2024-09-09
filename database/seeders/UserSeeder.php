<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            "name" => env("DEFAULT_ADMIN_NAME"),
            "email" => env("DEFAULT_ADMIN_EMAIL"),
            "password" => Hash::make(env("DEFAULT_ADMIN_PASSWORD")),
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}
