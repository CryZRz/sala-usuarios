<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ["id"=>1,"name"=>"incidences.view","description"=>"Ver incidencias","created_by"=>1,"module_id"=>1,"display_name"=>"Ver incidencias"],
            ["id"=>2,"name"=>"incidences.edit","description"=>"Actualizar incidencias","created_by"=>1,"module_id"=>1,"display_name"=>"Actualizar incidencias"],
            ["id"=>3,"name"=>"incidences.delete","description"=>"Eliminar incidencias","created_by"=>1,"module_id"=>1,"display_name"=>"Eliminar incidencias"],
            ["id"=>5,"name"=>"student.view","description"=>"Ver informacion de los estudiantes","created_by"=>1,"module_id"=>2,"display_name"=>"Ver listado de estudiantes"],
            ["id"=>6,"name"=>"student.create","description"=>"Crear un estudiante","created_by"=>1,"module_id"=>2,"display_name"=>"Crear estudiante"],
            ["id"=>7,"name"=>"computer.view","description"=>"Ver las computadoras","created_by"=>1,"module_id"=>3,"display_name"=>"Ver listado de computadoras"],
            ["id"=>8,"name"=>"computer.create","description"=>"Crear nuevas computadoras","created_by"=>1,"module_id"=>3,"display_name"=>"Crear computadoras"],
            ["id"=>9,"name"=>"computer.update","description"=>"Actulizar las computadoras","created_by"=>1,"module_id"=>3,"display_name"=>"Actulizar computadoras"],
            ["id"=>10,"name"=>"computer.delete","description"=>"Eliminar las computadoras","created_by"=>1,"module_id"=>3,"display_name"=>"Eliminar computadoras"],
            ["id"=>11,"name"=>"program.view","description"=>"Ver los programas","created_by"=>1,"module_id"=>4,"display_name"=>"Ver programas"],
            ["id"=>12,"name"=>"program.create","description"=>"Crear los programas","created_by"=>1,"module_id"=>4,"display_name"=>"Crear programas"],
            ["id"=>13,"name"=>"program.update","description"=>"Actualizar los programas","created_by"=>1,"module_id"=>4,"display_name"=>"Actualizar programas"],
            ["id"=>14,"name"=>"program.delete","description"=>"Eliminar los programas","created_by"=>1,"module_id"=>4,"display_name"=>"Eliminar programas"],
            ["id"=>15,"name"=>"ports.create","description"=>"Crear puertos","created_by"=>1,"module_id"=>5,"display_name"=>"Crear puertos"],
            ["id"=>16,"name"=>"computerUses.create","description"=>"Crear tipos de uso de una computadora","created_by"=>1,"module_id"=>6,"display_name"=>"Crear tipos de uso "],
            ["id"=>17,"name"=>"computerUses.view","description"=>"Ver tipos de uso de una computadora","created_by"=>1,"module_id"=>6,"display_name"=>"Ver tipos de uso"],
            ["id"=>18,"name"=>"computerSession.view","description"=>"Ver las sesiones de uso de las computadoras","created_by"=>1,"module_id"=>7,"display_name"=>"Ver sesiones"],
            ["id"=>19,"name"=>"computerSession.create","description"=>"Crear sesiones de uso de las computadoras","created_by"=>1,"module_id"=>7,"display_name"=>"Crear sesiones"],
            ["id"=>20,"name"=>"computerSession.update","description"=>"Editar sesiones de uso de las computadoras","created_by"=>1,"module_id"=>7,"display_name"=>"Editar sesiones "],
            ["id"=>21,"name"=>"computerSession.delete","description"=>"Eliminar sesiones de uso de las computadoras","created_by"=>1,"module_id"=>7,"display_name"=>"Terminar sesiones"],
            ["id"=>22,"name"=>"student.update","description"=>"Editar estudiantes","created_by"=>1,"module_id"=>2,"display_name"=>"Editar estudiantes"],
            ["id"=>23,"name"=>"ports.update","description"=>"Actulizar los puertos de un equipo","created_by"=>1,"module_id"=>5,"display_name"=>"Actulizar puertos de un equipo"],
            ["id"=>24,"name"=>"ports.delete","description"=>"Eliminar los puertos de un equipo","created_by"=>1,"module_id"=>5,"display_name"=>"Eliminar puertos de un equipo"],
            ["id"=>25,"name"=>"student.consult","description"=>"Consultar informacion de los estudiantes","created_by"=>1,"module_id"=>2,"display_name"=>"Consultar informacion de estudiante"],
            ["id"=>26,"name"=>"incidences.create","description"=>"Creacion de incidencias","created_by"=>1,"module_id"=>1,"display_name"=>"Crear incidencias"],
            ["id"=>27,"name"=>"importStudents.import","description"=>"Importar alumnos a la aplicacion","created_by"=>1,"module_id"=>8,"display_name"=>"Importar alumnos"],
            ["id"=>28,"name"=>"incidences.detail","description"=>"Ver detalle de las incidencias","created_by"=>1,"module_id"=>1,"display_name"=>"Detalle de las incidencias"],
            ["id"=>29,"name"=>"sessionsReports.generate","description"=>"Generar reportes de sesiones","created_by"=>1,"module_id"=>9,"display_name"=>"Generar reportes de sesiones"],
            ["id"=>30,"name"=>"roleManager.create","description"=>"Creacion de roles","created_by"=>1,"module_id"=>10,"display_name"=>"Crear roles"],
            ["id"=>31,"name"=>"roleManager.view","description"=>"Listado de roles","created_by"=>1,"module_id"=>10,"display_name"=>"Ver listado de roles"],
            ["id"=>32,"name"=>"computerSessionHistory.history","description"=>"Lista de historial de sesiones","created_by"=>1,"module_id"=>11,"display_name"=>"Ver historial de sesiones"],
            ["id"=>33,"name"=>"ports.view","description"=>"Ver lista de puerto","created_by"=>1,"module_id"=>5,"display_name"=>"Ver listado de puertos"],
            ["id"=>34,"name"=>"roleManager.edit","description"=>"Editar permisos de los roles","created_by"=>1,"module_id"=>10,"display_name"=>"Editar roles"],
            ["id"=>35,"name"=>"computerUses.consult","description"=>"Consultar tipos de uso de una computadora","created_by"=>1,"module_id"=>6,"display_name"=>"Consultar tipos de uso"],
            ["id"=>36,"name"=>"computer.consult","description"=>"Consultar computadoras","created_by"=>1,"module_id"=>3,"display_name"=>"Consultar computadoras"],
            ["id"=>37,"name"=>"users.edit","description"=>"Editar usuarios","created_by"=>1,"module_id"=>12,"display_name"=>"Editar usuarios"],
            ["id"=>38,"name"=>"users.changePassword","description"=>"Cambiar contraseña de los usuarios","created_by"=>1,"module_id"=>12,"display_name"=>"Cambiar contraseña a usuarios"],
            ["id"=>39,"name"=>"users.viewRoles","description"=>"Ver roles de un usuario","created_by"=>1,"module_id"=>12,"display_name"=>"Ver roles de usuarios"],
            ["id"=>40,"name"=>"users.addRoles","description"=>"Añadir roles a un usuario","created_by"=>1,"module_id"=>12,"display_name"=>"Añadir roles a un usuario"],
            ["id"=>41,"name"=>"users.removeRoles","description"=>"Remover roles a un usuario","created_by"=>1,"module_id"=>12,"display_name"=>"Remover roles a un usuario"],
            ["id"=>42,"name"=>"users.create","description"=>"Crear usuarios","created_by"=>1,"module_id"=>12,"display_name"=>"Crear usuarios"],
            ["id"=>43,"name"=>"computerUses.edit","description"=>"Editar tipos de uso de una computadora","created_by"=>1,"module_id"=>6,"display_name"=>"Editar tipos de uso "],
            ["id"=>44,"name"=>"computerUses.delete","description"=>"Elimar tipos de uso de una computadora","created_by"=>1,"module_id"=>6,"display_name"=>"Elimnar tipos de uso "],
            ["id"=>45,"name"=>"users.view","description"=>"Ver listado usuarios","created_by"=>1,"module_id"=>12,"display_name"=>"Ver listado usuarios"],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
