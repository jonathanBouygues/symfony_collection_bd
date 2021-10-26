<?php


namespace App\Controller;

use App\Form\ContactType;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {

        $form = $this->createForm(ContactType::class);
        $data = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from($data->get('email')->getViewData())
                ->to('jonathanbouygues@yahoo.fr')
                ->subject($data->get('subject')->getViewData())
                ->htmlTemplate('contact/content_email.html.twig')
                ->context([
                    // ne pas utiliser "email" dans context (interdit)
                    'mail' => $data->get('email')->getViewData(),
                    'message' => $data->get('message')->getViewData()
                ]);

            // dump($email);

            $mailer->send($email);
        }


        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView(),
            'controller_name' => 'Contact par mail',
        ]);
    }
}
