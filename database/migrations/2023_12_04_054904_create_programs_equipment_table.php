<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId("program_id")->constrained()->onDelete("cascade");
            $table->unsignedBigInteger("equipment_id");
            $table->foreign("equipment_id")->references("id")->on("equipments");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs_equipment');
    }
};
