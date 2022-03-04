<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    /**
     * @Route("/listStudent", name="studentslist")
     */
    public function listStudent()
    {
        $student=$this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render("student/list.html.twig",array("tabStudent"=>$student));
    }
    /**
     * @Route("/deleteStudent/{id}", name="studentsDelete")
     */
    public function deleteStudent($id)
    {
        $student=$this->getDoctrine()->getRepository(Student::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("studentslist");
    }
    /**
     * @Route("/addStudent", name="addstudents")
     */
    public function addStudent(Request $request)
    {$student=new Student();
        $form=$this->createForm(StudentType::class,$student);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("studentslist");
        }
        return $this->render("student/add.html.twig",array("formStudent"=>$form->createView()));
    }
    /**
     * @Route("/updateStudent/{id}", name="updatestudents")
     */
    public function updateStudent(Request $request,$id)
    {
        $student=$this->getDoctrine()->getRepository(Student::class)->find($id);
        $form=$this->createForm(StudentType::class,$student);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute("studentslist");
        }
        return $this->render("student/add.html.twig",array("formStudent"=>$form->createView()));
    }
}
