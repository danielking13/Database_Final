 <?php

    session_start();

 // Require the credentials
	require_once 'db.conf';
        
        // Connect to the database
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        
        // Check for errors
    if ($mysqli->connect_error) {
    	$error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        exit;
    }// end error check on database connection

    $username = $_SESSION['loggedin'];

    $userQuery = "SELECT id FROM users WHERE username = '$username'";

    $userResult = $mysqli->query($userQuery);
        
    if ($userResult) {
        $queryReturn = $userResult->fetch_assoc(); 
        $userIdResult = $queryReturn["id"];
        //$mysqliResult->close();
    }
    else{
        $userIdResult = 1;
    }

    $img = empty($_POST['img']) ? '' : $_POST['img'];
    $tag = empty($_POST['tag']) ? '' : $_POST['tag'];
    $userId = $userIdResult;
	$type = 'TEST';

    $query = "insert into data (id,img,tag,userId,type) values (NULL , '$img', $tag , $userId, '$type')" ;

    $addImgQuery = $mysqli->query($query);
    if($addImgQuery) {                   
	    $success = "Image added successfully"; 
        $error = $mysqli->error;

        $response = json_encode(array('success'=>$success,"error"=>$error));

        echo $response; 
    }                     
   	// If query doesn't work
    else {
        $error = $mysqli->error;
        $response = json_encode(array('success'=>"NONE","error"=>$error));
        echo $response; 
   	} 

    $mysqli->close();
?>