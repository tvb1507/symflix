<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/about", name="app_about")
     */
    public function about(): Response
    {

        return $this->render('default/about.html.twig');
    }
}
