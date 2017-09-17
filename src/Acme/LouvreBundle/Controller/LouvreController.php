<?php

namespace Acme\LouvreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LouvreController extends Controller
{
    public function indexAction(){
        //page d'accueil
        $contenue = $this->get('templating')->render('AcmeLouvreBundle:Louvre:index.html.twig');
        return new Response($contenue);
    }

    public function achatBilletsAction() {
        // Page du Formulaire d'achat des billets
        $pageAchat = $this->get('templating')->render('AcmeLouvreBundle:Louvre:achatBillet.html.twig');
        return new Response($pageAchat);
    }

    public function detailleBilletsAction($id) {
        /**
         * $id vaut l'id de la reservation.
         * Ici en recupérera les données à afficher
         * depuis la base de donnée.
         * puis en passera les information à la vue
         * enfin en envoi les information par mail au client.
         */
        return new Response("Affichage des détaile de la reservation id : " . $id);
    }

    public function enregistrerBilletsAction() {
        /**
         * Ici en recupére tous le données depuis le
         * formulaire d'achat des billets, et puis les enregistrer
         * sur la base de donnée.
         */
        // Générer l'URL de la page de détaille
        $url = $this->generateUrl('acme_louvre_detaille', array('id' => 7));
        return $this->redirect($url);
    }

}
