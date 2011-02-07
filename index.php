<?php
/*----------------------------------------------------------------------------*/
	
	require_once 'affliction/includes.php';
	
	// Allow apps to exist here:
	Autoload::addPath(__DIR__);
	
	// Start a session:
	$session = Libs\Session::open();
	
	// Register current data:
	$session->registerData();
	
	// Register the Error App:
	$error = Apps\Error\App::instance();
	$session->registerApp($error);
	
	// Register the Debug App:
	$debug = Apps\Debug\App::instance();
	$session->registerApp($debug);
	
	// Register the Wiki App:
	$wiki = Apps\Wiki\App::instance();
	$session->registerApp($wiki);
	$settings = $wiki->settings();
	
	require_once 'config.php';
	
	// Begin:
	$session->execute();
	$session->render();
	$session->send();
	
/*----------------------------------------------------------------------------*/
?>