<?php
namespace OC\LouvreBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class LouvreController extends Controller
{
    public function indexAction(){
        //page d'accueil
        $contenue = $this->get('templating')->render('OCLouvreBundle:Louvre:index.html.twig');
        return new Response($contenue);
    }

    public function countVisitorsAction($dateChoisie) {
        $dateVisite = new \DateTime($dateChoisie);
        $visitorsNumber = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Clients')
            ->countVisitorsOfDate($dateVisite->format('Y-m-d'));

        return new Response($visitorsNumber[1]);
    }
}
