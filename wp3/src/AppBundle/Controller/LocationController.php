<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends Controller
{
    /**
     * @Route("/location/add", name="location_add")
     */
    public function addAction( Request $request )
    {
        $location = new Location();
        $location->setName( 'Bree' );

        $form = $this->createFormBuilder( $location )
            ->add( 'name', TextType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Add location' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $location = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $location );
            $em->flush();
    
            return $this->redirectToRoute( 'location_saved' );
        }

        return $this->render( 'AppBundle:Location:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }
    /**
     * @Route("/location/edit/{location}", name="location_edit")
     */
    public function editAction( $location, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository( 'AppBundle:Location' )->findOneById( $location );

        $form = $this->createFormBuilder( $location )
            ->add( 'name', TextType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save location' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $location = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $location );
            $em->flush();
    
            return $this->redirectToRoute( 'location_saved' );
        }

        return $this->render( 'AppBundle:Location:edit.html.twig', array(
            'form' => $form->createView(),
        ) );
    }

    /**
     * @Route("/location/find", name="location_find")
     */
    public function findAction()
    {
        $locations = $this->getDoctrine()->getRepository( 'AppBundle:Product' )->findAll();

        return $this->render( 'AppBundle:Location:find.html.twig', array( "locations" => $locations ) );
    }

    /**
     * @Route("/location/all", name="location_all")
     */
    public function allAction()
    {
        $locations = $this->getDoctrine()->getRepository( 'AppBundle:Location' )->findAll();
        
        return $this->render( 'AppBundle:Location:all.html.twig', array( "locations" => $locations ) );
    }

    /**
     * @Route("/location/remove", name="location_remove")
     */
    public function removeAction()
    {
        return $this->render( 'AppBundle:Location:remove.html.twig', array(
            // ...
        ) );
    }


    /**
     * @Route("/location/saved", name="location_saved")
     */
    public function savedAction()
    {
        return $this->render( 'AppBundle:Location:saved.html.twig', array(
            // ...
        ) );
    }
}
