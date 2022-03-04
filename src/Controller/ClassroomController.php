<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    /**
     * @Route("/addclassroom", name="classroomadd")
     */
    public function addclassroom(\Symfony\Component\HttpFoundation\Request $request)
    {
        $classroom=new Classroom();
        $form=$this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute("classroomadd");
        }
        return $this->render('classroom/add.html.twig',array("formclassroom"=>$form->createView()));
    }
    /**
     * @Route("/listClassroom", name="classroomlist")
     */
    public function listClassroom()
    {
        $classroom=$this->getDoctrine()->getRepository(Classroom::class)->findAll();
        return $this->render("classroom/list.html.twig",array("tabClassroom"=>$classroom));
    }
    /**
     * @Route("/deleteclassroom/{id}", name="classroomdelete")
     */
    public function deleteclassroom($id)
    {
        $classroom=$this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute("classroomlist");
   }
}
