<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserRegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {

       $user = new User();
       $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);

        if($form->isValid()){
            /** @var User $user */
            $user = $form->getData();


//            $name = $form['username']->getData();
//            $category = $form['email']->getData();
//            $category = $form['email']->getData();
//
//
//            $task->setName($name);
//            $task->setCategory($category);
//            $task->setPriority($priority);
//

            $user->setRoles(array('ROLE_USER'));
//            echo "<pre>"; print_r($user); echo "</pre>";
//            die();
//            $user->setRoles($user->getRoles());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('notice','Welcome '.$user->getEmail());

            return $this->redirectToRoute('task_list');

        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

}