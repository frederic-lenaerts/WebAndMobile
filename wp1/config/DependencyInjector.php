<?php

namespace config;

require_once('vendor/autoload.php');

use Pimple\Container;
use model\dao\ActionDAO;
use model\repositories\ActionRepository;
use model\dao\ReportDAO;
use model\repositories\ReportRepository;
use model\dao\StatusDAO;
use model\repositories\StatusRepository;
use model\dao\LocationDAO;
use model\repositories\LocationRepository;
use model\dao\TechnicianDAO;
use model\repositories\TechnicianRepository;

abstract class DependencyInjector {
    public static function getContainer() {
        $container = new Container();

        $container['pdo'] = $container->factory( function() {
            ob_start();
            require 'dbconfig.json';           
            $json = ob_get_contents();
            ob_end_clean();
            $db = json_decode( $json, true );
            $dsn = 'mysql:host=' . $db['hostname'] . ';dbname=' . $db['database'];
            
            return new \PDO( $dsn, $db['user'], $db['password'] );
        });

        $container['actionDAO'] = $container->factory( function( $c ) {
            return new ActionDAO( $c['pdo'] );
        });

        $container['actionRepository'] =  $container->factory( function( $c ) {
            return new ActionRepository( $c['actionDAO'] );
        });

        $container['reportDAO'] = $container->factory( function( $c ) {
            return new ReportDAO( $c['pdo'] );
        });

        $container['reportRepository'] =  $container->factory( function( $c ) {
            return new ReportRepository( $c['reportDAO'] );
        });
        
        $container['locationDAO'] = $container->factory( function($c) {
            return new LocationDAO( $c['pdo'] );
        });

        $container['locationRepository'] =  $container->factory( function($c) {
            return new LocationRepository( $c['locationDAO'] );
        });
        
        $container['statusDAO'] = $container->factory( function($c) {
            return new StatusDAO( $c['pdo'] );
        });

        $container['statusRepository'] =  $container->factory( function($c) {
            return new StatusRepository( $c['statusDAO'] );
        });

        $container['technicianDAO'] = $container->factory( function($c) {
            return new TechnicianDAO( $c['pdo'] );
        });

        $container['technicianRepository'] =  $container->factory( function($c) {
            return new TechnicianRepository( $c['technicianDAO'] );
        });

        return $container;
    }
}