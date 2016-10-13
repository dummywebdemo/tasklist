<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

//    public function loginAction(){
//
//        return $this->render('backend/admin/login.html.twig');
//    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     * @Route("/admin/dashboard/", name="admin_dashboard1")
     */

    public function indexAction(){

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

            // replace this example code with whatever you need
            return $this->render('backend/admin/dashboard.html.twig', array('users'=>$users));

    }
}