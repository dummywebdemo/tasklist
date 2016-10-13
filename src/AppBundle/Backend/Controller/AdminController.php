<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/backadmin", name="homepage13")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return new Response('<html><body>Admin page!</body></html>');
    }
}
