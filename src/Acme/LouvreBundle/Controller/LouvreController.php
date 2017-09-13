<?php

namespace Acme\LouvreBundle\Controller;

/**
 * Class LouvreController
 *
 * @package \Acme\LouvreBundle\Controller
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LouvreController extends Controller
{
    public function indexAction(){
        $contenue = $this->get('templating')->render('AcmeLouvreBundle:Louvre:index.html.twig');
        return new Response($contenue);
    }

    public function achatBilletAction() {
        $pageAchat = $this->get('templating')->render('AcmeLouvreBundle:Louvre:achatBillet.html.twig');
        return new Response($pageAchat);
    }

}
