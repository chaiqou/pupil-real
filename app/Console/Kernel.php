<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('auth:clear-resets')->everyThirtyMinutes();
        $schedule->command('portal:request-paid-proformas')->everyTwoMinutes();
        $schedule->command('portal:check-billingo-api-key')->everyMinute();
        $schedule->command('portal:create-invoice-for-missing-transactions')->everyTwoMinutes();
        $schedule->command('portal:user-partnerid-data-check')->daily();
        $schedule->command('portal:merchant-billingo-data-check')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
