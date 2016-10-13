<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Tests\Command\CacheClearCommand\Fixture\TestAppKernel;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Exception;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     * @Route("/", name="task_list1")
     */
    public function indexAction()
    {
//        if ($this->isGranted('ROLE_USER') == false) {
//            echo "no user role";
//        }else{
//            echo "user role";
//        }

            $tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();

        // replace this example code with whatever you need
        return $this->render('task/index.html.twig', array('tasks'=>$tasks));
    }

    /**
     * @Route("/task/create", name="task_create")
     */

    public function createAction(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');


        $task = new Task();
        $form = $this->createFormBuilder($task)
                    ->add('name',TextType::class,array('attr'=>array('class'=>'form-control')))
                    ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))
                    ->add('priority',ChoiceType::class,array('choices'=>array('High'=>'High','Medium'=>'Medium','Low'=>'Low'),'attr'=>array('class'=>'form-control')))
                    ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
                    ->add('due_date',DateTimeType::class,array('attr'=>array('class'=>'')))
                    ->add('save',SubmitType::class,array('label'=>'Create Task','attr'=>array('class'=>'btn btn-primary')))
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $priority = $form['priority']->getData();
            $description = $form['description']->getData();
            $due_date = $form['due_date']->getData();
            $create_date = new \DateTime('now');

            $task->setName($name);
            $task->setCategory($category);
            $task->setPriority($priority);
            $task->setDescription($description);
            $task->setDueDate($due_date);
            $task->setCreateDate($create_date);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->addFlash('notice','Task Added');

            return $this->redirectToRoute('task_list');
       }

        // replace this example code with whatever you need
        return $this->render('task/create.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/task/edit/{id}", name="task_edit")
     */

    public function editAction($id, Request $request)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);

        $task->setName($task->getName());
        $task->setCategory($task->getCategory());
        $task->setPriority($task->getPriority());
        $task->setDescription($task->getDescription());
        $task->setDueDate($task->getDueDate());
        $task->setCreateDate($task->getCreateDate());

        $form = $this->createFormBuilder($task)
            ->add('name',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('category',TextType::class,array('attr'=>array('class'=>'form-control')))
            ->add('priority',ChoiceType::class,array('choices'=>array('High'=>'High','Medium'=>'Medium','Low'=>'Low'),'attr'=>array('class'=>'form-control')))
            ->add('description',TextareaType::class,array('attr'=>array('class'=>'form-control')))
            ->add('due_date',DateTimeType::class,array('attr'=>array('class'=>'form-control')))
            ->add('save',SubmitType::class,array('label'=>'Update Task','attr'=>array('class'=>'btn btn-primary')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $priority = $form['priority']->getData();
            $description = $form['description']->getData();
            $due_date = $form['due_date']->getData();
            $create_date = new \DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $task = $em->getRepository('AppBundle:Task')->find($id);

            $task->setName($name);
            $task->setCategory($category);
            $task->setPriority($priority);
            $task->setDescription($description);
            $task->setDueDate($due_date);
            $task->setCreateDate($create_date);

            $em->flush();

            $this->addFlash('notice','Task Updated');

            return $this->redirectToRoute('task_list');
        }

        // replace this example code with whatever you need
        return $this->render('task/edit.html.twig', array('task'=>$task,'form'=>$form->createView()));
    }

    /**
     * @Route("/task/delete/{id}", name="task_delete")
     */


    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);

        $em->remove($task);
        $em->flush();

        $this->addFlash('notice','Task Deleted');
        // replace this example code with whatever you need
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/task/details/{id}", name="task_details")
     */

    public function detailsAction(Task $task)
    {

        // replace this example code with whatever you need
        return $this->render('task/details.html.twig',array('task'=> $task));
    }


}
