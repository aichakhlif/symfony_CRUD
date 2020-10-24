<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index()
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    /**
     * @Route("/listclub", name="listclub")
     */
    public function listclub()
    {

        $club= $this->getDoctrine()->getRepository(Club::class)->findAll();
        return $this->render("club/listclub.html.twig",array('club'=>$club));
    }
    /**
     * @Route("/newclub", name="newclub")
     */

    public function addclub(Request $request)
    {

        $club= new Club();
        $form= $this->createForm(ClubType::class,$club);
        $form->add("add",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("listclub");
        }

        return    $this->render("club/addclub.html.twig",['our_form'=>$form->createView()]);

    }
    /**
     * @Route("/dropclub/{id}", name="dropclub" )
     * @Method("DELETE")
     */


    public function remove( Club $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listclub");

    }
    /**
     * @Route("/editclub/{id}",name="editclub")
     */
    public function update($id,ClubRepository  $repository,Request $request)
    {
        $club=$repository->find($id);

        $form=$this->createForm(ClubType::class,$club);

        $form->add("update",SubmitType::class,['attr'=>[
            'class'=>"btn btn-success mt-2"
        ]]);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return  $this->redirectToRoute("listclub");

        }
        return  $this->render('club/editclub.html.twig',[
            'form'=>$form->createView()
        ]);
    }


}
