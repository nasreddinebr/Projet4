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

            //Hydratation de l'objet Clients
            foreach ($formCollection->getClients() as $clientX) {
                $clientX->setBillet($billet);
                $client =new Clients();
                // On hydrate Notre objet
                $client->hydrate($clientX);
                $em->persist($client);
            }

            $em->flush();
            //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            //return $this->redirectToRoute('oc_louvre_detaille', array('id' => 1));
        }
        // Page du Formulaire d'achat des billetTab
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
