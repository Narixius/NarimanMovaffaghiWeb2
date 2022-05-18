<?php

namespace App\Controller;


use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class MessageController extends AbstractController
{
    #[Route('/', name: 'app_contact', methods: ['POST', 'GET'])]
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_contact_new', methods: ['POST', 'GET'])]
    public function new(Request $request, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageRepository->add($message, true);
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView()
        ]);

    }

    #[Route('/{id}', name: 'app_contact_find', methods: ['POST', 'GET'])]
    public function findOne(Message $message,  MessageRepository $messageRepository): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message
        ]);
    }

}
