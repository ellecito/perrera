<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Raza;
use AppBundle\Entity\Animal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnimalController extends Controller{
    /**
     * @Route("/animal/", name="animal")
     */
    public function indexAction(Request $request){
        return $this->render('default/animal.html.twig', [
            'title' => 'Animal'
        ]);
    }

    /**
     * @Route("/animal/create/", name="animal-create")
     */
    public function createAction(Request $request){
        $repository = $this->getDoctrine()->getRepository(Raza::class);
        if($request->getMethod() === 'POST'){
            $animal = new Animal();
            $animal->setName($request->request->get('nombre'));
            $animal->setPrice($request->request->get('precio'));
            $animal->setDescription($request->request->get('descripcion'));
            $animal->setAge($request->request->get('edad'));
            $animal->setPicture($request->request->get('foto'));
            $animal->setRaza($repository->find($request->request->get('raza')));

            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();

            return new Response(
                'Se guardo un nuevo animal, perkin culiao: '.$animal->getId()
            );
        }else{
            return $this->render('default/add_animal.html.twig', [
                'title' => 'Agregar Animal',
                'razas' => $repository->findAll()
            ]);
        }
    }
}
