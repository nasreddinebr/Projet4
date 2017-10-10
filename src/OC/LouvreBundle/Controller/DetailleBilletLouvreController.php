<?php

namespace OC\LouvreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DetailleBilletLouvreController
 *
 * @package \OC\LouvreBundle\Controller
 */
class DetailleBilletLouvreController extends Controller
{
    public function detailleBilletsAction($id, $produit) {

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

        // Recuperation des tarifs et des prix
        foreach ($clients as $client) {
            // Recuperation des tarifs
            $tarif = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:Tarifs')
                ->findTarifById($client->getTarif()->getId());

            $tarifsId[] = $tarif->getId();
            $client->setTarif($tarif);

            // Recuperation des prix
            $listPrix = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:TarifProduit')
                ->findPrix($tarifsId, $billet->getProduit()->getId());
        }

        // Recuperation d'email
        $email = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Paiements')
            ->findEmail($billet->getPaiement()->getId());

        //$dateR = $billet->getDateReservation()->format('d-m-Y');
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

}
