<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
   protected function schedule(Schedule $schedule): void
{
    // Activar tienda domingo a jueves a las 18:30
    $schedule->command('tienda:cambiar-estado', ['status' => 1])
             ->dailyAt('18:30')
             ->days([0, 1, 2, 3, 4]);

    // Desactivar tienda lunes a viernes a las 11:30
    $schedule->command('tienda:cambiar-estado', ['status' => 0])
             ->dailyAt('11:30')
             ->days([1, 2, 3, 4, 5]);
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
