<!DOCTYPE html>

<html>
    <head>
        <?php
        
      session_start(); 
    
	// Every time we want to access $_SESSION, we have to call session_start()
	if(!session_start()) {
		header("Location: error.php");
		exit;
	}
	
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	if (!$loggedIn) {
		header("Location: index.php");
		exit;
	}
?>

        <title>Network Data</title>
        <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"> 
      <link rel="stylesheet" href="style/style.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="js/app.js"></script>
      <style>
        .jumbotron p{
          font-size: 17px;
        }
        #information {
          display: none;
        }
        
        .jumbotron {
          padding-bottom: 0;
          padding-top: 0px;
        }
        
        body {
          overflow-y: hidden;
          overflow-x: hidden;
        }
        
        .navbar {
          border-radius: 0px;
          font-size: 16px;
        }
        body {
          background-color: #212429;
        }
      </style>
    </head>
<body onload="pencil()">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home </a><span class="sr-only">(current)</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="table.php">Data Table</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log out </a>
                </li>
            </ul>    
        </div>
    </nav> 
  <div class="row">
    <div class="col-lg-1"></div>
    <div  class="col-lg-3">
      <div id="canvasDiv">
        <canvas id="drawDigit"></canvas>
      </div>
      <button class="btn" id="clear" onclick="reset()" >
        <span class="glyphicon glyphicon-erase icons" aria-hidden="true"></span>Clear
      </button>
      <button class="btn" id="clear" onclick="submitNumber()" ><span class="glyphicon glyphicon-send icons" aria-hidden="true"></span>Submit</button>
    </div>
    <div class="col-lg-2">
      <div id="display">
      </div>
      <div id="acceptDeclineBtns">
        <div id="acceptTag"><button id="accept" class='btn' onclick="save(true)"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></div>
        <div id="declineTag"><button id="decline" class='btn' onclick="declineTag()"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>Are you ready to test out the capabilities of a neural network? Use our application to watch it predict a number!</p>
        <p>In the red box, use your cursor to draw a number. Select "clear" if you'd like to reset your drawing, or "submit" if you want to get the prediction from the Neural Network.</p>
        <div id="information">
          <h3>Nice!</h3>
          <p>You've run your first prediction!</p>
          <p>Was this prediction correct? If yes, click the <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> and your run will be added to the database.</p>
          <p>If this prediction wasn't correct, click the <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> and you will be prompted to type in the correct tag.</p>
          <p>This information will be added to the database.</p>
        </div>
      </div>
    </div>
    </div>
    <!-- The Modal -->
    <div id="declineTagModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header" style="background-color: firebrick;">
          <h2>Incorrect Prediciton?</h2><span onclick='closeDeclineModal()' class='close'>&times;</span>
        </div>
        <p>What was the correct value?</p>
        <div class="modal-interior">
          <label for='digitTag' style='margin-right: 5px;'>Tag:</label>
          <input type='text' id='digitTag'>
        </div>
        <div class="modal-interior">
          <button class="btn" onclick='save(false)'>Save</button>
        </div>
        </div>
    </div>
  
    <!-- Modal to alert acceptance of input -->
    <div id="acceptTagModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header" style="height: 80px;">
          <h2>Added!</h2>
          <span onclick='closeAcceptModal()' class='close'>&times;</span>
        </div>
         <p style="font-size: 20px; margin-top: 10px;">Thanks! Your input has been added!</p>
        <div class="modal-interior">
          <button class="btn" onclick='closeAcceptModal()'>OK!</button>
        </div>
    </div>
  </div>
<script src="js/canvasBackend.js"></script>
</body>
</html>