<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** Adición de la tabla student_updates para registrar las actualizaciones de los datos de estudiantes.
     * Eliminado de las columnas repetidas en la nueva tabla y students.
     * Adición de la columna foránea student_update que indica los datos del alumno válidos para el préstamo. 
    */
    public function up(): void
    {
        Schema::create('student_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained()->onDelete("cascade");
            $table->string("controlNumber");
            $table->string("career");
            $table->smallInteger("semester");
            $table->timestamp("created_at");
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                "controlNumber",
                "career",
                "semester"
            ]);
        });

        Schema::table('loans', function (Blueprint $table){
            $table->foreignId("student_update_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Revertir la creación de la tabla student_updates 
        Schema::dropIfExists('student_updates');
        //Revertir las columnas eliminadas de la tabla students
        Schema::table('students', function (Blueprint $table){
            $table->string("controlNumber");
            $table->string("career");
            $table->integer("semester");
        });
        //Revertir la columna foránea de la tabla student_updates en la tabla loans
        Schema::table('loans', function (Blueprint $table){
            $table->dropColumn("student_update_id");
        });
    }
};
