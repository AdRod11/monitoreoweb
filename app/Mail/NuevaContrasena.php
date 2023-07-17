<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NuevaContrasena extends Mailable
{
    use Queueable, SerializesModels;

    public $correo;
    public $contrasena;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($correo,$contrasena)
    {
        $this->correo = $correo;
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Correos.nuevaContrasena');
    }
}
