<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert(
            array(
                'name' => 'Administración',
                'email' => 'sala@leon.tecnm.mx',
                'password' => Hash::make('salausuarios')
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
