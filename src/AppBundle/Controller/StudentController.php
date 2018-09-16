<?php
/**
 * Created by PhpStorm.
 * User: Prisca Dedji
 * Date: 14/09/2018
 * Time: 17:23
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{

    /**
     * @Route("/add", name="add_studient")
     */
    public function addStudent(Request $request)
    {
        //on crée un Student
        $Student = new Student();

        $form = $this->get('form.factory')->createBuilder('form', $Student)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('numEtud', NumberType::class)
            ->getForm();


        $form->handleRequest($request);


        if ($form->isValid() && $form->isSubmitted() ) {
            // On l'enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($Student);
            $em->flush();
            return $this->redirectToRoute('view_studient');

        }


            return $this->render('student/StudentAdd.html.twig', ['form'=> $form->createView()]);

    }

    /**
     * @Route("/view", name="view_studient")
     */
    public function viewStudent(Request $request)
    {

        $students = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Student::class)
            ->findAll();

        return $this->render('student/StudentView.html.twig',['students' =>$students]);

    }


    /**
     * @Route("/delete/{id}", name="delete_studient")
     */
    public function deleteStudent(Student $student)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();


        return $this->redirectToRoute('view_studient');


    }

    /**
     * @Route("/edit/{id}", name="edit_studient")
     */
    public function editStudent(Request $request,$id)
    {

        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('view_studient');
        }


        return $this->render('student/StudentEdit.html.twig',['form' =>$form->createView()]);


    }

}