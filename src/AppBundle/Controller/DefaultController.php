<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index_website.html.twig');
    }

    /**
     * @Route("/billetterie/buy", name="billetterie")
     */
    public function billetterie(Request $request)
    {
        return $this->render('default/navbar.html.twig');
    }
}
