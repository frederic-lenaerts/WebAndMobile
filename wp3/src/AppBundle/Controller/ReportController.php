<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Report;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller
{
    /**
     * @Route("/report/add", name="report_add")
     */
    public function addAction( Request $request )
    {
        $report = new Report();
        
        $form = $this->createFormBuilder( $report )
            ->add( 'location_id', TextType::class )
            ->add( 'date', DateType::class )
            ->add( 'handled', TextType::class )
            ->add( 'technician_id', TextType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save report' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $report = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $report );
            $em->flush();
    
            return $this->redirectToRoute( 'report_saved' );
        }

        return $this->render( 'AppBundle:Report:add.html.twig', array(
            'form' => $form->createView(),
        ) );
    }
    
    /**
     * @Route("/report/edit/{report}", name="report_edit")
     */
    public function editAction( $report, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $report = $em->getRepository( 'AppBundle:Report' )->findOneById( $report );

        $form = $this->createFormBuilder( $report )
            ->add( 'location_id', TextType::class )
            ->add( 'date', DateType::class )
            ->add( 'handled', TextType::class )
            ->add( 'technician_id', TextType::class )
            ->add( 'save', SubmitType::class, array( 'label' => 'Save report' ) )
            ->getForm();

        $form->handleRequest( $request );
    
        if ( $form->isSubmitted() && $form->isValid() ) {
            $report = $form->getData();
    
            $em = $this->getDoctrine()->getManager();
            $em->persist( $report );
            $em->flush();
    
            return $this->redirectToRoute( 'report_saved' );
        }

        return $this->render( 'AppBundle:Report:edit.html.twig', array(
            'form' => $form->createView(),
        ) );
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
        $reports = $this->getDoctrine()->getRepository( 'AppBundle:Report' )->findAll();

        return $this->render( 'AppBundle:Report:all.html.twig', array( "reports" => $reports ) );
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
