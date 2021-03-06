<?php

namespace OC\LouvreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class DetailleBilletLouvreController
 *
 * @package \OC\LouvreBundle\Controller
 */
class DetailBilletLouvreController extends Controller
{
    public function detailBilletAction($id, $produit) {

        // Recuperration du billet

        $repositoriy = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Billets');
        $billet = $repositoriy->find($id);
        if (!$billet){
             throw new Exception('Billet introuvable');
        }
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
        return $this->render('OCLouvreBundle:Louvre:detailBillet.html.twig', array(
            'billet'    => $billet,
            'clients'   => $clients,
            'email'     => $email,
            'prix'      => $listPrix,
            'total'     => $total
        ));
    }

}
