<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;

class ContactNotification
{    
    /**
     * @var \Swift_Mailer 
     */
    private $mailer;    

    /**
     * @var Environment
     */
    private $renderer;

   
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    public function notify(Contact $contact){
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
            ->setFrom('noreply@ulrichnelson.fr')
            ->setTo('contact@responsable.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
            $this->mailer->send($message);
    }


    /*public function notify(Contact $contact){
        $message = (new TemplatedEmail())
            ->subject('Agence : ' . $contact->getProperty()->getTitle())
            ->from('monsite@ulrich-nelson.fr')
            ->to(new Address($contact->getEmail()))
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);
            $this->mailer->send($message); */

     /*public function notify(Contact $contact){
        $message = (new TemplatedEmail())
            ->subject('Agence : ' . $contact->getProperty()->getTitle())
            ->from('ulrich-nelson.fr')
            ->to(new Address($contact->getEmail()))
            ->htmlTemplate('emails/contact.html.twig', [
                'contact' => $contact
            ]);
    }*/
}
