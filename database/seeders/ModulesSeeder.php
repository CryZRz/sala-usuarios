<?php

namespace Database\Seeders;

use App\Models\AppModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'id' => 1,
                'name' => 'incidences',
                'display_name' => 'Incidencias',
                'description' => 'Modulo de manejo de incidencias de los alumnos en la sala de usuarios',
                'is_active' => 1,
            ],
            [
                'id' => 2,
                'name' => 'students',
                'display_name' => 'Estudiantes',
                'description' => 'Modulo para la informacion de los estudiantes',
                'is_active' => 1,
            ],
            [
                'id' => 3,
                'name' => 'computer',
                'display_name' => 'Computadoras',
                'description' => 'Modulo para manejo de computadoras ',
                'is_active' => 1,
            ],
            [
                'id' => 4,
                'name' => 'program',
                'display_name' => 'Programas',
                'description' => 'Modulo para manejo de programas de las computadoras',
                'is_active' => 1,
            ],
            [
                'id' => 5,
                'name' => 'ports',
                'display_name' => 'Puertos',
                'description' => 'Modulo para menejo de puerto de las computadoras',
                'is_active' => 1,
            ],
            [
                'id' => 6,
                'name' => 'computerUses',
                'display_name' => 'Usos de computadoras',
                'description' => 'Modulo para manejo de los usos de las computadoras',
                'is_active' => 0,
            ],
            [
                'id' => 7,
                'name' => 'computerSession',
                'display_name' => 'Sesiones de computadoras',
                'description' => 'Modulo para manejo de prestamo de computadoras',
                'is_active' => 1,
            ],
            [
                'id' => 8,
                'name' => 'importStudents',
                'display_name' => 'Importar Estudiantes',
                'description' => 'Modulo para la carga de estudiantes',
                'is_active' => 1,
            ],
            [
                'id' => 9,
                'name' => 'sessionsReports',
                'display_name' => 'Reporte de sesiones',
                'description' => 'Modulo para genrar reportes de sesiones',
                'is_active' => 0,
            ],
            [
                'id' => 10,
                'name' => 'roleManager',
                'display_name' => 'Roles',
                'description' => 'Modulo para manejo de roles',
                'is_active' => 1,
            ],
            [
                'id' => 11,
                'name' => 'computerSessionHistory',
                'display_name' => 'Historial de sesiones',
                'description' => 'Consulta del historial de sesiones',
                'is_active' => 1,
            ],
            [
                'id' => 12,
                'name' => 'users',
                'display_name' => 'Usuarios',
                'description' => 'Modulo para manejo de usuarios',
                'is_active' => 1,
            ],
        ];

        foreach ($modules as $module) {
            AppModule::create($module);
        }
    }
}
