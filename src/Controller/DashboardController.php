<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;



use App\Entity\Post;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        # SEGURIDAD NO RECOMENDADA
        /* if(!$this->getUser())
            return $this->redirectToRoute('app_login'); */
        // $em = $this->getDoctrine()->getManager();
        // $posts = $em->getRepository(Post::class)->findAll(); #Se reemplazará con la query e más abajo
        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->todosLosPost(); 
        // $posts = $this->getDoctrine()->getRepository(Post::class)->todosLosPost1();
        // $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->todosLosPost2();
        // $posts = $this->getDoctrine()->getRepository(Post::class)->todosLosPost3();

        // dd($posts);

        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('dashboard/index.html.twig', [
            'name' => $this->getUser()->getNombre(),
            'posts'=>$pagination,
        ]);
    }

    /**
     * @Route("/dashboard/hola", name="dashboard-hola")
     */
    public function hola()
    {
        return $this->render('dashboard/hola.html.twig');
    }
}
