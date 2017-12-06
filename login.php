<?php
// Created by Professor Wergeles for CS2830 at the University of Missouri and used WITH HIS PERMISSION
// Modified by Kelly Galakatos 

	// Here we are using sessions to propagate the login
session_start(); 
	// http://us3.php.net/manual/en/intro.session.php
	// http://us3.php.net/manual/en/function.session-start.php
	if(!session_start()) {
		// If the session couldn't start, present an error
		header("Location: error.php");
		exit;
	}
	
	// Check to see if the user has already logged in
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	
	if ($loggedIn) {
		header("Location: home.php");
		exit;
	}
	
	
	$action = empty($_POST['action']) ? '' : $_POST['action'];
	
	if ($action == 'do_login') {
		handle_login();
	} else {
		login_form();
	}
	
	function handle_login() {
		$username = empty($_POST['username']) ? '' : $_POST['username'];
		$password = empty($_POST['password']) ? '' : $_POST['password'];
        
        
        // Require the credentials
        require_once 'db.conf';
        
        // Connect to the database
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        
        // Check for errors
        if ($mysqli->connect_error) {
            $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
			require "index.php";
            exit;
        } // end error check if
        
        // http://php.net/manual/en/mysqli.real-escape-string.php
        // THIS WILL PREVENT SQL INJECTION ATTACK
        $username = $mysqli->real_escape_string($username);
        $password = $mysqli->real_escape_string($password); 
        
        
        // Build query        		
        $query = "SELECT password from users WHERE username = '$username' "; 
        
		// Run the query
		$mysqliResult = $mysqli->query($query);
        
        if ($mysqliResult) {
            
            //put results into an associative array
            $row = $mysqliResult->fetch_assoc(); 
                    
            
            // Close result set
            $mysqliResult->close(); 
            // close connection
            $mysqli->close(); 
            
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = $username ; 
                header("Location: home.php"); 
                exit; 
            }
        
            else {
                $error = 'Error: Incorrect username or password';
                require "index.php";
              exit;
            }
        } // close result IF
        
        // Else, there was no result
        else {
          $error = 'Login Error: Please contact the system administrator.';
          require "index.php";
          exit;
        }
    } //end function login
	
	function login_form() {
		$username = "";
		$error = "";
		require "index.php";
        exit;
	}
?>