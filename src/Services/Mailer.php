<?php

namespace App\Services;

use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class Mailer {


    /**
     * @var MailerInterface
     */

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($email , $token)
    
    {
        $email = (new TemplatedEmail())
        ->from('yoann.corsi@gmail.com')

        ->to($email)
        ->subject('Valider votre inscription')
    
        ->htmlTemplate('security/email.html.twig')
        ->context([
            'token' => $token,
        ]);

             $this->$mailer->send($email);
    }
}