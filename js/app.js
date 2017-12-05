function submitNumber() {
  var testing = 0;
  $("#display").append('<h1 id="displayPrediction">' + testing + '</h1>');
  $("#acceptTag").css('display', 'inline-block');
  $("#declineTag").css('display', 'inline-block');
  var h1 = document.getElementById("displayPrediction");
  console.log(h1);
  
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

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('tagModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}