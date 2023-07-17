<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sistema;
class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing crob jobs';

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
        $dispositivo = DB::table('dispositivo')
            ->get();
        foreach($dispositivo as $device)
        {
            echo "bien";
            $services = DB::table('dispositivo_servicio')
                ->join('servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->where('dispositivo_servicio.id_dispositivo','=',$device->id)
                ->select('servicio.*','dispositivo_servicio.mensaje','dispositivo_servicio.id as id_dispositivo_servicio')
                ->get();

            foreach ($services as $servicios)
            {
                $comando=DB::table('comando_servicio')
                    ->select('descripcion')
                    ->where('id','=',$servicios->id_comando)
                    ->get();
                $comando=$comando->first();
                $estatus_old = $servicios->mensaje;
                $response=shell_exec($comando->descripcion." -H ".$device->ip);

                if (strcmp($estatus_old,$response)==!0)
                {

                    $historico= new Historico();
                    $historico-> id_dispositivo_servicio = $servicios->id_dispositivo_servicio;
                    $historico->fecha = now();
                    $historico->estatus = "Critico";
                    $historico->mensaje = $response;
                    $historico->save();
                    echo $servicios->nombre.$response."\n";
                }
            }
        }
    }
}
