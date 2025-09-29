<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PorgramsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 100; $i++) {
            Program::create([
                "name" => $faker->word,
                "version" => $i+2,
            ]);
        }
    }
}
