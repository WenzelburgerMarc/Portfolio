//Navbar Hamburger
const deskNav = document.querySelector('.btnOpenNav');
const mobileNav = document.querySelector('.mobile-nav');
deskNav.addEventListener('click',function() {
  deskNav.classList.toggle('is-active');
  mobileNav.classList.toggle('is-active');
});

//On Website Load
window.onload = function() {

  //Scroll To Top and make navbar transparent
  document.querySelector('header').style.top = "0";
  document.querySelector('header').style.opacity = "1";
  document.querySelector('header').style.background = "none";
  document.querySelector('header').style.borderBottom = "none";
  window.scrollTo(0, 0);

  //typing effect hero
  var i = 0;
  var txt = 'A Developer from Germany'; 
  var speed = 200;

  function typeWriter() {
    if (i <= txt.length - 1) {
      document.getElementById("typing").innerHTML += txt.charAt(i);
      i++;
      setTimeout(typeWriter, speed);
    }
  }
  typeWriter();
}

//During Scrolling -> Animated navbar
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {

  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.querySelector('header').style.top = "0";
    document.querySelector('header').style.opacity = "1";

    document.querySelector('header').style.background = "#212121";
    document.querySelector('header').style.borderBottom = "3px solid #BC38ff";
  } else {
    if(!mobileNav.classList.contains("is-active")){
      document.querySelector('header').style.top = "-100px";
      document.querySelector('header').style.opacity = "0";
      document.querySelector('header').style.background = "#212121";
      document.querySelector('header').style.borderBottom = "3px solid #BC38ff";
    }
  }

  if(currentScrollPos == 0) {
    document.querySelector('header').style.top = "0";
    document.querySelector('header').style.opacity = "1";
    document.querySelector('header').style.background = "none";
    document.querySelector('header').style.borderBottom = "none";
  }
  prevScrollpos = currentScrollPos;
}