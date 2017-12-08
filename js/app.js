function submitNumber() {
  var testing = predict();
  $("#display").append('<h1 id="displayPrediction">' + testing + '</h1>');
  $("#acceptTag").css('display', 'inline-block');
  $("#declineTag").css('display', 'inline-block');
  $("#information").css('display', 'inline-block');
}

// Set the prediction as incorrect and open modal to set the correct tag
function acceptTag() {
    var modal = document.getElementById('acceptTagModal');
    modal.style.display = "block";
}

function declineTag() {
    var modal = document.getElementById('declineTagModal');
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
function closeAcceptModal() {
    var modal = document.getElementById('acceptTagModal');
    modal.style.display = "none";
}

function closeDeclineModal() {
  var modal = document.getElementById('declineTagModal');
    modal.style.display = "none";
}

function hideButtons(){
  $("#acceptTag").css('display', 'none');
  $("#declineTag").css('display', 'none');
  $("#display").innerHTML("");
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('tagModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}