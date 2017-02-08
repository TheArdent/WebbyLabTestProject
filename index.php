<?php
include_once __DIR__.'/autoload.php';

$url = $_SERVER['REQUEST_URI'];

$params = explode('/',$url);
unset($params[0]);

if (count($params) == 1){
	if ($params[1] == '') {
		$controllerClassName ='FilmController';
	}
	else {
		$controllerClassName = $params[1].'Controller';
	}
	$method = 'actionIndex';
}
else {
	$controllerClassName = $params[1].'Controller';
	$method = 'action'.$params[2];
}
$controller = new $controllerClassName;
if (!method_exists($controller,$method)){
	header('HTTP/1.0 404 Not Found');
	printf('<h1>Not Found</h1><p>The requested page %s was not found on this server.</p><hr />', $_SERVER['REQUEST_URI']);
	die();
}
$controller->$method();