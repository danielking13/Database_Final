function submitNumber() {
  var testing = 0;
  $("#display").append('<h1>' + testing + '</h1>');
  $("#setTag").css('display', 'inline-block');
  $("#declineTag").css('display', 'inline-block');
  
}

// When the user clicks the button, open the modal 
function addTag() {
    var modal = document.getElementById('tagModal');
    console.log("test");
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
function closeModal() {
  var modal = document.getElementById('tagModal');
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    var modal = document.getElementById('tagModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}