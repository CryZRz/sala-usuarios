<?php

namespace App\Console\Commands;

use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GeneratePeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-period';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el periodo en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        if ($month >= 1 && $month < 7) {
            Period::create([
                "name" => "ENERO-JUNIO-$year"
            ]);
        }
        else if ($month >= 7 && $month < 8) {
            Period::create([
                "name" => "JUNIO-JULIO-$year"
            ]);
        }else{
            Period::create([
                "name" => "AGOSTO-DICIEMBRE-$year"
            ]);
        }
    }
}
