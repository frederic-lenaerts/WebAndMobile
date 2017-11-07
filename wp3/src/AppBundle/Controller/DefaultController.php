<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Report;
use AppBundle\Entity\Status;
use AppBundle\Entity\Location;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Route("/reports/{location}", name="reportsFiltered")
     */
    public function indexAction( Request $request, $location = null, $page = null )
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $locations = $em->getRepository( 'AppBundle:Location' )->findAll();

        if ( $location != null ) {
            $reports = $em->getRepository( 'AppBundle:Report' )->findByLocation( $location, $page );
        } else {
            $reports = $em->getRepository( 'AppBundle:Report' )->findAll( $page );
        }

        $reports = $paginator->paginate( $reports, $request->query->getInt( 'page', 1 ), 10 );
        
        return $this->render( 'AppBundle:Default:index.html.twig', compact( "locations", "reports" ) );
    }

    /**
     * @Route("/statuses", name="statuses")
     * @Route("/statuses/{location}", name="statusesFiltered")
     */
    public function statusAction( Request $request, $location = null, $page = null )
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $locations = $em->getRepository( 'AppBundle:Location' )->findAll();

        if ( $location != null ) {
            $statuses = $em->getRepository( 'AppBundle:Status' )->findByLocation( $location, $page );
        } else {
            $statuses = $em->getRepository( 'AppBundle:Status' )->findAll( $page );
        }

        $statuses = $paginator->paginate( $statuses, $request->query->getInt( 'page', 1 ), 10 );
        
        return $this->render( 'AppBundle:Default:statuses.html.twig', compact( "locations", "statuses" ) );
    }

    /**
     * @Route("/myreports/", name="myReports")
     * @Route("/myreports/{location}", name="myReportsFiltered")
     */
    public function myReportsAction( Request $request, $location = null, $page = null )
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $locations = $em->getRepository( 'AppBundle:Location' )->findAll();

        if ( $location != null ) {
            $reports = $em->getRepository( 'AppBundle:Report' )->findByTechnician( 0 )->findByLocation( $location, $page );
        } else {
            $reports = $em->getRepository( 'AppBundle:Report' )->findByTechnician( 0, $page );
        }

        $reports = $paginator->paginate( $reports, $request->query->getInt( 'page', 1 ), 10 );
        
        return $this->render( 'AppBundle:Default:myreports.html.twig', compact( "locations", "reports" ) );
    }
    
    /**
     * @Route("/handled/{report}", name="handled")
     */
    public function handledAction( Request $request, $report )
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $result = $em->getRepository( 'AppBundle:Report' )->findById( $report );

        if ( $result[0]->getHandled() == 0 ) {
            $result[0]->setHandled( 1 );
        } else {
            $result[0]->setHandled( 0 );
        }

        $em->persist( $result[0] );
        $em->flush();
        
        return $this->redirectToRoute( 'home' );
    }
}