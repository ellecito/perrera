<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnimalController extends Controller{
    /**
     * @Route("/animal", name="animal")
     */
    public function indexAction(Request $request){
        return $this->render('default/animal.html.twig', [
            'title' => 'Animal'
        ]);
    }

    /**
     * @Route("/animal/create", name="create")
     */
    public function createAction(Request $request){
        if($request->getMethod() === 'POST'){
            echo $request->request->get('email');
        }else{
            return $this->render('default/add_animal.html.twig', [
                'title' => 'Agregar Animal'
            ]);
        }
    }
}
