<?php

namespace App\Controller;

use App\Form\CalendarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CalendarType::class,null,[
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Process the form submission
            // For example, you can persist data to the database

            // Redirect to another page after successful form submission
            die('here');
            return $this->redirectToRoute('success_route');
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function navMain(): Response
    {
        return $this->render('components/_nav.html.twig');
    }
}
