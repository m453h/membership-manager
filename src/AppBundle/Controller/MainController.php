<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends Controller
{

    /**
     * @Route("/home", name="app_home_page")
     */
    public function homepageAction()
    {

        $template = 'main/app.dashboard.html.twig';

        $data = array ();

        return $this->render(
            $template,
            $data
        );
    }

   







}