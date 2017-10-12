<?php

require_once('vendor/autoload.php');

use model\factories\ActionFactory;
use controller\ActionController;
use model\factories\StatusFactory;
use controller\StatusController;
use model\factories\TechnicianFactory;
use controller\TechnicianController;
use model\factories\LocatioinFactory;
use controller\LocationController;
use model\factories\ReportFactory;
use controller\ReportController;

$router = new AltoRouter();
$router->setBasePath('/');

try {
	# curl -X GET http://192.168.1.250/action/
	$router->map('GET','action/', 
		function() {
			$controller = new ActionController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/status/
	$router->map('GET','status/', 
		function() {
			$controller = new StatusController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/technician/
	$router->map('GET','technician/', 
		function() {
			$controller = new TechnicianController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/location/
	$router->map('GET','location/', 
		function() {
			$controller = new LocationController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/report/
	$router->map('GET','report/', 
		function() {
			$controller = new ReportController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/action/1
	$router->map('GET','action/[i:getal]', 
		function( $id ) {
			$controller = new ActionController();
			$controller->handleFind( $id );
		}
	);

	$router->map('POST', 'action/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$action = ActionFactory::CreateFromArray( $data );
			$controller = new ActionController();
			$controller->handleCreate( $action );
		}
	);

	# curl -X GET http://192.168.1.250/a/1
	$router->map('GET','a/[i:getal]', 
		function($getal) {
			print("GET a/getal ");
			var_dump($getal);
		}
	);

	# curl -X GET http://192.168.1.250/a/1
	$router->map('GET','a/[a:tekst]', 
		function($tekst) {
			print("GET a/tekst ");
			var_dump($tekst);
		}
	);

	#  curl -X POST -d "{'a':1}" http://192.168.1.250/b/
	$router->map('POST','b/', 
		function() {
			print("POST b/ ");
			$requestBody = file_get_contents('php://input');
			var_dump($requestBody);
			var_dump(json_decode($requestBody));

		}
	);

	$match = $router->match();

	if( $match && is_callable( $match['target'] ) ){
		call_user_func_array( $match['target'], $match['params'] ); 
	} else {
		echo 'Geen match';
	}

} catch (Exception $e) {
	var_dump($e);
} finally {
	$pdo = null;
}
