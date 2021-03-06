<?php

namespace AppBundle\Security\Backend;

use AppBundle\Form\Backend\AdminLoginForm;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Backend\Admin;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class AdminLoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router, UserPasswordEncoder $passwordEncoder){

        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {

            $isLoginSubmit = $request->getPathInfo() == '/admin/login' && $request->isMethod('POST');

            if(!$isLoginSubmit){
                return;
            }

            $form = $this->formFactory->create(AdminLoginForm::class);
            $form->handleRequest($request);
            $data = $form->getData();

        $request->getSession()->set(
                Security::LAST_USERNAME,
                $data['_username']
            );

        return $data;

    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        // TODO: Implement getUser() method.
        $username = $credentials['_username'];


//        return $this->em->getRepository('AppBundle:User')
//                        ->findOneBy(['email'=> $username]);


        return $this->em->getRepository('AppBundle:Backend\Admin')
                        ->findOneBy(['email'=> $username]);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // TODO: Implement checkCredentials() method.
        $password = $credentials['_password'];
        if($this->passwordEncoder->isPasswordValid($user,$password)){
//        if($password == 'admin'){
            return true;
        }


            throw new BadCredentialsException();
//            return false;
    }

    protected function getLoginUrl()
    {
        // TODO: Implement getLoginUrl() method.


        return $this->router->generate('admin_security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('admin_dashboard');
    }

}