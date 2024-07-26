<?php

namespace App\Console\Commands;

use App\Interfaces\FlightDataImportInterface;
use Illuminate\Console\Command;

class ImportFlightData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-flight-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handles importing flight data';

    /**
     * Execute the console command.
     */
    public function handle(FlightDataImportInterface $importService): void
    {
        $importService->import();
    }
}
