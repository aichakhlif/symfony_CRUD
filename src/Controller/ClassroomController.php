<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;

use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\EventListener\SaveSessionListener;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\HttpFoundation\Request;



class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index()
    {


      //  return $this->render("classroom/list.html.twig");
    }
    /**
     * @Route("/listclassroom", name="listclassroom")
     */
    public function listclass()
    {

        $classr= $this->getDoctrine()->getRepository(classroom::class)->findAll();
        return $this->render("classroom/list.html.twig",array('classr'=>$classr));
    }
    /**
     * @Route("/newclassroom", name="newclassroom")
     */

    public function add(Request $request)
    {

        $classr= new Classroom();
        $form= $this->createForm(ClassroomType::class,$classr);
        $form->add("add",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em->persist($classr);
            $em->flush();
            return $this->redirectToRoute("listclassroom");
        }

     return    $this->render("classroom/add.html.twig",['our_form'=>$form->createView()]);

    }
    /**
     * @Route("/dropclassroom/{id}", name="dropclassroom" )
     * @Method("DELETE")
     */


    public function remove( Classroom  $id)
    {
       //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listclassroom");

    }
    /**
     * @Route("/editclassroom/{id}",name="editclassroom")
     */
    public function update($id,ClassroomRepository  $repository,Request $request)
    {
        $classr=$repository->find($id);

        $form=$this->createForm(ClassroomType::class,$classr);

        $form->add("update",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return  $this->redirectToRoute("listclassroom");

        }
        return  $this->render('classroom/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
