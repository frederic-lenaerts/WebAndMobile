<?php

namespace config;

require_once('vendor/autoload.php');

use PDO;
use Pimple\Container;
use model\repositories\ActionRepository;

class DependencyInjector {
    public static function getContainer() {
        $container = new Container();

        $container['pdo'] = $container->factory( function($c) {
            ob_start();
            require 'dbconfig.json';           
            $json = ob_get_contents();
            ob_end_clean();
            $db = json_decode( $json, true );
            $dsn = 'mysql:host=' . $db['hostname'] . ';dbname=' . $db['database'];

            return new PDO( $dsn, $db['user'], $db['password'] );
        });

        $container['actionRepository'] =  $container->factory( function($c) {
            return new ActionRepository( $c['pdo'] );
        });

        return $container;
    }
}