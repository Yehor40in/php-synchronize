<?php

	//ini_set('display_errors', 0);
	
	session_start();
	require_once 'config.php';

	# Core components
	require_once 'Router.php';
	require_once 'View.php';
	require_once 'Model.php';
	require_once 'Controller.php';
	# -----------------------------------------------------------

	# Helpers
	require_once 'helpers/ConcreteJSONSyncManager.php';
	# -----------------------------------------------------------


	Router::route();

?>
