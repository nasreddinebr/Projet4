<?php

namespace OC\LouvreBundle\Controller;

use OC\LouvreBundle\Entity\Clients;
use OC\LouvreBundle\Entity\Billets;
use OC\LouvreBundle\Entity\Paiements;
use OC\LouvreBundle\Form\ClientsType;
use OC\LouvreBundle\Form\BilletsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LouvreController extends Controller
{
    public function indexAction(){
        //page d'accueil
        $contenue = $this->get('templating')->render('OCLouvreBundle:Louvre:index.html.twig');
        return new Response($contenue);
    }

    public function achatBilletsAction(Request $request) {
        $billet = new Billets();
        $client = new Clients();
        //$form = $this->get('form.factory')->create(BilletsType::class, $billet);
        $form = $this->get('form.factory')->create(ClientsType::class, $client);


        // Page du Formulaire d'achat des billets
        return $this->render('OCLouvreBundle:Louvre:achatBillet.html.twig', array(
           'form' => $form->createView(),
        ));
    }

    public function detailleBilletsAction($id) {
        /**
         * $id vaut l'id de la reservation.
         * Ici en recupérera les données à afficher
         * depuis la base de donnée.
         * puis en passera les information à la vue
         * enfin en envoi les information par mail au client.
         */
        return new Response("Votre enregistrement à bien été effectuer" . $id);
    }

    public function enregistrerBilletsAction(Request $request) {
        /**
         * Ici en recupére tous les données depuis le
         * formulaire d'achat des billets, et puis les enregistrer
         * sur la base de donnée.
         */
        //création de l'entitee Clients
        $client = new Clients();
        $client->setNom('Berrached');
        $client->setPrenom('Nasreddine');
        $client->setDateNaissance(new \DateTime('1980-08-17'));
        $client->setPays('Maroc');
        $client->setIdBillet(1);
        $client->setIdTarif(1);

        //onrecupére le gestionnaire de donnée
        $em = $this->getDoctrine()->getManager();

        // On persiste l'objet
        $em->persist($client);

        // On demande la mise a jour
        $em->flush();

        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Client enregistrer');

            return $this->redirectToRoute('oc_louvre_detaille', array('id' => 1));

        }
        return $this->render('OCLouvreBundle:Louvre:achatBillet.html.twig');
    }

}
