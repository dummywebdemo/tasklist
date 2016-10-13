<?php
// src/AppBundle/Controller/Backend/SecurityController.php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Form\Backend\AdminLoginForm;

class SecurityController extends Controller
{
    /**
     * @Route("/admin/login", name="admin_security_login")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(AdminLoginForm::class,['_username' => $lastUsername]);

        return $this->render('backend/security/login.html.twig', array(

            'form' => $form->createView(),
            'error' => $error,
        ));
    }



    /**
    * @Route("/admin/logout", name="admin_security_logout")
    */
    public function logoutAction(){


        throw new \Exception('this should not be reached');

    }
}