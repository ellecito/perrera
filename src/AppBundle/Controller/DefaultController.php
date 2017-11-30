<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($request->getMethod() === "POST"){
            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $usuario = $repository->findOneBy(
                array('email' => $request->request->get('email'), 'password' => md5($request->request->get('password')))
            );

            if (!$usuario) {
                throw $this->createNotFoundException(
                    'Error al iniciar sesion'
                );
            }else{
                $session = $request->getSession();
                $session->start();
                $session->set('usuario', $usuario);          
            }
        
        }else{
            return $this->render('default/index.html.twig', [
                'title' => 'Login',
                'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            ]);
        }
    }
}
