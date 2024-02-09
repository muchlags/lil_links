<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(){
        // die("test");
        return $this->render('home/homepage.html.twig', [
            'title' => 'Home',
        ]);

    }

}