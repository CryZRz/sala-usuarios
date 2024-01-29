<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Loan;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * El diseño original tenía borrado lógico con las columnas status y endTime
         * se eliminaron para implementar el borrado suave de Laravel con SoftDelete.
         * Se eliminan created_at y updated_at para personalizar sus nombres.
         */
         Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(["status", "startTime", "endTime", "created_at", "updated_at"]);
        });

        /**
         * Borrado suave con SoftDelete; columnas del tiempo al crear y actualizar,
         * con los nombres personalizados en las constantes, definidas en el modelo de la tabla.
         */
        Schema::table('loans', function (Blueprint $table) {
            $table->timestamp(Loan::CREATED_AT)->nullable(); 
            $table->timestamp(Loan::UPDATED_AT)->nullable(); 
            $table->softDeletes(Loan::DELETED_AT);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(["startTime", "endTime", "updateTime"]); 
        });

        Schema::table('loans', function (Blueprint $table) { 
            $table->dateTime("startTime");
            $table->dateTime("endTime")->nullable();
            $table->boolean("status");
            $table->timestamps();
        });
    }
};
