<?php

require_once "Classes/Dbh.php";
require_once "Classes/Model.php";
require_once "Classes/Contr.php";
require_once "Classes/View.php";
require_once "includes/config.inc.php";

if (!isset($_SESSION['username'])) {

   echo "<script>alert('please login'); window.location.href = 'index.php';</script>";
} 

$controller = new Contr();
$destinationTable = $controller->destinationTable();
$v = new View;


if ($_SERVER['REQUEST_METHOD'] === "POST") {

   $departureData = $_POST['departure_date'];
   $returnDate = $_POST['return_date'];
   $destination = $_POST['destination'];
   $username = $_SESSION['username'];

   try {
      $controller->handleTravler($departureData, $returnDate, $destination, $username);

   } catch (\Throwable $e) {
      echo ("Error: ") . $e->getMessage();
   }

   // header("location:insertTraveler.php");

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <!-- add user profile -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Travel Agency</title>
   <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
   <link rel="stylesheet" href="./assets/css/style.css">
   <link rel="stylesheet" href="./assets/css/destination.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet">
</head>

<body id="top">

   <header class="header" data-header>
      <div class="overlay" data-overlay></div>
      <div class="header-top">
         <div class="container">
            <a href="tel:+251962286532" class="helpline-box">
               <div class="icon-box">
                  <ion-icon name="call-outline"></ion-icon>
               </div>
               <div class="wrapper">
                  <p class="helpline-title">For Further Questions:</p>
                  <p class="helpline-number">+251966829514</p>
               </div>
            </a>
            <a href="#" class="logo">
               <img src="./assets/images/logo.svg" alt="Tourly logo">
            </a>
            <div class="header-btn-group">
               <div class="pro">
                  <img class="pro-img" src="" alt="">
                  <div class="profile">
                     <?php

                     $v->profile();
                     ?>
                  </div>
               </div>
               <?php
               $v->logout();
               ?>

               <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
                  <ion-icon name="menu-outline"></ion-icon>
               </button>
            </div>
         </div>
      </div>
      <div class="header-bottom">
         <div class="container">
            <ul class="social-list">
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-facebook"></ion-icon>
                  </a>
               </li>
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-twitter"></ion-icon>
                  </a>
               </li>
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-youtube"></ion-icon>
                  </a>
               </li>
            </ul>
            <nav class="navbar" data-navbar>
               <div class="navbar-top">
                  <a href="#" class="logo">
                     <img src="./assets/images/logo-blue.svg" alt="Tourly logo">
                  </a>
                  <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
                     <ion-icon name="close-outline"></ion-icon>
                  </button>
               </div>
               <ul class="navbar-list">
                  <li>
                     <a href="index.php" class="navbar-link" data-nav-link>home</a>
                  </li>
                  <li>
                     <?php


                     $v->flightStatusLink();
                     ?>
                  </li>
                  <li>
                     <a href="/index#gallery" class="navbar-link" data-nav-link>gallery</a>
                  </li>
                  <li>
                     <a href="/index#contact" class="navbar-link" data-nav-link>contact us</a>
                  </li>
               </ul>
            </nav>
            <!-- <button class="btn btn-primary" id="booking"><a href="insertTraveler.php">Book Now</a></button> -->
         </div>
      </div>
   </header>

  
   <div class="container" style="margin-top: 10rem; margin-bottom: 10rem;">
      <div class="text-center mb-4">
         <h3>Tourly Traveler Booking</h3>
         <p class="text-muted">Register Details in the form below</p>

         <?php
         $err = new View;
         $err->checkBookingErrors();
         ?>
      </div>
      <div class="form-container">
         <form class="form" action="" method="post">
            <div class="form-group">
               <label for="destination" class="form-label">Destination:</label>
               <select id="destination" name="destination" class="form-select">
                  <option value="" disabled selected>Select Destination</option>
                  <?php foreach ($destinationTable as $destination): ?>
                     <option><?= $destination['location'] ?>
                     </option>

                  <?php endforeach; ?>
               </select>
            </div>

            <div class="form-group">
               <label for="departure_date" class="form-label">Departure Date:</label>
               <input type="date" id="departure_date" class="form-input" name="departure_date"
                  placeholder="Flight date">
            </div>

            <div class="form-group">
               <label for="return_date" class="form-label">Return Date:</label>
               <input type="date" id="return_date" class="form-input" name="return_date" placeholder="Date of return">
            </div>
            <div class="form-group">
               <button type="submit" class="btn-submit" name="submit">Save</button>
            </div>
         </form>
      </div>
   </div>


   <footer class="footer">
      <div class="footer-top">
         <div class="container">
            <div class="footer-brand">
               <a href="#" class="logo">
                  <img src="./assets/images/logo.svg" alt="Tourly logo">
               </a>
               <p class="footer-text">
                  Urna ratione ante harum provident, eleifend, vulputate molestiae proin fringilla, praesentium
                  magna
                  conubia
                  at
                  perferendis, pretium, aenean aut ultrices.
               </p>
            </div>
            <div class="footer-contact">
               <h4 class="contact-title">Contact Us</h4>
               <p class="contact-text">
                  Feel free to contact and reach us !!
               </p>
               <ul>
                  <li class="contact-item">
                     <ion-icon name="call-outline"></ion-icon>
                     <a href="tel:+251985168722" class="contact-link">+251968596551</a>
                  </li>
                  <li class="contact-item">
                     <ion-icon name="mail-outline"></ion-icon>
                     <a href="mailto : Tourly@gmail.com" class="contact-link">Tourly@gmail.com</a>
                  </li>
                  <li class="contact-item">
                     <ion-icon name="location-outline"></ion-icon>
                     <address>AddisAbaba,Ethiopia</address>
                  </li>
               </ul>
            </div>
            <div class="footer-form">
               <p class="form-text">
                  Subscribe our newsletter for more update & news !!
               </p>
               <form action="" class="form-wrapper">
                  <input type="email" name="email" class="input-field" placeholder="Enter Your Email" required>
                  <button type="submit" class="btn btn-secondary">Subscribe</button>
               </form>
            </div>
         </div>
      </div>
      <div class="footer-bottom">
         <div class="container">
            <p class="copyright">
               &copy; 2025 <a href="">4thYearWebProject</a>. All rights reserved
            </p>
         </div>
      </div>
   </footer>
   <a href="#top" class="go-top" data-go-top>
      <ion-icon name="chevron-up-outline"></ion-icon>
   </a>
   <script src="./assets/js/script.js"></script>
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"></script>


</body>

</html>