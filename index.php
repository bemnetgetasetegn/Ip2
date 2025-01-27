<?php
require_once 'includes/config.inc.php';
require_once 'Classes/Dbh.php';
require_once 'Classes/Model.php';
require_once 'Classes/Contr.php';
require_once 'Classes/View.php';

$v = new View;
$controller = new Contr;
$destinationTable = $controller->destinationTable();


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                            <a href="#gallery" class="navbar-link" data-nav-link>gallery</a>
                        </li>
                        <li>
                            <a href="#contact" class="navbar-link" data-nav-link>contact us</a>
                        </li>
                    </ul>
                </nav>
                <button class="btn btn-primary" id="booking"><a href="insertTraveler.php">Book Now</a></button>
            </div>
        </div>
    </header>


    <!-- Header Ends -->

    <main>
        <article>
            <section class="hero" id="home">
                <div class="container">
                    <h2 class="h1 hero-title">Unleash Your Travel Dreams</h2>
                    <p class="hero-text">
                        It's time to break free from the mundane and unleash your
                        wildest travel dreams. Let your imagination soar and let us
                        craft the perfect itinerary to turn your wanderlust into reality
                    </p>
                    <div class="btn-group">
                        <button class="btn btn-primary">Learn more</button>
                        <button class="btn btn-secondary" id="booking2">
                            <a href="insertTraveler.php">Book now</a>
                        </button>
                    </div>
                </div>
            </section>


            <!-- destination section -->

            <section class="section-destination">
                <p class="section-subtitle">Take a look on what's avaliable</p>
                <h2 class="h2 section-title">Avaliable Destinations</h2>
                <p class="section-text">
                    do you want to take a trip? It's all avaliable here, Take a look at what we offer and decide.
                    from the highest peak of mountains to the lowest point on earth it's all avaliable here
                </p>
                <div class="container destination">
                    <?php if (!empty($destinationTable)): ?>
                        <?php foreach ($destinationTable as $destination): ?>
                            <div class="des-item">
                                <img src=<?= $destination['image'] ?> alt="">
                                <p class="text-info"> <?= $destination['description'] ?> </p>
                                <ion-icon name="location-outline"></ion-icon><?= $destination['location'] ?>
                                <?php if (empty($destination['fee'])): ?>
                                    <p class="text-info"><i class="fas fa-dollar-sign"></i>Free Trip </p>
                                <?php else: ?>
                                    <p class="text-info"><i class="fas fa-dollar-sign"></i><?= $destination['fee'] ?> </p>
                                <?php endif; ?>
                                <button type="button" class="btn btn-primary btn-sm "><a href="insertTraveler.php">Book
                                        Now</a></button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-danger" style="text-align:center;">No Available Places</p>
                    <?php endif; ?>



                </div>
            </section>
            <section class="gallery" id="gallery">
                <div class="container">
                    <p class="section-subtitle">Photo Gallery</p>
                    <h2 class="h2 section-title">Photo's From Travellers</h2>
                    <p class="section-text">
                        These captivating photos serve as a window into the extraordinary
                        moments and breathtaking sights we encountered during our unforgettable vacations, offering a
                        glimpse into the sheer beauty that awaited us
                    </p>
                    <ul class="gallery-list">
                        <li class="gallery-item">
                            <figure class="gallery-image">
                                <img src="./assets/images/hammer.jpg" alt="Gallery image">
                            </figure>
                        </li>
                        <li class="gallery-item">
                            <figure class="gallery-image">
                                <img src="./assets/images/addis.jpg" alt="Gallery image">
                            </figure>
                        </li>
                        <li class="gallery-item">
                            <figure class="gallery-image">
                                <img src="./assets/images/ethio.jpg" alt="Gallery image">
                            </figure>
                        </li>
                        <li class="gallery-item">
                            <figure class="gallery-image">
                                <img src="./assets/images/blackwomen.jpg" alt="Gallery image">
                            </figure>
                        </li>
                        <li class="gallery-item">
                            <figure class="gallery-image">
                                <img src="./assets/images/takingPhoto.jpg" alt="Gallery image">
                            </figure>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="cta" id="contact">
                <div class="container">
                    <div class="cta-content">
                        <p class="section-subtitle">Call To Action</p>
                        <h2 class="h2 section-title">Ready For Unforgatable Travel? Remember Us!</h2>
                        <p class="section-text">
                            Unleash your wanderlust and embark on a transformative journey with our extraordinary travel
                            experience.
                            Discover captivating destinations, from breathtaking landscapes to vibrant cultures, as you
                            immerse yourself in the wonders of the world.
                            Our carefully crafted itineraries ensure every moment is filled with awe and excitement,
                            connecting you with hidden gems and local communities.
                            Create cherished memories that will last a lifetime as you explore thrilling escapades,
                            serene
                            retreats, and cultural discoveries. Let us ignite
                            your sense of adventure and guide you on an unforgettable expedition that will redefine the
                            way
                            you see the world..
                        </p>
                    </div>
                    <button class="btn btn-secondary">Contact Us !</button>
                </div>
            </section>
        </article>
    </main>
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
</body>

</html>