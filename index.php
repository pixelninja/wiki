<?php
/*----------------------------------------------------------------------------*/
	
	require_once 'affliction/includes.php';
	
	// Allow apps to exist here:
	Autoload::addPath(__DIR__);
	
	// Start a session:
	$session = Libs\Session::open();
	
	// Register current data:
	$session->registerData();
	
	// Register the Debug App:
	$debug = Apps\Debug\App::instance();
	$session->registerApp($debug);
	
	// Register the rdrkt App:
	$wiki = Apps\Wiki\App::instance();
	$session->registerApp($wiki);
	
	require_once 'config.php';
	
	// Begin:
	$session->execute();
	$session->render();
	$session->send();
	
/*----------------------------------------------------------------------------*/
?>