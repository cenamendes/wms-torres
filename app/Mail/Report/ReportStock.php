<?php

namespace App\Mail\Report;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportStock extends Mailable
{
    use Queueable, SerializesModels;
    public $quantidadeCorreta;
    public $observacoes;
    public $report_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quantidadeCorreta, $observacoes, $report_email)
    {
        $this->quantidadeCorreta = $quantidadeCorreta;
        $this->observacoes = $observacoes;
        $this->report_email = $report_email;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $subject = 'Reportado com Sucesso.';
        return new Envelope(
            subject: $subject,
            //session('email')
            //usar este a serio from: new Address(env('MAIL_USERNAME'), session('sender_name')),
            from: new Address(env('MAIL_TESTE'), session('sender_name')),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    // public function attachments()
    // {
    //     return [];
    // }

    public function build()
    {
        $subject = 'Conta criada com sucesso.';

        $email = $this
            ->view('tenant.mail.emailReport', [
                "subject" => $subject,
                "quantidadeCorreta" => $this->quantidadeCorreta,
                "observacoes" => $this->observacoes,
                "company_name" => session('company_name'),
                "vat" => session('vat'),
                "contact" => session('contact'),
                "email" => session('email'),
                "address" => session('address'),
                "logotipo" => session('logotipo'),
            ])
            ->to($this->report_email);

        return $email;
    }

}
