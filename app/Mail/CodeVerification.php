<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeVerification extends Mailable
{
    use Queueable, SerializesModels;

    private $verificationCode; // Nueva propiedad para almacenar el código

    /**
     * Create a new message instance.
     *
     * @param string $code El código de verificación
     */
    public function __construct($code)
    {
        $this->verificationCode = $code; // Asigna el código
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.Verificate_email')->with([
            'verificationCode' => $this->verificationCode, // Pasa el código a la vista
        ]);
    }
}
