<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Repository\ComentarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ContactoController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    public function index(): Response
    {

        return $this->render('contacto/index.html.twig', [
            'controller_name' => 'ContactoController',
        ]);
    }

    public function CreateComment(Request $request){
        $nombre = $request->request->get("nombre");
        $email = $request->request->get("email");
        $texto = $request->request->get("comentario");

        $comentario = new Comentario();
        $comentario->setNombre($nombre);
        $comentario->setEmail($email);
        $comentario->setComentario($texto);

        // $this->em->getRepository(Comentario::class);
        $this->em->persist($comentario);
        $this->em->flush();

        $this->SendMail($comentario);//Forma1

        dump($comentario);die();

       return new Response("Comentario Creado");
    }


    public function SendMail(Comentario $comentario){
        
    }

    public function SendMailByCommentId(int $commentId){
        // $comment = $this->em->getRepository(Comentario::class)->find($commentId);
        $comments = $this->em->getRepository(Comentario::class)->findAll();
        
        dump($comments);die();
    }
}

