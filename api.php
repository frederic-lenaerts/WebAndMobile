<?php

require_once('vendor/autoload.php');

use controller\ActionController;

$router = new AltoRouter();
$router->setBasePath('/');

try {
	//$dbData = json_decode(file_get_contents('config/dbconfig.json'));

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
	}
	else{
		echo 'geen match';
	}

} catch (Exception $e) {
	var_dump($e);
} finally {
	$pdo = null;
}
