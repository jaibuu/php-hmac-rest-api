<?php

/**
 * @author Jete O'Keeffe
 * @version 1.0
 * @link http://docs.phalconphp.com/en/latest/reference/micro.html#defining-routes
 * @eg.

$routes[] = [
 	'method' => 'post', 
	'route' => '/api/update', 
	'handler' => 'myFunction'
];

 */


$routes[] = [
	'method' => 'post', 
	'route' => '/v1/create', 
	'handler' => ['Controllers\EntryController', 'createAction']
];

return $routes;
