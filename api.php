<?php

require_once('vendor/autoload.php');

use model\repositories\ActionRepository;
use controller\ActionController;

$router = new AltoRouter();
$router->setBasePath('/');

$pdo = null;
try {
	//$dbData = json_decode(file_get_contents('config/dbconfig.json'));
	$pdo = new PDO('mysql:host=localhost;dbname=web', 'root', 'root');

	# curl -X GET http://192.168.1.250/action/
	$router->map('GET','action/', 
		function() {
			$repository = new ActionRepository( $pdo );
			$controller = new ActionController( $repository );
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
