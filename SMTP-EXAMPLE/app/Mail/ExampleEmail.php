<?php

namespace App\Mail;

        use Illuminate\Bus\Queueable;
        use Illuminate\Mail\Mailable;
        use Illuminate\Queue\SerializesModels;
        use MailerSend\LaravelDriver\MailerSendTrait;

        class ExampleEmail extends Mailable
        {
            use Queueable, SerializesModels, MailerSendTrait;

            public function build()
            {
                return $this->view('MailSended')
                            ->subject('Teste de envio Gmail SMTP');
            }
        }
