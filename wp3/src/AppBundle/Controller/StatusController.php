<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends Controller
{
    /**
     * @Route("/status/add", name="status_add")
     */
    public function addAction( Request $request )
    {
        $status = new Status();

        $form = $this->createFormBuilder( $status )
            ->add( 'location_id', TextType::class )
            ->add( 'status', TextType::class )
            ->add( 'date', DateType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Add status' ) )
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
     * @Route("/status/find", name="status_find")
     */
    public function findAction()
    {
        return $this->render('AppBundle:Status:find.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/status/all", name="status_all")
     */
    public function allAction()
    {
        return $this->render('AppBundle:Status:all.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/status/remove", name="status_remove")
     */
    public function removeAction()
    {
        return $this->render('AppBundle:Status:remove.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/status/saved", name="status_saved")
     */
    public function savedAction()
    {
        return $this->render( 'AppBundle:Status:saved.html.twig', array(
            // ...
        ) );
    }
}
