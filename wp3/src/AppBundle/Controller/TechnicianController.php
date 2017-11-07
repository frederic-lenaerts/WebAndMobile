<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Technician;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class TechnicianController extends Controller
{
    /**
     * @Route("/technician/add", name="technician_add")
     */
    public function addAction( Request $request )
    {
        $this->logUserActivity( $request );
        
        $technician = new Technician();

        $form = $this->createFormBuilder( $technician )
            ->add( 'name', TextType::class )
            ->add( 'location', EntityType::class, array(
                'class' => 'AppBundle:Location',
                'choice_label' => 'name'
            ))
            ->add( 'save', SubmitType::class, array( 'label' => 'Save technician' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $technician = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $technician );
            $em->flush();
    
            return $this->redirectToRoute( 'technician_saved' );
        }

        return $this->render( 'AppBundle:Technician:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * @Route("/technician/edit/{technician}", name="technician_edit")
     */
    public function editAction( $technician, Request $request )
    {
        $this->logUserActivity( $request );

        $em = $this->getDoctrine()->getManager();
        $technician = $em->getRepository( 'AppBundle:Technician' )->findOneById( $technician );

        $form = $this->createFormBuilder( $technician )
        ->add( 'name', TextType::class )
        ->add( 'location', EntityType::class, array(
            'class' => 'AppBundle:Location',
            'choice_label' => 'name'
        ))
        ->add( 'save', SubmitType::class, array( 'label' => 'Save technician' ) )
        ->getForm();

        $form->handleRequest( $request );

        if ( $form->isSubmitted() && $form->isValid() ) {
            $technician = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist( $technician );
            $em->flush();

            return $this->redirectToRoute( 'technician_saved' );
        }

        return $this->render( 'AppBundle:Technician:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * @Route("/technician/all", name="technician_all")
     */
    public function allAction()
    {
        $this->logUserActivity( $request );

        $technicians = $this->getDoctrine()->getRepository( 'AppBundle:Technician' )->findAll();
        
        return $this->render( 'AppBundle:Technician:all.html.twig', compact( "technicians" ) );
    }

    /**
     * @Route("/technician/remove/{technician}", name="technician_remove")
     */
    public function removeAction( Technician $technician )
    {
        $this->logUserActivity( $request );

        if ( !$technician ) {
            throw $this->createNotFoundException( 'No technician found' );
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove( $technician );
        $em->flush();

        return $this->redirect( $this->generateUrl( 'technician_all' ) );
    }
    
    /**
     * @Route("/technician/saved", name="technician_saved")
     */
    public function savedAction()
    {
        $this->logUserActivity( $request );

        return $this->render( 'AppBundle:Technician:saved.html.twig' );
    }

    private function logUserActivity( Request $request ) {
        $logger = $this->get('monolog.logger.user_activity');       
        $user = $this->get( 'security.token_storage' )->getToken()->getUser();
        $route = $request->get( '_route' );
        $logger->info( $user.' visited '.$route.'.' );
    }
}