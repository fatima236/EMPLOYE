<?php
// src/Controller/SubscribeController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscribeController extends AbstractController
{
    public function subscribe(Request $request, MailerInterface $mailer): Response
    {
        $email = $request->request->get('email');

        if ($email) {
            // Créer l'email
            $emailMessage = (new Email())
                ->from('no-reply@yourdomain.com')
                ->to($email)
                ->subject('Merci pour votre abonnement!')
                ->text('Vous êtes désormais abonné à notre newsletter.');

            // Envoyer l'email via Mailtrap
            $mailer->send($emailMessage);
        }

        return $this->json(['message' => 'Merci pour votre abonnement!']);
    }
}
