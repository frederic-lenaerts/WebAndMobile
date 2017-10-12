<?php

namespace config;

require_once('vendor/autoload.php');

use PDO;
use Pimple\Container;
use model\dao\ActionDAO;
use model\dao\ReportDAO;
use model\repositories\ActionRepository;
use model\repositories\ReportRepository;

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
            
            return new PDO( $dsn, $db['user'], $db['password'] );
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

        return $container;
    }
}