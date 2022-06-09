<?php 
session_start();
require('./scrape/simple_html_dom.php');

//Cookies
if(!isset($_SESSION['accepted'])){ //set accepted = false if it isnt set yet
  $_SESSION['accepted'] = false;
}

set_error_handler(function($errno, $errstr, $errfile, $errline) { //on error go to exception of the try-catch
  if (0 === error_reporting()) {
      return false;
  }
  throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

//Get Projects Data
$links = array();
$titleAr = array();
$descAr = array();
$progLangAr = array();
$anzProj = 0;
try {
  $url = 'https://github.com';
  $html = file_get_html($url . '/WenzelburgerMarc', false);

  
  foreach($html->find('a[class="text-bold flex-auto min-width-0"]') as $a) { //Scrape Links from Repositorys 
  $links[] = $a->href;
  }

  foreach($html->find('span[class="repo"]') as $title) { //Scrape title from Repository
  $titleAr[] = $title->innertext;
  $anzProj++;
  }

  foreach($html->find('span[itemprop="programmingLanguage"]') as $progL) { //Scrape main repository lanugage
    $progLStr = $progL->innertext;
    $progLangAr[] = $progLStr;
  }


  foreach($html->find('p[class="pinned-item-desc color-fg-muted text-small d-block mt-2 mb-3"]') as $desc) { //Scrape repository description
  $descAr[] = $desc->innertext;
  }
  //$anzProj = 0; //to test the error exception -> remove the slashes
} catch (ErrorException $e) { //Let the page load even if there is an error while scraping, this displays the no project page!
  $anzProj = 0; //set Variable = 0 -> no incomplete repositorys should be displayed on error
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr"> <!-- English, left to right -->
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Marc Wenzelburger">
    <meta name="viewport" content= "width=device-width, initial-scale=1.0">
    <title>Portfolio | Marc Wenzelburger</title>
    <link rel = "icon" href = "./img/mw.png" type = "image/x-icon">
    <link rel="stylesheet" href="./css/index.css">
    <script src="https://kit.fontawesome.com/0bc00b3708.js" crossorigin="anonymous"></script> <!-- crossorigin:anonymous -> There is no exchange of user credentials via cookies, client-side SSL certificates or HTTP authentication, unless destination is the same origin. -->
  </head>
  <body>

    <!-- Cookies akzeptieren -->
    <?php if($_SESSION["accepted"] == false){ ?>
    <div class="cookies">
    <div class="cookiesFullSite"></div>
      <div class="acceptCoo">
        <h1>Info</h1>
        <blockquote>This website uses cookies to provide you the best user experience. We also use Google-Fonts and Font-Awesome-Icons. If you continue, we assume that you agree to that.</blockquote>
        <a href="#" onClick="acceptC();" class="acceptCookies">Accept</a>
        <ul>
          <li><i class="fa-solid fa-info"></i><a href="https://www.fontawesome.com" target="_blank"> - FontAwesome</a></li>
          <li><i class="fa-solid fa-info"></i><a href="https://fonts.google.com/" target="_blank"> - Google Fonts</a></li>
        </ul>
      </div>
    </div>
    <?php } ?>
    

    <!-- Desktop NavBar -->
    <section id="home">
      <header>
        <div class="container">
          <h1 id="logo"><a href=""><span class="tNav">M</span>arc <span class="tNav">W</span>enzelburger</a></h1>
          <div class="navb" id="navJS">
            <a href="#home" type="button">Home</a>
            <a href="#projects" type="button">Projects</a>
            <a href="#aboutme" type="button">About Me</a>
            <a href="#contact" type="button">Contact</a>
          </div>
          <button type="button" class="btnOpenNav" name="button">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>
      </header>
    </section>

    <!-- Mobile NavBar -->
    <nav class="mobile-nav">
      <a href="#home" type="button">Home</a>
      <a href="#projects" type="button">Projects</a>
      <a href="#aboutme" type="button">About Me</a>
      <a href="#contact" type="button">Contact</a>
    </nav>


    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        
        <div class="subhead">Hi, my name is <span>Marc</span></div>
        <h1 id="typing"></h1>
        <div class="hero-cta">
          <a href="#projects" class="go-to-cta">Projects</a>
          <a href="#aboutme" class="go-to-cta">About Me</a>
        </div>
      </div>
    </section>

    <!-- Projects Section -->
    <section class="projects-section" id="projects">
    <h1><span>M</span>y <span>P</span>rojects</h1>
      <div class="container">
        
          <ul>
            <?php 
              for($i=0; $i<$anzProj;$i++) { //Projecs found
                ?>
                 <li class="lproj">
                  <img src="./img/git.png" alt="Project">
                  <h2><?php echo $titleAr[$i]; ?></h2>
                  <blockquote><?php echo $descAr[$i]; ?></blockquote>
                  <cite>~ <?php echo $progLangAr[$i]; ?></cite>
                  <a href="<?php echo $url . $links[$i]; ?>" target="_blank">See More</a>
                </li>

            <?php
              }
              if($anzProj <=0) { //no projects found or Scrape error
                ?>
                <li class="lproj">
                  <img src="./img/git.png" alt="Project">
                  <h2>No Projects found</h2>
                  <blockquote>I am sorry. We could not find any Projects on Github</blockquote>
                  <a href="https://www.github.com/WenzelburgerMarc" target="_blank">See More</a>
                </li>
                <li class="lproj">
                  <img src="./img/git.png" alt="Project">
                  <h2>Error Reporting</h2>
                  <blockquote>If you think that this could be an error then please click the link below</blockquote>
                  <a href="#contact">Contact Me</a>
                </li>
                <li class="lproj">
                  <img src="./img/git.png" alt="Project">
                  <h2>Thank you for your patience!</h2>
                </li>
                <?php
              }
            ?>
                <div id="load-more">Load More</div>
          </ul>
          
      </div>
  </section>

  <!-- About Me Section -->
  <section class="aboutme" id="aboutme">
    <div class="container">

      <div class="aboutme-wrapper">
          <h2><span>A</span>bout <span>M</span>e</h2>
          <blockquote>Hello! My name is Marc and I am 21 years old. Programming is my profession since 2015. If you like to work with me feel free to contact me at the bottom of the page. <p>Here are a few technologies I’ve been working with recently</p></blockquote>
          <div class="containerList">
              <ul class="known-languages-list">
                <li><i class="fa-solid fa-arrow-right-long"></i> HTML</li>
                <li><i class="fa-solid fa-arrow-right-long"></i> CSS</li>
                <li><i class="fa-solid fa-arrow-right-long"></i> Php</li>
                <li><i class="fa-solid fa-arrow-right-long"></i> JavaScript</li>
                <li><i class="fa-solid fa-arrow-right-long"></i> Python</li>
                <li><i class="fa-solid fa-arrow-right-long"></i> Java</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section-->
  <section class="contact-section" id="contact">
    <h2><span>C</span>ontact</h2>
    <div class="container">
           
            <form>
              <div class="control-group">
                <label for="name" id="forname">Name</label>
                <input type="text" name="name" placeholder="Your Name" id="name" class="name" required>
              </div>
              <div class="control-group">
                <label for="email" id="foremail">Email</label>
                <input type="email" name="email" id="email" placeholder="Your Email" class="email" required>
            </div>
            <div class="control-group">
                <label for="message" id="formessage">Message</label>
                <textarea name="message" id="message" placeholder="Your Message" cols="30" rows="10" required></textarea>
            </div>
                <input type="button" class="send-message-cta" value="Send Message" onClick="sendContact();">
                <label id="info"></label>
            </form>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <ul class="socials">
        <li><a href="https://www.github.com" target="_blank"><i class="fa-brands fa-github"></i></a></li>
        <li><a href="https://www.facebook.com" target="_blank"><i class="fa-brands fa-facebook"></i></a></li>
        <li><a href="https://www.twitter.com" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
        <li><a href="https://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
      </ul>
    </div>

  </footer>


    <!-- Scripts -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
    <script type="text/javascript" src="scripts/index.js"></script>
    <script type="text/javascript">
    //Cookies
    function acceptC() { //Click on accept
      jQuery.ajax({
            url: './scripts/accept.php',
            type: "POST",
            data:  "",
            success: function(data) {
              document.querySelector('.cookies').style.display = "none";
            }
        });
    }

      //Load More Button (If there would be more than 3 Projects)
      var list = $(".lproj"); //var list = liste aller repositorys
      var numToShow = 3;
      var button = $("#load-more");
      <?php 
        if($anzProj <= 3) {
          ?>
        button.css("display", "none"); //below 3 Repositorys -> Load More Btn not displayed
          <?php
        }
      ?>
      var numInList = list.length;
      list.hide();
      if (numInList > numToShow) {
        button.show();
      }
      list.slice(0, numToShow).show();

      button.click(function(){
          var showing = list.filter(':visible').length;
          list.slice(showing - 1, showing + numToShow).fadeIn();
          var nowShowing = list.filter(':visible').length;
          if (nowShowing >= numInList) {
            button.hide();
          }
      });

    //Send Contact Form
    function sendContact() {
      var valid;	
        valid = validateContact();
        if(valid) {

          var formData = {
            'name' : $('#name').val(),
            'email' : $('#email').val(),
            'message' : $('#message').val()
          };
            $.ajax({
                url: "./scripts/sendcontact.php",
                data:formData,
                type: "POST",
                success:function(data) {
                  document.getElementById("info").innerHTML = "Message sent!";
                  document.getElementById("info").style.opacity = 1;
                  document.getElementById("info").style.backgroundColor = "#27ae60";

                },
                error:function() {
                  document.getElementById("info").innerHTML = "Error - Message not sent!";
                  document.getElementById("info").style.opacity = 0;
                  setTimeout(function() {
                    document.getElementById("info").style.backgroundColor = "#e74c3c";
                  }, 400);
                  document.getElementById("info").style.opacity = 1;
                  
                  
                }
            });
        }else{
          document.getElementById("info").innerHTML = "Error - Message not sent!";
          document.getElementById("info").style.opacity = 0;
          setTimeout(function() {
            document.getElementById("info").style.backgroundColor = "#e74c3c";
          }, 400);
          document.getElementById("info").style.opacity = 1;
        }
    }
    //Validate Contact Form Input with JQuery -> Focus it if it isnt filled in correctly -> return bool
    function validateContact() {
        var valid = true;	
        if(!$("#name").val()) {
            valid = false;
            $('#name').focus();
            return valid
        }
        if(!$("#email").val() || !$("#email").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
            valid = false;
            $('#email').focus();
            return valid
        }
        if(!$("#message").val()) {
            valid = false;
            $('#message').focus();
            return valid
        }
        return valid;
    }
    </script>
  </body>
</html>
