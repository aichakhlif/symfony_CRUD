<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index()
    {
       /* return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);*/
    }
    /**
     * @Route("/liststudent", name="liststudent")
     */
    public function liststudent()
    {

        $student= $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render("Student/liststudent.html.twig",array('student'=>$student));
    }
    /**
     * @Route("/newstudent", name="newstudent")
     */
    public function add(Request $request)
    {

        $student= new student();
        $form= $this->createForm(StudentType::class,$student);
        $form->add("add",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("liststudent");
        }

        return    $this->render("student/addstudent.html.twig",['our_form'=>$form->createView()]);

    }
    /**
     * @Route("/dropstudent/{id}", name="dropstudent" )
     * @Method("DELETE")
     */


    public function remove( Student  $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("liststudent");

    }
    /**
     * @Route("/editstudent/{id}",name="editstudent")
     */
    public function update($id,StudentRepository  $repository,Request $request)
    {
        $classr=$repository->find($id);

        $form=$this->createForm(StudentType::class,$classr);

        $form->add("update",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return  $this->redirectToRoute("liststudent");

        }
        return  $this->render('student/editstudent.html.twig',[
            'form'=>$form->createView()
        ]);
    }


}
