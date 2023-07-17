<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorreoResponsable extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $dispositivo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje,$dispositivo)
    {
        $this->mensaje = $mensaje;
        $this->dispositivo = $dispositivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg= $this->mensaje;
        $dvc = $this->dispositivo;
        return $this->view('Correos.correoResponsable',compact('msg','dvc'));
    }
}
