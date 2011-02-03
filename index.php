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
	$session->registerApp(
		Apps\Debug\App::instance()
	);
	
	// Register the rdrkt App:
	$session->registerApp(
		Apps\Wiki\App::instance()
	);
	
	// Begin:
	$session->execute();
	$session->render();
	$session->send();
	
/*----------------------------------------------------------------------------*/
?>