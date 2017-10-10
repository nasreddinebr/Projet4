<?php
namespace OC\LouvreBundle\Controller;

use OC\LouvreBundle\Entity\FormCollection;
use OC\LouvreBundle\Entity\Paiements;
use OC\LouvreBundle\Entity\Billets;
use OC\LouvreBundle\Entity\Clients;
use OC\LouvreBundle\Form\FormCollectionType;
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
        $formCollection = new FormCollection();
        $form = $this->get('form.factory')->create(FormCollectionType::class, $formCollection);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            /*
             * on verifie si le visiteur dispose du tarif reduit ou non
             * puis on  rassembler les dates de naissance pour
             * détérminer le prix pour chaque visiteur et calculer le totale
             * */


            $dateReservation = $_POST['form_collection']['billets']['dateReservation'];
            $clientTab = $_POST['form_collection']['clients'];

            // Détéminer les tarifs
            if (!empty($clientTab) && !empty($dateReservation)){
                // Appele au service oc_louvre.datesResrvation
                // pour extraire les dates de naissance au format
                // jour moi année dans une array
                $serviceDateNasisance = $this->container->get('oc_louvre.datesNassances');
                $datesNaissances = $serviceDateNasisance->datesNaissances($clientTab);

                // Recupération des idTarif
                $serviceImportTarif = $this->container->get('oc_louvre.importTarif');
                $idTarifs = $serviceImportTarif->getIdTarif($datesNaissances, $dateReservation);

            }

            // Génération du numéro du billetTab
            $serviceGenerateurNumBillet= $this->container->get('oc_louvre.generateurNumeroBillet');
            $numeroBillet = $serviceGenerateurNumBillet->genereNumBillet();

            // Recuperation des prix par visiteur
            $billetTab =  $formCollection->getBillets();

            $idProduit = $billetTab['produit']->getId();
            $listPrix = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:TarifProduit')
                ->findPrix($idTarifs, $idProduit);
            $total = array_sum($listPrix);

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
                    ->find($value);
            }

            //Hydratation de l'objet Clients
            $index = 0;
            foreach ($formCollection->getClients() as $clientX) {
                $clientX->setTarif($tarifs[$index]);
                $clientX->setBillet($billet);
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
            return $this->redirectToRoute('oc_louvre_detaille', array(
                'id'        => $billet->getId(),
                'produit'   => $billet->getProduit()->getNomProduit()
            ));
        }
        // Page du Formulaire d'achat des billetTab
        return $this->render('OCLouvreBundle:Louvre:achatBillet.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function detailleBilletsAction($id, $produit) {
        /**
         * $id vaut l'id de la reservation.
         * Ici en recupérera les données à afficher
         * depuis la base de donnée.
         * puis en passera les information à la vue.
         */

        // Recuperration du billet
        $repositoriy = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Billets');
        $billet = $repositoriy->find($id);
        $billet->getProduit()->setNomProduit($produit);

        // Recuperation des visiteurs
        $repositoriy = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Clients');
        $clients = $repositoriy->findByBillet($id);

        foreach ($clients as $client) {
            // Recuperation des tarifs
            $tarif = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:Tarifs')
                ->findTarif($client->getTarif()->getId());

            $tarifsId[] = $tarif[0]->getId();
            $client->setTarif($tarif[0]);

            // Recuperation des prix
            $listPrix = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:TarifProduit')
                //->findPrix($tarifsId, $billet->getProduit()->getId());
                ->findPrix($tarifsId, $billet->getProduit()->getId());
        }

        // Recuperation d'email
        $email = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Paiements')
            ->findEmail($billet->getPaiement()->getId());
        $email = $email[0]['email'];
        $dateR = $billet->getDateReservation()->format('d-m-Y');
        $total = array_sum($listPrix);

        //return new Response("Votre enregistrement à bien été effectuer" . $id);
        return $this->render('OCLouvreBundle:Louvre:detailleBillet.html.twig', array(
            'billet'    => $billet,
            'clients'   => $clients,
            'email'     => $email,
            'prix'      => $listPrix,
            'total'     => $total
        ));
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
