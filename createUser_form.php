<!DOCTYPE html>
<!-- Created by Professor Wergeles for CS2830 at the University of Missouri USED WITH HIS PERMISSION 

    Modified by Alexander Garcia

        -->
<html>
<head>
	<title>Create User Account</title>
	<link href="app.css" rel="stylesheet" type="text/css">
    <link href="../jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <script src="../jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script>
        $(function(){
            $("input[type=submit]").button();
            
//            $("#password, #confirmPassword").keyup(function() {
//                var password = $ ("#password").val(); 
//                var confirmPassword = $ ("#confirmPassword").val(); 
//                
//                if (password.localeCompare(confirmPassword) != 0 ) {
//                    //$("#outputDiv").html("Passwords don't match"); 
//                    document.getElementById("confirmPassword").setCustomValidity("Passwords don't match"); 
//                    
//                }
//                else {
//                   // $("#outputDiv").html("Passwords match"); 
//                    document.getElementById("confirmPassword").setCustomValidity("Passwords match"); 
//                }
//                
//            }); 
            
            
        });
    </script>
</head>
<body>
    <div id="loginWidget" class="ui-widget">
        <h1 class="ui-widget-header">Login</h1>
        
        <?php
            if ($error) {
                print "<div class=\"ui-state-error\">$error</div>\n";
            }
        ?>
        
        <form action="createUser.php" method="POST">
            
            <input type="hidden" name="action" value="do_create">
            
            
            <div class="stack">
                <label for="firstName">First name:</label>
                <input type="text" id="firstName" name="firstName" class="ui-widget-content ui-corner-all" autofocus value="<?php print $firstName; ?>">
            </div>
            
            
            <div class="stack">
                <label for="lastName">Last name:</label>
                <input type="text" id="LastName" name="lastName" class="ui-widget-content ui-corner-all" autofocus value="<?php print $lastName; ?>">
            </div>
            
            
            <div class="stack">
                <label for="username">User name:</label>
                <input type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus value="<?php print $username; ?>">
            </div>
            
            <div class="stack">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="ui-widget-content ui-corner-all">
            </div>
                
            
              <div class="stack">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" class="ui-widget-content ui-corner-all">
            </div>
            
            <!-- <div class="stack">
                <label for="Birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" class="ui-widget-content ui-corner-all" autofocus value ="">
            </div>-->
            
            
            <div class="stack">
                <label for="email">Email:</label>
                <input type="email" id="email" name = "email" class="ui-widget-content ui-corner-all" autofocus value ="<?php print $email; ?>">
            </div>
            
            
            <div class="stack">
                <input type="submit" value="Submit">
            </div>
        </form>
            
        <br>
        <div id = "outputDiv"></div>
        
    </div>
</body>
</html>