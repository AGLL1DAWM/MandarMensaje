<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Repository\ComentarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        //Recogemos los datos de los comentarios
        $nombre = $request->request->get("nombre");
        $email = $request->request->get("email");
        $texto = $request->request->get("comentario");

        //Declaramos un nuevo comentario
        $comentario = new Comentario();
        $comentario->setNombre($nombre);
        $comentario->setEmail($email);
        $comentario->setComentario($texto);

        //Guardamos el comentario
        // $this->em->getRepository(Comentario::class);
        $this->em->persist($comentario);
        $this->em->flush();

        // $this->SendMail($comentario);//Forma1

        // dump($comentario);die();

       //Mensaje de que ha ido correcto
        return new Response("Comentario Creado");
    }


    // public function SendMail(Comentario $comentario){
    //     $comentario
    // }

    public function SendMailByCommentId(int $commentId, MailerInterface $mailer){
        // $comment = $this->em->getRepository(Comentario::class)->find($commentId); Forma1
        //$comments = $this->em->getRepository(Comentario::class)->findAll();//Forma2
        $comment = $this->em->find(Comentario::class, $commentId); 


        if($comment === null){
            dump("no existe");die();
        }

        // Recuperamos los datos para el email
        $nombre = $comment->getNombre();
        $email = $comment->getEmail();
        $texto = $comment->getComentario();
        
        

        
        $newEmail = (new Email())
            ->from($email)
            ->to($email)
            ->subject('Comentario Creado')
            ->html(
                "<p>Hola $nombre</p>
                 <p>$texto</P>
                ");
            
        $mailer->send($newEmail);

        return new Response("Email Enviado");
    }
}

