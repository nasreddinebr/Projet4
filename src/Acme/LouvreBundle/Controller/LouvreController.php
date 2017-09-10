<?php

namespace Acme\LouvreBundle\Controller;

/**
 * Class LouvreController
 *
 * @package \Acme\LouvreBundle\Controller
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class LouvreController extends Controller
{
    public function indexAction(){
        return $this->render('AcmeLouvreBundle:Louvre:index.html.twig');
    }

}
