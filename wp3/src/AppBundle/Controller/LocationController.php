<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LocationController extends Controller
{
    /**
     * @Route("/location/add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Location:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/location/find")
     */
    public function findAction()
    {
        return $this->render('AppBundle:Location:find.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/location/all")
     */
    public function allAction()
    {
        return $this->render('AppBundle:Location:all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/location/remove")
     */
    public function removeAction()
    {
        return $this->render('AppBundle:Location:remove.html.twig', array(
            // ...
        ));
    }

}
