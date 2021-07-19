<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PubController extends AbstractController
{
    /**
     * @Route("/pub", name="pub")
     */
    public function index(): Response
    {
        return $this->render('pub/index.html.twig', [
            'controller_name' => 'PubController',
        ]);
    }
}
