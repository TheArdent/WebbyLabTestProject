<?php

function __autoload($classname)
{
	if (file_exists(__DIR__.'/classes/'.$classname.'.php'))
		require __DIR__.'/classes/'.$classname.'.php';
	elseif (file_exists(__DIR__.'/controllers/'.$classname.'.php'))
		require __DIR__.'/controllers/'.$classname.'.php';
	elseif (file_exists(__DIR__.'/models/'.$classname.'.php'))
		require __DIR__.'/models/'.$classname.'.php';
	else {	
		header('HTTP/1.0 404 Not Found');
		printf('<h1>Not Found</h1><p>The requested page %s was not found on this server.</p><hr />', $_SERVER['REQUEST_URI']);
		die();
	}
}
