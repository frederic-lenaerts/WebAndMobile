<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TechnicianController extends Controller
{
    /**
     * @Route("/technician/add", name="technician_add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Technician:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/technician/find", name="technician_find")
     */
    public function findAction()
    {
        return $this->render('AppBundle:Technician:find.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/technician/all", name="technician_all")
     */
    public function allAction()
    {
        return $this->render('AppBundle:Technician:all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/technician/remove", name="technician_remove")
     */
    public function removeAction()
    {
        return $this->render('AppBundle:Technician:remove.html.twig', array(
            // ...
        ));
    }

}
