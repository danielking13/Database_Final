// establish variables for use throughout the script.
// Importing this file at the end of the template ensures that these variables get set

var canvas = document.getElementById("drawDigit");
var ctx = canvas.getContext("2d");
canvas.width = 280;
canvas.height = 280;
var width = canvas.width;
var height = canvas.height;
var curX, curY, prevX, prevY;
var hold = false;
var fill_value = true, stroke_value = false;
var canvas_data = { "pencil": []};
ctx.lineWidth = 10;

// clear the canvas
function reset (){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    canvas_data = { "pencil": []};
    document.getElementById("display").innerHTML = "<h1>&nbsp</h1>";
}
        

// set up event listeners on the canvas to enable drawing        
function pencil (){
    var BB=canvas.getBoundingClientRect();
    var offsetX = BB.left;
    var offsetY = BB.top;

    canvas.onmousedown = function (e){
        curX = e.clientX - offsetX;
        console.log("Left: " + offsetX);
        curY = e.clientY - offsetY;
        console.log("Top: " + offsetY);

        hold = true;
            
        prevX = curX;
        prevY = curY;
        ctx.beginPath();
        ctx.moveTo(prevX, prevY);
    };
        
    canvas.onmousemove = function (e){
        if(hold){
            curX = e.clientX - offsetX;
            curY = e.clientY - offsetY;
            draw();
        }
    };
        
    canvas.onmouseup = function (e){
        hold = false;
    };
        
    canvas.onmouseout = function (e){
        hold = false;
    };
        
    function draw (){
        ctx.lineTo(curX, curY);
        ctx.stroke();
        canvas_data.pencil.push({ "startx": prevX, "starty": prevY, "endx": curX, "endy": curY, 
            "thick": ctx.lineWidth, "color": ctx.strokeStyle });
    }
}
        

function save (boolean){
    var tag;
    console.log(boolean);
  
    // If the prediction was accepted as true, we'll take the prediction tag from the display box
    if(boolean){
      tag = document.getElementById("displayPrediction").innerHTML; 
      acceptTag();
    }
    else if (!boolean){
      tag = document.getElementById("digitTag").value;
    }
    console.log(tag);

    var canvasImage = ctx.getImageData(0,0, canvas.width, canvas.height);

    // collect a vector of grayscale values for each pixel
    var blackVals = [];
    for (var i=3; i<canvasImage.data.length; i+=4){
        blackVals.push(canvasImage.data[i]);
    }

    // reshape into image format
    var grayscaleImg = [];
    var j;
    for (i=0, j=-1; i<blackVals.length; i++){
        if(i%canvas.width ==0){
            j++;
            grayscaleImg[j]=[];
           
        }

        grayscaleImg[j].push(blackVals[i]);
    }

    // resize from 280 x 280 to 28x28
    var output =[];
    for (var y = 0; y < 28; y++) {
       	output[y]=[];
       	for (var x = 0; x < 28; x++) {
           	var mean = 0;
           	for (var v = 0; v < 10; v++) {
            	for (var h = 0; h < 10; h++) {
                	mean += grayscaleImg[y*10 + v][x*10 + h];
              	}
            }

           	mean = mean/100;

            output[y][x]=mean;
          }
    }

    // request a prediction
    $.ajax({
        url: 'predict_digit/',
        data: {
            //csrfmiddlewaretoken: '{{ csrf_token }}',
            digitArray: JSON.stringify(output),
            tag: JSON.stringify(tag)
        },
        dataType: 'json',
        type:"POST",
        success: function(data){
            console.log("returned");
            
            document.getElementById("display").innerHTML = data.prediction;
        },
        error: function(data){
            console.log("There was an error");
            document.getElementById("display").innerHTML = "There was a prediction error";
        }

    });

}
