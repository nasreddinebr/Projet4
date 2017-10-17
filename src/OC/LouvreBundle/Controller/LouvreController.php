<?php
namespace OC\LouvreBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class LouvreController extends Controller
{
    public function indexAction(){
        //page d'accueil
        $contenue = $this->get('templating')->render('OCLouvreBundle:Louvre:index.html.twig');
        return new Response($contenue);
    }

    /**
     * @param $dateChoisie
     * @return Response
     */
    public function countVisitorsAction($dateChoisie) {
        $dateVisite = new \DateTime($dateChoisie);
        $visitorsNumber = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:Clients')
            ->countVisitorsOfDate($dateVisite->format('Y-m-d'));

        return new Response($visitorsNumber[1]);
    }

    /**
     * @param $dateNaissance
     * @param $dateVisite
     * @param $idProduit
     * @return Response
     */
    public function prixAction($dateNaissance, $dateVisite, $idProduit) {
        $dateNaissance = explode('-', $dateNaissance);

        // Recupération des idTarif
        $serviceImportTarif = $this->container->get('oc_louvre.importTarif');
        $idTarif = $serviceImportTarif->getIdTarif($dateNaissance, $dateVisite);

        // Recuperation de prix par visiteur
        $prix = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:TarifProduit')
            ->findPrix($idTarif, $idProduit);

        return new Response($prix['0']);
    }

    /**
     * @param $tarifReduit
     * @param $typeProduit
     * @return Response
     */
    public function tarifReduitAction($tarifReduit, $typeProduit) {
        if ($tarifReduit) {
            $localisatorTarif = 5;
            $idTarif = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCLouvreBundle:Tarifs')
                ->findTarifByLocalisator($localisatorTarif);
        }else {
            throw new Exception('Aucun tarif réduit n\'a été appliqué');
        }
        $prix = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('OCLouvreBundle:TarifProduit')
            ->findPrix($idTarif, $typeProduit);

        return new Response($prix['0']);
    }

}
