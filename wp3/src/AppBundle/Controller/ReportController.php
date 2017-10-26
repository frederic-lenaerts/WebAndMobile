<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReportController extends Controller
{
    /**
     * @Route("/report/add", name="report_add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Report:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/report/find", name="report_find")
     */
    public function findAction()
    {
        return $this->render('AppBundle:Report:find.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/report/all", name="report_all")
     */
    public function allAction()
    {
        return $this->render('AppBundle:Report:all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/report/remove", name="report_remove")
     */
    public function removeAction()
    {
        return $this->render('AppBundle:Report:remove.html.twig', array(
            // ...
        ));
    }

}
