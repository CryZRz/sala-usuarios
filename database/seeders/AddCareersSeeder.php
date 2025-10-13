<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddCareersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $careers = [
            [
                "name" => "Ingeniería Electrónica",
                "key" => "IELC-2010-211"
            ],
            [
                "name" => "Ingeniería Electromecánica",
                "key" => "IEME-2010-210"
            ],
            [
                "name" => "Ingeniería en Gestión Empresarial",
                "key" => "IGEM-2009-201"
            ],
            [
                "name" => "Ingeniería Industrial",
                "key" => "IIND-2010-227"
            ],
            [
                "name" => "Ingeniería en Logística",
                "key" => "ILOG-2009-202"
            ],
            [
                "name" => "Ingeniería Mecatrónica",
                "key" => "IMCT-2010-229"
            ],
            [
                "name" => "Ingeniería en Sistemas Computacionales",
                "key" => "ISIC-2010-224"
            ],
            [
                "name" => "Ingeniería en Tecnologías de la Información y Comunicaciones",
                "key" => "ITIC-2010-225"
            ],
            [
                "name" => "MAESTRÍA EN CIENCIAS DE LA COMPUTACIÓN",
                "key" => "MCCOM-2011-05"
            ],
            [
                "name" => "MAESTRÍA EN CIENCIAS DE LA INGENIERÍA",
                "key" => "MCING-2011-45"
            ],
        ];

        foreach ($careers as $career) {
            Career::create($career);
        }
    }
}
