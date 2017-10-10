<?php
namespace OC\LouvreBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LouvreController extends Controller
{
    public function indexAction(){
        //page d'accueil
        $contenue = $this->get('templating')->render('OCLouvreBundle:Louvre:index.html.twig');
        return new Response($contenue);
    }

    public function jourFerierAction() {

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:JoursFermeture');
        $joursFermeture = $repository->findAll();

        foreach ($joursFermeture as $jourFermeture) {
            $dateADescativer[] = $jourFermeture->getJoursFermeture();
        }
        var_dump($dateADescativer);
        return new Response(array($dateADescativer));
    }
}
