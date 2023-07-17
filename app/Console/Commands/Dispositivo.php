<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Service;
use App\Http\Controllers\DispositivoController;
class Dispositivo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispositivo:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check services status crob jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new DispositivoController())->checkStatus();
    }
}
