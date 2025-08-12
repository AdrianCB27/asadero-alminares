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
        // Activa la tienda todos los días a las 6:30 PM (18:30)
        $schedule->command('tienda:cambiar-estado', ['status' => 1])->dailyAt('18:30');

        // Desactiva la tienda todos los días a las 11:30 AM (11:30)
        $schedule->command('tienda:cambiar-estado', ['status' => 0])->dailyAt('11:30');
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
