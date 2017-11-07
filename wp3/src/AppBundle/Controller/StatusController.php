<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends Controller
{
    /**
     * @Route("/status/add", name="status_add")
     */
    public function addAction( Request $request )
    {
        $this->logUserActivity( $request );

        $status = new Status();

        $form = $this->createFormBuilder( $status )
            ->add( 'location', EntityType::class, array(
                'class' => 'AppBundle:Location',
                'choice_label' => 'name'
            ))
            ->add( 'status', TextType::class )
            ->add( 'date', DateType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save status' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $status = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $status );
            $em->flush();
    
            return $this->redirectToRoute( 'status_saved' );
        }

        return $this->render( 'AppBundle:Status:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * @Route("/status/edit/{status}", name="status_edit")
     */
    public function editAction( $status, Request $request )
    {
        $this->logUserActivity( $request );

        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository( 'AppBundle:Status' )->findOneById( $status );

        $form = $this->createFormBuilder( $status )
            ->add( 'location', EntityType::class, array(
                'class' => 'AppBundle:Location',
                'choice_label' => 'name'
            ))
            ->add( 'status', TextType::class )
            ->add( 'date', DateType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save status' ) )
            ->getForm();

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $status = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist( $status );
            $em->flush();

            return $this->redirectToRoute( 'status_saved' );
        }

        return $this->render( 'AppBundle:Status:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * @Route("/status/all", name="status_all")
     */
    public function allAction()
    {
        $this->logUserActivity( $request );

        $statuses = $this->getDoctrine()->getRepository( 'AppBundle:Status' )->findAll();
        
        return $this->render( 'AppBundle:Status:all.html.twig', compact( "statuses" ) );
    }
    
    /**
     * @Route("/status/saved", name="status_saved")
     */
    public function savedAction()
    {
        $this->logUserActivity( $request );

        return $this->render( 'AppBundle:Status:saved.html.twig' );
    }

    private function logUserActivity( Request $request ) {
        $logger = $this->get('monolog.logger.user_activity');       
        $user = $this->get( 'security.token_storage' )->getToken()->getUser();
        $route = $request->get( '_route' );
        $logger->info( $user.' visited '.$route.'.' );
    }
}
