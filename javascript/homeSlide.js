var slideIndex = 1;
var slideIndex2 = 1;
showSlides(slideIndex);
showSlides(slideIndex2)

function initialize(){
    var d = document.getElementsByClassName("latestProd");
    d[0].style.display = "block";
    var f = document.getElementsByClassName("eventSlide");
    f[0].style.display = "block";
}

//Slide 1
function plusSlides(n) {
  showSlides(slideIndex += n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("latestProd");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  slides[slideIndex-1].style.display = "block";  
}

//Slide 2
function plusSlides2(y) {
    showSlides2(slideIndex2 += y);
}
  
  function showSlides2(y) {
    var o;
    var slides = document.getElementsByClassName("eventSlide");
    if (y > slides.length) {slideIndex2 = 1}    
    if (y < 1) {slideIndex2 = slides.length}
    for (o = 0; o < slides.length; o++) {
        slides[o].style.display = "none";  
    }
    slides[slideIndex2-1].style.display = "block";  
  }