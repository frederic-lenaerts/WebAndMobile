<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Report;
use AppBundle\Entity\Status;
use AppBundle\Entity\Location;
use AppBundle\Entity\User;
use AppBundle\Controller\LoggableController;

class DefaultController extends LoggableController
{
    /**
     * @Route("/", name="home")
     * @Route("/reports/{location}", name="reportsFiltered")
     */
    public function indexAction( Request $request, $location = null, $page = null )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );
        
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
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );
        
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
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );
        
        $technician_id = $this->get('security.token_storage')->getToken()->getUser()->getTechnicianId();

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $locations = $em->getRepository( 'AppBundle:Location' )->findAll();

        if ( $location != null ) {
            $reports = $em->getRepository( 'AppBundle:Report' )->findByTechnician( $technician_id )->findByLocation( $location, $page );
        } else {
            $reports = $em->getRepository( 'AppBundle:Report' )->findByTechnician( $technician_id, $page );
        }

        $reports = $paginator->paginate( $reports, $request->query->getInt( 'page', 1 ), 10 );
        
        return $this->render( 'AppBundle:Default:myreports.html.twig', compact( "locations", "reports" ) );
    }
    
    /**
     * @Route("/handled/{report}", name="handled")
     */
    public function handledAction( Request $request, $report )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );
        
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
        
        return $this->redirectToRoute( 'myReports' );
    }

    
    /**
     * @Route("/mail/", name="mailReports")
     */
    public function mailAction(\Swift_Mailer $mailer)
    {
        $technician_id = $this->get('security.token_storage')->getToken()->getUser()->getTechnicianId();
        
        $em = $this->getDoctrine()->getManager();
        $reports = $em->getRepository( 'AppBundle:Report' )->findByTechnician( $technician_id );

        $message = (new \Swift_Message('Your reports overview'))
            ->setFrom('your.reports@backstage.com')
            ->setTo('yannick.franssen@outlook.com')
            ->setBody(
                $this->renderView(
                    'AppBundle:Default:email.html.twig',
                    array( 'reports' => $reports )
                ),
                'text/html'
            )
        ;
            
        $mailer->send( $message );

        return $this->redirectToRoute( 'myReports' );
    }

    /**
    * @Route("/makeusers")
    */
    public function makeUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $encoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setUserName('Admin');
        $admin->setRolesString('ROLE_ADMIN');
        $password = 'admin1';
        $encoded = $encoder->encodePassword($admin, $password);
        $admin->setPassword($encoded);
        $em->persist($admin);
        
        $technician = new User();
        $technician->setUserName('Sam');
        $technician->setRolesString('ROLE_TECHNICIAN');
        $technician->setTechnicianId(0);
        $password = 'sam1';
        $encoded = $encoder->encodePassword($technician, $password);
        $technician->setPassword($encoded);
        $em->persist($technician);
        
        $technician = new User();
        $technician->setUserName('Yannick');
        $technician->setRolesString('ROLE_TECHNICIAN');
        $technician->setTechnicianId(1);
        $password = 'yannick1';
        $encoded = $encoder->encodePassword($technician, $password);
        $technician->setPassword($encoded);
        $em->persist($technician);
        
        $technician = new User();
        $technician->setUserName('Frederic');
        $technician->setRolesString('ROLE_TECHNICIAN');
        $technician->setTechnicianId(2);
        $password = 'frederic1';
        $encoded = $encoder->encodePassword($technician, $password);
        $technician->setPassword($encoded);
        $em->persist($technician);
        
        $technician = new User();
        $technician->setUserName('Bert');
        $technician->setRolesString('ROLE_TECHNICIAN');
        $technician->setTechnicianId(3);
        $password = 'bert1';
        $encoded = $encoder->encodePassword($technician, $password);
        $technician->setPassword($encoded);
        $em->persist($technician);
        
        $technician = new User();
        $technician->setUserName('Piet');
        $technician->setRolesString('ROLE_TECHNICIAN');
        $technician->setTechnicianId(4);
        $password = 'piet1';
        $encoded = $encoder->encodePassword($technician, $password);
        $technician->setPassword($encoded);
        $em->persist($technician);
        
        $manager = new User();
        $manager->setUserName('Manager');
        $manager->setRolesString('ROLE_MANAGER');
        $password = 'manager1';
        $encoded = $encoder->encodePassword($manager, $password);
        $manager->setPassword($encoded);
        $em->persist($manager);
        
        $em->flush();

        return $this->redirectToRoute( 'home' );
    }
}