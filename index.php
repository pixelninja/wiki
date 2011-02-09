<?php
/*----------------------------------------------------------------------------*/
	
	require_once 'affliction/includes.php';
	
	Autoload::addPath(__DIR__);
	
	$session = Libs\Session::open();
	$session->registerData();
	
	$session->registerApp(
		Apps\Debug\App::instance()
	);
	
	$session->registerApp(
		Apps\Wiki\App::instance()
	);
	
	$session->execute();
	$session->render();
	$session->send();
	
/*----------------------------------------------------------------------------*/
?>