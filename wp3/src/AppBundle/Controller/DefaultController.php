<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Report;
use AppBundle\Entity\Location;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Route("/filter/{location}", name="filter")
     */
    public function indexAction( Request $request, $location = null, $status = null, $report = null )
    {
        $locations = $this->getDoctrine()->getRepository( 'AppBundle:Location' )->findAll();

        if ( $location != null ) {
            $statuses = $this->getDoctrine()->getRepository( 'AppBundle:Status' )->findByLocationId( $location );
            $reports = $this->getDoctrine()->getRepository( 'AppBundle:Report' )->findByLocationId( $location );
        } else {
            $statuses = $this->getDoctrine()->getRepository( 'AppBundle:Status' )->findAll();
            $reports = $this->getDoctrine()->getRepository( 'AppBundle:Report' )->findAll();
        }
        
        return $this->render( 'AppBundle:Default:index.html.twig', array( "locations" => $locations, "statuses" => $statuses, "reports" => $reports ) );
    }
}
