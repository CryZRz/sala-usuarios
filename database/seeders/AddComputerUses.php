<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;
use Psy\Util\Str;

class AddComputerUses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        Application::create([
            "name" => "General",
        ]);
    }
}
