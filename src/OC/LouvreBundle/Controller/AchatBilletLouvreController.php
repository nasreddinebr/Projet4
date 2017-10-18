<?php

namespace OC\LouvreBundle\Controller;

use OC\LouvreBundle\Entity\FormCollection;
use OC\LouvreBundle\Entity\Paiements;
use OC\LouvreBundle\Entity\Billets;
use OC\LouvreBundle\Entity\Clients;
use OC\LouvreBundle\Form\FormCollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AchatBilletLouvreController
 *
 * @package \OC\LouvreBundle\Controller
 */

class AchatBilletLouvreController extends Controller
{
    public function achatBilletsAction(Request $request) {
        $formCollection = new FormCollection();
        $form = $this->get('form.factory')->create(FormCollectionType::class, $formCollection);

        // Récupération des jours de fermeture
        $joursFermeture = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:JoursFermeture')
            ->findAll();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            /*
             * on verifie si le visiteur dispose du tarif reduit ou non
             * puis on  rassembler les dates de naissance pour
             * détérminer le prix pour chaque visiteur et calculer le totale
             * */

            // Recuperation des date de reservation au format d-m-Y
            // et de l'objet Clients
            $dateReservation = $formCollection->getBillets()->get('dateReservation')->format('d-m-Y');
            $clientsForm = $formCollection->getClients();

            // Détéminer les tarifs et les prix et génération du numéro de billet
            if (!empty($clientsForm) && !empty($dateReservation)){
                foreach ($clientsForm as $client) {
                    if ($client->getTarifReduit()) {
                        $localisatorTarif = 5;
                        $idTarif = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('OCLouvreBundle:Tarifs')
                            ->findTarifByLocalisator($localisatorTarif);
                    }else {
                        // Appele au service oc_louvre.datesResrvation
                        // pour extraire les dates de naissance au format
                        // jour moi année dans une array
                        $serviceDateNasisance = $this->container->get('oc_louvre.datesNassances');
                        $datesNaissance = $serviceDateNasisance->datesNaissances($client);



                        // Recupération des idTarif
                        $serviceImportTarif = $this->container->get('oc_louvre.importTarif');
                        $idTarif = $serviceImportTarif->getIdTarif($datesNaissance, $dateReservation);
                    }

                    $idTarifs[] = $idTarif['id'];

                }

                // Génération du numéro du billetTab
                $serviceGenerateurNumBillet= $this->container->get('oc_louvre.generateurNumeroBillet');
                $numeroBillet = $serviceGenerateurNumBillet->genereNumBillet();

                // Recuperation des prix par visiteur
                $idProduit = $formCollection->getBillets()->get('produit')->getId();

                $listPrix = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('OCLouvreBundle:TarifProduit')
                    ->findPrix($idTarifs, $idProduit);
                $total = array_sum($listPrix);
            }else {
                throw new Exception('Client ou date de reservation introuvable');
            }

            // Initialisation des variable pour effectuer le paiment
            $token = $_POST['stripeToken'];
            $email = $_POST['email'];
            $name = $_POST['name'];


            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($token)) {
                // Paiement et construction de l'instance $paiment
                /*$paiementStripe = new PaimentStripe($token, $email, $name, $total);
                $paiement = $paiementStripe->creePaiement();*/
                /****
                 * test Paiement
                 */
                $paiement = new Paiements();
                $paiement->setSommePayee($total);
                $paiement->setStripeChargeId("user42515884555");
                $paiement->setStripeClientId("cli21548796363");
                $paiement->setEmail($email);
                $paiement->setTitulaireCarte($name);
            }

            // Exraction des donée pour hydrate l'objet Billets
            foreach ($formCollection->getBillets() as $key => $value){
                $extracteDonneeBillet[$key] = $value;
            }
            // Hydratation de l'objet Billet
            $billet = new Billets();
            $billet->hydrate($extracteDonneeBillet, $paiement, $numeroBillet, $total);

            $em = $this->getDoctrine()->getManager();
            $em->persist($paiement);
            $em->persist($billet);

            //Recuperation des tarifs
            foreach ($idTarifs as $key => $value) {
                $tarifs[] = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('OCLouvreBundle:Tarifs')
                    ->findTarifById($value);
            }

            //Hydratation de l'objet Clients
            $index = 0;
            foreach ($formCollection->getClients() as $clientX) {
                $clientX->setTarif($tarifs[$index]);
                $clientX->setBillet($billet);
                $clientX->setDateReservation($billet->getDateReservation());
                $client = new Clients();
                // On hydrate Notre objet
                $client->hydrate($clientX);
                $em->persist($client);
                $clients[] = $client;
                $index++;
            }

            $em->flush();

            // Envoi d'e-mail de confirmation d'achat
            $message = \Swift_Message::newInstance()
                ->setSubject('Confirmation de votre billet')
                ->setFrom(array('berrachednasr@gmail.com' => 'Service vente Musee de Louvre'))
                ->setTo($email)
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody(
                    $this->renderView(
                        'OCLouvreBundle:Louvre:validation_billet.html.twig',
                        array(
                            'clients'       => $clients,
                            'billet'        => $billet,
                            'prix'          => $listPrix,
                            'total'         => $total
                        )
                    ));

            $this->get('mailer')->send($message);

            //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirectToRoute('oc_louvre_detaile', array(
                'id'        => $billet->getId(),
                'produit'   => $billet->getProduit()->getNomProduit()
            ));
        }
        // Page du Formulaire d'achat des billetTab
        return $this->render('OCLouvreBundle:Louvre:achatBillet.html.twig', array(
            'form'              => $form->createView(),
            'joursFermeture'    => $joursFermeture
        ));
    }

}
