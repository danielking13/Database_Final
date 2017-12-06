<?php
/**
 * Created by PhpStorm.
 * User: danielking
 * Date: 11/29/17
 * Time: 8:19 PM
 */

      session_start(); 
    
	// Every time we want to access $_SESSION, we have to call session_start()
	if(!session_start()) {
		header("Location: error.php");
		exit;
	}
	
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	if (!$loggedIn) {
		header("Location: login.php");
		exit;
	}



    require('tableController.php');

    $controller = new TableController();
    $controller->run();
?>
