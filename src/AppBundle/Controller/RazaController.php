<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Raza;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RazaController extends Controller{
    /**
     * @Route("/raza/", name="raza")
     */
    public function indexAction(Request $request){
        $repository = $this->getDoctrine()->getRepository(Raza::class);

        return $this->render('default/razas.html.twig', [
            'title' => 'Razas',
            'razas' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/raza/create/", name="raza-create")
     */
    public function createAction(Request $request){
        if($request->getMethod() === 'POST'){
            $raza = new Raza();
            $raza->setName($request->request->get('nombre'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($raza);
            $em->flush();

            return new Response(
                'Se guardo una raza nueva, perkin culiao: '.$raza->getId()
            );
        }else{
            return $this->render('default/add_raza.html.twig', [
                'title' => 'Agregar Raza'
            ]);
        }
    }
}
