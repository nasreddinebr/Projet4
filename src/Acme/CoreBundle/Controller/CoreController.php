<?php

namespace Acme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CoreController
 *
 * @package \Acme\CoreBundle\Controller
 */
class CoreController extends Controller
{
    public function indexAction()
    {
        // On retourne simplement la vue de la page d'accueil
        return $this->render('AcmeCoreBundle:Core:index.html.twig');
    }
}
