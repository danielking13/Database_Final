<?php

/**
 * Created by PhpStorm.
 * User: danielking
 * Date: 11/28/17
 * Time: 11:58 PM
 */
class TableView
{
    private $pageTitle = 'Digit Recognizer';
    private $stylesheet = '';

    public function __construct() {
    }
    public function __destruct() {
    }

    public function tableView($dataItems, $message) {
        $body = "";

        $this->pageTitle = 'Neural Network Data';

        if($message) {
            $body .= "<p>$message</p>";
        }
        //if there aren't any number entries
        if (count($dataItems) < 1) {
            $body .= "<p>No data to display :(</p>\n";
            return $this->page($body);
        }

        $body .= "<table class='table table-hover table-dark'>";
        $body .= "<tr>
                    <th>user</th>
                    <th>image</th>
                    <th>Tag</th>
                    <th></th>
                    <th></th>
                 </tr>";
        //generate data from database
        foreach ($dataItems as $dataItem) {
            //retrieve the id, user, and tag from the neural network
            $id = $dataItem['id'];
            $user = $dataItem['user']; // auto incremented user id
            $image = $dataItem['img']; // need to turn image into an image from json array
            //DEBUG
//            echo "This is an image ";
//            echo $image;
            $tag = $dataItem['tag'];

            $body .= "<tr>";
            $body .= "<td>$user</td><td>$image</td><td>$tag</td>"; //change user to to username using sql query joining the user table
            $body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete' class=\"btn btn-outline-primary btn-sm\"></form></td>";
            $body .= "<!-- Button trigger modal -->
            <td> 
                <button type=\"button\" class=\"btn btn-outline-primary btn-sm\" data-toggle=\"modal\" data-target=\"#updateModal\">Update</button>
            </td>";
            $body .= "</tr>";

            $body .= "<div class=\"modal fade\" id=\"updateModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"modalLabel\">Update</h5>
        <!-- this button is the X at the top -->
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\"> 
          <form action=\"index.php\" name=\"action\" method=\"post\">
            <label>New tag value</label>  
            <input type=\"number\" name=\"action\" placeholder=\"Enter number 0-9\"/>
        </form>           
      </div>
      <div class=\"modal-footer\">
          
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button> 
          <input type='hidden' name='action' value='update' /><input type='hidden' name='id' value='$id' />
        <button type=\"submit\" value=\"update\" class=\"btn btn-primary\">Save changes</button>
      </div>
    </div>
  </div>
</div>";
        }
        $body .= "</table>";




        return $this->page($body);
    }

    public function errorView($message) {
        $body = "<p>$message</p>\n";
        return $this->page($body);
    }

    private function page($body) {
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <title>{$this->pageTitle}</title>
    <link rel="stylesheet" type="text/css" href="{$this->stylesheet}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"> 
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> 
    <style>    
        .images {
            width: 65px;
            height: 80px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="displayTable.html">Data   Table</a><span class="sr-only">(current)</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Log out </a>
                </li>
            </ul>    
        </div>
    </nav> 
    $body
</body>
</html>
EOT;
        return $html;
    }

}

?>