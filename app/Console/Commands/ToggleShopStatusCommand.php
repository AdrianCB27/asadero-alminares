<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class ToggleShopStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tienda:cambiar-estado {status}';
    protected $description = 'Activa o desactiva la vista de la tienda.';

    public function handle()
    {
        $status = $this->argument('status');

        $setting = Setting::firstOrCreate([]);
        $setting->show_client_view = (bool) $status;
        $setting->save();

        $this->info('El estado de la tienda ha sido cambiado a: ' . ($status ? 'activado' : 'desactivado'));
    }
}
