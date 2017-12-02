<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Raza;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Animal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class AnimalController extends Controller{
    /**
     * @Route("/animal/", name="animal")
     */
    public function indexAction(Request $request){

        if(!$request->getSession()->get('usuario')) return $this->redirectToRoute('homepage');

        return $this->render('default/animal.html.twig', [
            'title' => 'Animal',
            'animales' => $this->getDoctrine()->getRepository(Animal::class)->findBy(
                ['usuario' => $request->getSession()->get('usuario')->getId()]
            )
        ]);
    }

    /**
     * @Route("/animal/create/", name="animal-create")
     */
    public function createAction(Request $request){
        $repository = $this->getDoctrine()->getRepository(Raza::class);
        if($request->getMethod() === 'POST'){
            if($_FILES["foto"]["error"] !== 0){
                throw $this->createNotFoundException(
                    'Error al subir imagen'
                );
            }

            if($_FILES['foto']['name']==''){
                throw $this->createNotFoundException(
                    'Error al subir imagen'
                );
            }
            
            $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/';
			if(!file_exists($uploads_dir)){
				mkdir($uploads_dir,0777);
			}
			$uploads_dir .= "animales/";
			if(!file_exists($uploads_dir))
                mkdir($uploads_dir,0777);
                
            
			$extension = explode(".",$_FILES['foto']['name']);
			$extension = array_pop($extension);
			$extension = strtolower($extension);
			$permitidas = array("png","jpg", "jpeg"); #extensiones permitidas
			$name = 'animal_'.time();
			$tmp = $_FILES["foto"]["tmp_name"];
			
			if(!in_array($extension, $permitidas)){
                throw $this->createNotFoundException(
                    'Formato no permitido, solo se acepta png, jpg y jpeg.'
                );
			}
			
			move_uploaded_file($tmp, $uploads_dir.$name . "." . $extension);
			if(is_file($uploads_dir.$name . "." . $extension))
				chmod($uploads_dir.$name . "." . $extension, 0777);


            $animal = new Animal();
            $animal->setName($request->request->get('nombre'));
            $animal->setPrice($request->request->get('precio'));
            $animal->setDescription($request->request->get('descripcion'));
            $animal->setAge($request->request->get('edad'));
            $animal->setPicture('/assets/animales/' . $name. "." . $extension);
            $animal->setRaza($repository->find($request->request->get('raza')));
            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $animal->setUsuario($repository->find($request->getSession()->get('usuario')->getId()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($animal);
            $em->flush();

            return $this->redirectToRoute('animal');
        }else{
            return $this->render('default/add_animal.html.twig', [
                'title' => 'Agregar Animal',
                'razas' => $repository->findAll()
            ]);
        }
    }

    /**
     * @Route("/animal/update/{id}", name="animal-update"), requirements={"id": "\d+"})
     */
    public function updateAction(Request $request, $id = null){
        $repository = $this->getDoctrine()->getRepository(Raza::class);
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository(Animal::class)->find($id);
        if (!$animal) {
            throw $this->createNotFoundException(
                'No hay animal con ID: '.$id
            );
        }
    
        if($request->getMethod() === 'POST'){
            if($_FILES["foto"]["error"] === 0){
                if($_FILES['foto']['name']==''){
                    throw $this->createNotFoundException(
                        'Error al subir imagen'
                    );
                }
                
                $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/';
                if(!file_exists($uploads_dir)){
                    mkdir($uploads_dir,0777);
                }
                $uploads_dir .= "animales/";
                if(!file_exists($uploads_dir))
                    mkdir($uploads_dir,0777);
                    
                
                $extension = explode(".",$_FILES['foto']['name']);
                $extension = array_pop($extension);
                $extension = strtolower($extension);
                $permitidas = array("png","jpg", "jpeg"); #extensiones permitidas
                $name = 'animal_'.time();
                $tmp = $_FILES["foto"]["tmp_name"];
                
                if(!in_array($extension, $permitidas)){
                    throw $this->createNotFoundException(
                        'Formato no permitido, solo se acepta png, jpg y jpeg.'
                    );
                }
                
                move_uploaded_file($tmp, $uploads_dir.$name . "." . $extension);
                if(is_file($uploads_dir.$name . "." . $extension))
                    chmod($uploads_dir.$name . "." . $extension, 0777);

                $animal->setPicture('/assets/animales/' . $name. "." . $extension);
            }

            $animal->setName($request->request->get('nombre'));
            $animal->setPrice($request->request->get('precio'));
            $animal->setDescription($request->request->get('descripcion'));
            $animal->setAge($request->request->get('edad'));
            $animal->setRaza($repository->find($request->request->get('raza')));

            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $animal->setUsuario($repository->find($request->getSession()->get('usuario')->getId()));

            $em->flush();

            return $this->redirectToRoute('animal');
        }else{
            return $this->render('default/update_animal.html.twig', [
                'title' => 'Editar Animal',
                'razas' => $repository->findAll(), 
                'animal' => $this->getDoctrine()->getRepository(Animal::class)->find($id)
            ]);
        }
    }
}
