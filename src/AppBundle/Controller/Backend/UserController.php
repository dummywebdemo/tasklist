<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/admin/users", name="user_list")
     */

    public function indexAction(){

        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        // replace this example code with whatever you need
        return $this->render('backend/user/index.html.twig', array('users'=>$users));
    }
}
