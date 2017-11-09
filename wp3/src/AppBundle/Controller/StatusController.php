<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Status;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\LoggableController;

class StatusController extends LoggableController
{
    /**
     * @Route("/status/add", name="status_add")
     */
    public function addAction( Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

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
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

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
    public function allAction( Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

        $statuses = $this->getDoctrine()->getRepository( 'AppBundle:Status' )->findAll();
        
        return $this->render( 'AppBundle:Status:all.html.twig', compact( "statuses" ) );
    }
    
    /**
     * @Route("/status/saved", name="status_saved")
     */
    public function savedAction( Request $request )
    {
        $route = $request->get( '_route' );
        parent::logUserVisitAt( $route );

        return $this->render( 'AppBundle:Status:saved.html.twig' );
    }
}
