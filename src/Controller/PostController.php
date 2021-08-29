<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostController extends AbstractController
{
    /**
     * @Route("/registrar-post", name="registrarpost")
     */
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        // dd($this->getUser()->getNombre());
        $post = new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            # Tratamiento de la imagen
            $fotoFile = $form->get('foto')->getData();

            if ($fotoFile) {
                $originalFilename = pathinfo($fotoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fotoFile->move(
                        $this->getParameter('fotopost_directory'), #Parámetro de directorio, se configura en services.yaml
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new Exception('Ups! Ha ocurrido un error '.$e->getMessage());
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setFoto($newFilename);
            }

            # Obteniendomcredenciales del user
            $user = $this->getUser();
            $post->setUser($user);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('exito',Post::REGISTRO_EXITOSO);
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
            'name' => $this->getUser()->getNombre()
        ]);
    }

    /**
     * @Route("/ver-post/{id}", name="verpost")
     */
    public function verPost($id) {
        $post = $this->getDoctrine()->getManager()->getRepository(Post::class)->find($id);

        return $this->render('post/verpost.html.twig',[
            'post'=>$post,
        ]);
    }

    /**
     * @Route("/mis-post", name="mispost")
     */
    public function misPost() {
        $user = $this->getUser();
        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->findBy(['user'=>$user]);

        return $this->render('post/mispost.html.twig',[
            'post'=>$posts,
        ]);
    }
}
