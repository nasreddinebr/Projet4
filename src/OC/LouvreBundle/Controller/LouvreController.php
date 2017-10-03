<?php
namespace OC\LouvreBundle\Controller;
use Doctrine\DBAL\Driver\PDOException;
use OC\LouvreBundle\Entity\FormCollection;
use OC\LouvreBundle\Entity\Paiements;
use OC\LouvreBundle\Api\PaimentStripe;
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
             * détérminer le prix pour chaque visiteur et calculer le totale
             * */
            $billets =  $formCollection->getBillets();
            $idProduit = $billets->getProduits()->getId();
            $dateReservation = $_POST['form_collection']['billets']['dateReservation'];
            $clients = $_POST['form_collection']['clients'];

            // Détéminer les tarifs
            if (!empty($clients) && !empty($dateReservation)){
                // Appele au service oc_louvre.datesResrvation
                // pour extraire les dates de naissance au format
                // jour moi année dans une array
                $serviceDateNasisance = $this->container->get('oc_louvre.datesNassances');
                $datesNaissances = $serviceDateNasisance->datesNaissances($clients);

                // Recupération des idTarif
                $serviceImportTarif = $this->container->get('oc_louvre.importTarif');
                $idTarifs = $serviceImportTarif->creeIdTarif($datesNaissances, $dateReservation);
            }



            $derinerBillet = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:Billets')
                ->recupDernierBilletAjouter();


            var_dump($derinerBillet);
            die();

            // Recuperation des prix par visiteur
            $listPrix = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:TarifProduit')
                ->findPrix($idTarifs, $idProduit);
            $total = array_sum($listPrix);
            var_dump($listPrix);
            var_dump($total);

            // Initialisation des variable pour effectuer le paiment
            $token = $_POST['stripeToken'];
            $email = $_POST['email'];
            $name = $_POST['name'];

            /*if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($token)) {
                // Paiement et construction de l'instance $paiment
                $paiementStripe = new PaimentStripe($token, $email, $name, $total);
                $paiement = $paiementStripe->creePaiement();
                var_dump($paiement);

                $billets =  $formCollection->getBillets();
                $billets->setnumeroBillet('25/NOV-1000');
                $billets->setpaiement($paiement);
                $billets->setprixTotal($total);
                var_dump($formCollection->getBillets());
            }else {
                throw new Exception("Un ou plusieurs champs sont vides (Token, Email ou Name");
            }*/
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
