<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; #Agregar para los request
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; #Encriptar pw

class RegistroController extends AbstractController
{

    private $encoder;

    /* public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    } */

    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {        
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $em = $this->getDoctrine()->getManager();
            //Desde el entity se puede setear con los métodos de set
            /* $user->setBaneado(false); //No se pasa x form
            $user->setRoles(['ROLE_USER']); //No se pasa x form */
            $user->setPassword($passwordEncoder->encodePassword($user,$form['password']->getData()));
            # Otra forma de encriptar
            // $user->setPassword(password_hash($form['password']->getData(),PASSWORD_DEFAULT));

            $em->persist($user);
            $em->flush();
            $this->addFlash('exito',User::REGISTRO_EXITOSO);
            return $this->redirectToRoute('registro');
        }
        
        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario'=>$form->createView()
        ]);
    }
    /**
     * @Route("/registro1", name="registro1")
     */
    public function registro1(): string
    {
        echo "Hello";
        dd('holita'); //Al hacerlo de esta forma hay que indicar una saluida o Symfony arroja errores

    }
}
