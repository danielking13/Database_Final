<?php

/**
 * Created by PhpStorm.
 * User: danielking
 * Date: 11/28/17
 * Time: 11:58 PM
 */
class TableView
{
    private $pageTitle = '';

    public function __construct() {
    }
    public function __destruct() {
    }

    public function tableView($dataItems, $message) {
        $body = "";

        $this->pageTitle = 'Neural Network Data';

        if($message) {
            $body .= "<h3>$message</h3>";
        }
        //if there aren't any number entries
        if (count($dataItems) < 1) {
            $body .= "<h4 style='padding: 20px;'>No data to display :(</h4>\n";
            return $this->page($body);
        }

        $body .= "<table class='table table-hover table-dark'>";
        $body .= "<tr>
                    <th>User</th>
                    <th>Image</th>
                    <th>Tag</th>
                    <th></th>
                    <th></th>
                 </tr>";
        $counter = 0;
        //generate data from database
        foreach ($dataItems as $dataItem) {
            //retrieve the id, user, image array, and tag from the neural network
            $id = $dataItem['id'];
            $username = $dataItem['username'];
            $image = $dataItem['img'];
            $tag = $dataItem['tag'];
            $counter++;
            $body .= "
            <script>// input array is copied out of database
                function populate(){
                    var input = $image;
                    var canvas = document.getElementById('$counter');
                    canvas.width = 280;
                    canvas.height = 280;

                    var ctx = canvas.getContext('2d'); 
                    var imgData = ctx.createImageData(280,280);
                    var j = 0;
                    for(var i=0; i<imgData.data.length; i+=4){
                        imgData.data[i]=0;
                        imgData.data[i+1]=0;
                        imgData.data[i+2]=0;
                        imgData.data[i+3]=input[j];
                        j++;
                    }
                    ctx.putImageData(imgData,0,0);
                }
            </script>";

            $body .= "<tr>";
            $body .= "<td>$username</td> <td style='width: 280px;' class='table-light'><canvas id='$counter'></canvas></td><td style='font-size: 40px; padding-top: 0px;'>$tag</td>";
            $body .= "<script>populate();</script>";
            $body .= "<td><form action='table.php' method='post'><input type='hidden' name='action' value='delete' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete' class=\"btn btn-outline-primary btn-md\"></form></td>";
            $body .= "<!-- Button trigger modal -->
            <td> 
                <button type=\"button\" class=\"btn btn-outline-primary btn-md\" data-toggle=\"modal\" data-target=\"#$counter\">Update</button>
            </td>";
            $body .= "</tr>";

            $body .= "<div class=\"modal fade\" id=\"$counter\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"modalLabel\">Update</h5>
        <!-- this button is the X at the top -->
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <form action=\"table.php\" method=\"post\">
      <div class=\"modal-body\"> 
            <label>New tag value</label>  
            <input type=\"number\" name=\"tag\" placeholder=\"Enter number 0-9\"/>           
      </div>
      <div class=\"modal-footer\">  
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button> 
          <input type='hidden' name='action' value='update' /><input type='hidden' name='id' value='$id' />
        <button type=\"submit\" value=\"Update\" class=\"btn btn-primary\">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>";
    }
        $body .= "</table>";

        return $this->page($body);
    }

    public function errorView($message) {
        $body = "<h3>$message</h3>";
        return $this->page($body);
    }

    private function page($body) {
        $html = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <title>{$this->pageTitle}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"> 
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> 
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="table.php">Data Table</a><span class="sr-only">(current)</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log out</a>
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
