<?php

require_once('vendor/autoload.php');

use model\factories\TechnicianFactory;
use controller\ActionController;
use controller\StatusController;
use controller\TechnicianController;
use controller\LocationController;
use controller\ReportController;
use model\Status;
use model\Location;
use model\Report;
use model\Action;
use model\Technician;

// Dirty hack to allow Yannick to work without Vagrant
if ( file_exists( 'C:\dontvagrant.txt' ) ) {
	$root = "/webandmobile/wp1/";
} else {
	$root = "/wp1/";
}

$router = new AltoRouter();
$router->setBasePath( $root );

try {
	# curl -X GET http://192.168.1.250/action/
	$router->map('GET', 'action/', 
		function() {
			$controller = new ActionController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/status/
	$router->map('GET', 'status/', 
		function() {
			$controller = new StatusController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/technician/
	$router->map('GET', 'technician/', 
		function() {
			$controller = new TechnicianController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/location/
	$router->map('GET', 'location/', 
		function() {
			$controller = new LocationController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/report/
	$router->map('GET', 'report/', 
		function() {
			$controller = new ReportController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/action/1
	$router->map('GET', 'action/[i:id]', 
		function( $id ) {
			$controller = new ActionController();
			$controller->handleFind( $id );
		}
	);
	
	# curl -X GET http://192.168.1.250/location/1
	$router->map('GET', 'location/[i:id]', 
		function( $id ) {
			$controller = new LocationController();
			$controller->handleFind( $id );
		}
	);

	# curl -X GET http://192.168.1.250/report/1
		$router->map('GET', 'report/[i:id]', 
		function( $id ) {
			$controller = new ReportController();
			$controller->handleFind( $id );
		}
	);

	# curl -X GET http://192.168.1.250/status/1
	$router->map('GET', 'status/[i:id]', 
		function( $id ) {
			$controller = new StatusController();
			$controller->handleFind( $id );
		}
	);

	# curl -X GET http://192.168.1.250/technician/1
	$router->map('GET', 'technician/[i:id]', 
		function( $id ) {
			$controller = new TechnicianController();
			$controller->handleFind( $id );
		}
	);

	$router->map('POST', 'action/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$action = new Action( $data["action"],
								  $data["date"],
								  new Location(
									  $data["location"]["name"], 
									  $data["location"]["id"] ));
			$controller = new ActionController();
			$controller->handleCreate( $action );
		}
	);

	$router->map('POST', 'status/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			var_dump( $data );
			$status = new Status( $data["status"],
								  $data["date"],
								  new Location(
									  $data["location"]["name"], 
									  $data["location"]["id"] ));
			$controller = new StatusController();
			$controller->handleCreate( $status );
		}
	);
	
	$router->map('POST', 'report/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$report = new Report( $data["date"],
								  $data["text"],
								  $data["handled"],
								  new Location(
								      $data["location"]["name"],
									  $data["location"]["id"] ));
			if ( array_key_exists( "technician", $data )) {
				$report->setTechnician( new Technician( $data["technician"]["name"],
														new Location(
															$data["technician"]["location"]["name"],
															$data["technician"]["location"]["id"] ),
														$data["technician"]["id"] ));
			}
			$controller = new ReportController();
			$controller->handleCreate( $report );
		}
	);
		
	$router->map('POST', 'location/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$location = new Location( $data["name"] );
			$controller = new LocationController();
			$controller->handleCreate( $location );
		}
	);
			
	$router->map('POST', 'technician/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$technician = TechnicianFactory::CreateFromArray( $data );
			$controller = new TechnicianController();
			$controller->handleCreate( $technician );
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
}
