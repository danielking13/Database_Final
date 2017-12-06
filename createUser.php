<?php
// Created by Professor Wergeles for CS2830 at the University of Missouri USED WITH HIS PERMISSION
// Modified by Alexander Garcia

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
		header("Location: home.html");
		exit;
	}
	
	//Ternary operator -- checking for action from create form
	$action = empty($_POST['action']) ? '' : $_POST['action'];
	

	if ($action == 'do_create') {
		create_user();
	} else {
		login_form();
	}
	
	function create_user() {
                
        $firstName = empty($_POST['firstName']) ? '' : $_POST['firstName'];
        $lastName = empty($_POST['lastName']) ? '' : $_POST['lastName'];
        $confirmPassword = empty($_POST['confirmPassword']) ? '' : $_POST['confirmPassword'];
        //$birthday = empty($_POST['birthday']) ? '' : $_POST['birthday'];
		$username = empty($_POST['username']) ? '' : $_POST['username'];
		$password = empty($_POST['password']) ? '' : $_POST['password'];
	    $email = empty($_POST['email']) ? '' : $_POST['email']; 
        
        // Require the credentials
        require_once '../db.conf';
        
        // Connect to the database
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        
        // Check for errors
        if ($mysqli->connect_error) {
            $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
			require "index.php";
            exit;
        }// end error check on database connection
        
        // making sure password and confirm password match
        if (strcmp($password, $confirmPassword) == 0) {
            
        // http://php.net/manual/en/mysqli.real-escape-string.php
        // helps prevent some but not all SQL injection attacks
        $username = $mysqli->real_escape_string($username);
        $password = $mysqli->real_escape_string($password);
        
        //more secure password storing for website
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
        
        // Build query
            // Query to check if username already exists
            $checkRepeatQuery = "SELECT id FROM users WHERE username = '$username'" ; 

            //Query to insert new data into database
		$query = "insert into users (firstName, lastName, username, hashedPassword, email, addDate, changeDate) values ('$firstName' , '$lastName', '$username' , '$hashedPassword', '$email' , now() , now() )" ; 
            
            //run query to mysql testing for repeat username
            $repeatResult = $mysqli->query($checkRepeatQuery); 
		  
            //if query is successful
            if($repeatResult) {
            $repeatMatch = $repeatResult->num_rows; 
                
                //close result set
                $repeatResult->close(); 
                
                if($repeatMatch == 1 ) {
                    $error = 'Username already in use.'; 
                    require "createUser_form.php"; 
                        exit; 
                }// end repeatMatch result for checking username
                
                    // if username is not in use continue adding user
                    else {
                        $addUserQuery = $mysqli->query($query); 
                            if($addUserQuery) {
                                
                                $success = "User created successfully! Please login."; 
                                require "index.php";
                                // close result set
                                $addUserQuery->close(); 
                                //close DB connection
                                $mysqli->close(); 
                                exit; 
                            }
                            
                            // If query doesn't work
                            else {
                                $error = "User not created successfully. Contact system administrator."; 
                                require "createUser_form.php"; 
                                exit; 
                            } // end ELSE for query not working
                    }// end ELSE for adding user into DB
                
                
            } // end result if statement for checking repeat username
            
            // This else flags if QUERY is unsuccessful
            else {
                $error = "Error with the query.";
                require "createUser_form.php"; 
                exit; 
            }
            
	   } // end strcmp if
        
        // this else is if the password and password confirm do NOT match
        else { 
            $error = 'Passwords DONT MATCH. Please Try again.'; 
            require "createUser_form.php"; 
            exit; 
        } // end else for password NOT matching
    
    } // end function create user



	function login_form() {
		$username = "";
		$error = "";
		require "index.php";
        exit;
	}
	
?>