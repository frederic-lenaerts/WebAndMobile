<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReportController extends Controller
{
    /**
     * @Route("/report/add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Report:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/report/find")
     */
    public function findAction()
    {
        return $this->render('AppBundle:Report:find.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/report/all")
     */
    public function allAction()
    {
        return $this->render('AppBundle:Report:all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/report/remove")
     */
    public function removeAction()
    {
        return $this->render('AppBundle:Report:remove.html.twig', array(
            // ...
        ));
    }

}
