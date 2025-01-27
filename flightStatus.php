<?php
require_once 'includes/config.inc.php';
require_once 'Classes/Dbh.php';
require_once 'Classes/Model.php';
require_once 'Classes/Contr.php';
require_once 'Classes/View.php';


$username = $_SESSION['username']; // run to an error here trying to get the login username from contr handle login

$v = new View;
$ctr = new Contr;
$travelInfo = $ctr->travelInfo($username);



?>

<!DOCTYPE html>
<html lang="en">


<!-- Header Begins -->


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
                <button class="btn btn-primary" id="booking"><a href="insertTraveler.php">Book Now</a></button>
            </div>
        </div>
    </header>



    <!-- Header Ends -->
    <section>

        <div class="container" style="margin-top : 10rem ; margin-bottom :  10rem ;">



            <?php if (isset($_SESSION["username"]) && $_SESSION["logged_in"] === true && !empty($ctr)): ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Departure Date</th>
                                <th scope="col">Return Date</th>
                                <th scope="col">Destination</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($travelInfo as $travel): ?>
                                <tr>
                                    <td><?= htmlspecialchars($travel['departure_date']) ?></td>
                                    <td><?= htmlspecialchars($travel['return_date']) ?></td>
                                    <td><?= htmlspecialchars($travel['destination']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


            <?php else: ?>
                <p>No travel information found.</p>
            <?php endif; ?>
        </div>
    </section>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>