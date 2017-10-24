<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StatusController extends Controller
{
    /**
     * @Route("/status/add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Status:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/status/find")
     */
    public function findAction()
    {
        return $this->render('AppBundle:Status:find.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/status/all")
     */
    public function allAction()
    {
        return $this->render('AppBundle:Status:all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/status/remove")
     */
    public function removeAction()
    {
        return $this->render('AppBundle:Status:remove.html.twig', array(
            // ...
        ));
    }

}
