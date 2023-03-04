<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private MailerInterface $mailer) {

    }
    public function sendEmail($to='achref.cha21rgui@gmail.com',$subject='Time for Symfony Mailer!',$content='<p>See Twig integration for better HTML integration!</p>'): void
    {
        $email = (new Email())
            ->from('PiDevTest21@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html($content);

        $this->mailer->send($email);

        // ...
    }
}