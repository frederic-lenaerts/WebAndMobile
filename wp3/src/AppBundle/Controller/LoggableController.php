<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

abstract class LoggableController extends Controller {

    protected function logUserVisitAt( $route ) {
        $logger = $this->get('monolog.logger.user_activity');       
        $user = $this->get( 'security.token_storage' )->getToken()->getUser();
        $logger->info( $user.' visited '.$route.'.' );
    }
}