<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistroUsuarioController extends AbstractController
{
    public function registro(): Response
    {
        return $this->render('registro_usuario/index.html.twig', [
            'controller_name' => 'RegistroUsuarioController',
        ]);
    }
}
