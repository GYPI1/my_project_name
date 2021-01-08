<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

 /**
     * @Route("/page", name="creation")
     */

    public function create() 

    {   
        return  $this->render('comments/comment.html.twig');

    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        return $this->render('default/index.html.twig');
    }

   
}
