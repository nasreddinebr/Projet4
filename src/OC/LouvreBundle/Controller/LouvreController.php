<?php

namespace OC\LouvreBundle\Controller;

use OC\LouvreBundle\Api\Stripe;
use OC\LouvreBundle\Entity\Clients;
use OC\LouvreBundle\Entity\Billets;
use OC\LouvreBundle\Entity\FormCollection;
use OC\LouvreBundle\Entity\Paiements;
use OC\LouvreBundle\Form\ClientsType;
use OC\LouvreBundle\Form\BilletsType;
use OC\LouvreBundle\Form\FormCollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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

        $formCollection = new FormCollection();
        $form = $this->get('form.factory')->create(FormCollectionType::class, $formCollection);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            /*
             * on verifie si le visiteur dispose du tarif reduit ou non
             * puis on  rassembler les dates de naissance pour
             * détérminer le prix pour chaque visiteur calculer le totale
             * */
            $dateReservation = $_POST['form_collection']['billets']['dateReservation'];
            $clients = $_POST['form_collection']['clients'];

            // Détéminer les tarifs
            if (!empty($clients) && !empty($dateReservation)){
                $serviceTarifs = $this->container->get('oc_louvre.tarifs');
                $tarifs = $serviceTarifs->isTarif($clients, $dateReservation);
            }else {
                throw new Exception("vous devez remplire les champs date de reservation et date de naissance");
            }


            $paiement = new Paiements();
            $token = $_POST['stripeToken'];
            $email = $_POST['email'];
            $name = $_POST['name'];

            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($token)) {

                // Ici on va crée un customer (client) on utilisent la bibliothech curl de php
                /*$stripe = new Stripe('sk_test_mMtQzCgpyghkqStGTvCbJeNj');

                //  Crée le client
                $customer = $stripe->api('customers', [
                    'source' 		=> $token,
                    'description' 	=> $name,
                    'email'			=> $email
                ]);

                // Effectuer le payement
                $charge = $stripe->api('charges', array(
                    "amount" => 1000,
                    "currency" => "eur",
                    "customer" => $customer->id,
                ));
                $sommePaye = $charge->amount / 100;

                // Construire l'objet $paiement
                $paiement->setTitulaireCarte($customer->description);
                $paiement->setEmail($customer->email);
                $paiement->setStripeClientId($charge->customer);
                $paiement->setStripeChargeId($charge->id);
                $paiement->setSommePayee((float) $sommePaye);*/
                
                $billets = $formCollection->getBillets();

            }

            //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            //return $this->redirectToRoute('oc_louvre_detaille', array('id' => 1));


        }


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

}
