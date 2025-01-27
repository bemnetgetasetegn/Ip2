<?php


require_once 'Classes/Dbh.php';
require_once 'Classes/Model.php';
require_once 'Classes/Contr.php';
require_once 'Classes/View.php';
require_once 'includes/config.inc.php';



if (!isset($_SESSION['username']) && $_SESSION['role'] !== "admin") {
    header('location: login.php');
    exit();
}


$username = $_SESSION['username'];
$role = $_SESSION['role'];
$v = new View;

$controller = new Contr;
$tables = $controller->allTables($username);
$destinationTable = $controller->destinationTable();



//destination upload 

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['location'])) {
    $location = $_POST['location'];
    $description = $_POST['description'];
    $fee = $_POST['fee'];



    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        // Validate image type (e.g., only allow images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image_type, $allowed_types)) {
            $image_path = 'assets/uploads/' . basename($image_name);
            // Move uploaded image to the 'uploads' directory

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $controller->insertdestination($image_path, $location, $description, $fee);
                echo "<script>alert('uploaded successfully')</script>";
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Only image files (JPEG, PNG, GIF) are allowed.";
        }

    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

echo "Request method: " . $_SERVER['REQUEST_METHOD'] . "<br>";


// Destination update
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["updateDestination"])) {
    $id = $_POST['id'];
    $location = $_POST["location"];
    $description = $_POST['description'];
    $fee = $_POST['fee'];


    $image_path = $_POST['existing_image']; // Default to existing image

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        // Validate image type (e.g., only allow images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($image_type, $allowed_types)) {
            $image_path = 'assets/uploads/' . basename($image_name);
            // Move uploaded image to the 'uploads' directory
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $controller->updateDestination($image_path, $location, $description, $fee, $id);

                // Redirect to avoid form resubmission

                echo "<script>alert('updated successfully.');</script>";
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Error uploading the image.');</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid image type. Only JPEG, PNG, and GIF are allowed.');</script>";
            exit();
        }
    }

    // Update the destination in the database

}

//Deletion

if (isset($_GET['delete_user'])) {
    $usernameToDelete = $_GET['delete_user'];
    $controller->deleteUser($usernameToDelete);
    echo '<script>alert("deleted succssfully");</script>';
    header("location:admin.php");
    exit();
}

if (isset($_GET['delete_travel'])) {
    $id = $_GET['delete_travel'];
    $controller->deleteTravel($id);
    header("location:admin.php");
    exit();
}


if (isset($_GET['deletedestinaiton'])) {
    $id = $_GET['deletedestinaiton'];
    $controller->deleteDestination($id);
    header("location:admin.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">


<!-- Header Begins -->


<head>
    <!-- add user profile -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <title>Travel Agency</title>
</head>

<body>

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
        <!--  -->
    </header>


    <!-- Header Ends -->

    <main class="main">


        <?php

        // Group the data by username
        $groupedTables = [];
        foreach ($tables as $table) {
            $groupedTables[$table['username']][] = $table;
        }


        ?>

        <section class="users-list">
            <div class="container">
                <div class="row">
                    <h1>Users Name List</h1>
                    <?php foreach ($groupedTables as $username => $records): ?>
                        <div class="col-md-4 mb-3">
                            <!-- Clickable username to trigger the modal -->
                            <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#modal<?= $username ?>">
                                <?= $username ?>
                            </button>
                        </div>

                        <!-- Modal for displaying user details -->
                        <div class="modal fade" id="modal<?= $username ?>" tabindex="-1"
                            aria-labelledby="modalLabel<?= $username ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel<?= $username ?>">
                                            <?= $username ?>'s Information
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display user-specific details -->
                                        <div class="mb-4">
                                            <p><strong>Full Name:</strong>
                                                <?= $records[0]['firstName'] . ' ' . $records[0]['lastName'] ?></p>
                                            <p><strong>Email:</strong> <?= $records[0]['email'] ?></p>
                                            <p><strong>Phone Number:</strong> <?= $records[0]['phoneNumber'] ?></p>
                                            <p><strong>Date of Birth:</strong> <?= $records[0]['birthdate'] ?></p>

                                            <!-- Delete User Button -->
                                            <a href="?delete_user=<?= $username ?>">
                                                <button type="submit" name="delete" value="deleteuser"
                                                    class="btn btn-danger mt-3 w-100">Delete</button>
                                            </a>
                                        </div>
                                        <hr>
                                        <!-- Display travel-specific details -->
                                        <h6>Travel Details:</h6>
                                        <ul class="list-group">
                                            <?php if (!empty($records[0]['departure_date'])): ?>
                                                <?php foreach ($records as $record): ?>
                                                    <li class="list-group-item">
                                                        <p><strong>Departure Date:</strong> <?= $record['departure_date'] ?></p>
                                                        <p><strong>Return Date:</strong> <?= $record['return_date'] ?></p>
                                                        <p><strong>Destination:</strong> <?= $record['destination'] ?></p>
                                                        <p><strong>Uid:</strong> <?= $record['user_id'] ?></p>
                                                        <p><strong>id:</strong> <?= $record['id'] ?></p>

                                                        <!-- Delete Flight Button -->
                                                        <a href="?delete_travel=<?= $record['id'] ?>">
                                                            <input type="hidden" name="id" value="<?= $record['id'] ?>">
                                                            <button type="submit" name="delete" value="deleteTravel"
                                                                class="btn btn-danger mt-3 w-100">Delete Flight</button>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li class="list-group-item">
                                                    <p><strong>No Travel History Found</strong></p>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="dst-upload">
            <div class="container">

                <h2 class="h2 hero-title">Destination controller</h2>

                <form method="POST" action="" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label for="place" class="form-label">Location</label>
                        <input type="text" class="form-control" id="place" name="location" placeholder="location">
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="description"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="fee" class="form-label">Fee</label>
                        <input type="number" class="form-control" id="fee" name="fee" placeholder="fee">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            </div>
        </section>
        <section>

            <!-- update  -->

            <div class="table-responsive">
                <table class="table table-admn table-striped table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Location</th>
                            <th scope="col">Description</th>
                            <th scope="col">Fee</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($destinationTable as $dTable): ?>
                            <tr>
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                                    <td>
                                        <!-- Ensure the form method is POST -->
                                        <input type="file" name="image" accept="image/*">
                                        <img src="<?= htmlspecialchars($dTable['image']) ?>" alt="Image" width="100">
                                        <input type="hidden" name="existing_image"
                                            value="<?= htmlspecialchars($dTable['image']) ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="location"
                                            value="<?= htmlspecialchars($dTable['location']) ?>" required>
                                    </td>
                                    <td>
                                        <textarea name="description" rows="5"
                                            cols="30"><?= htmlspecialchars($dTable['description']) ?></textarea>
                                    </td>
                                    <td>
                                        <input type="number" name="number" value="<?= htmlspecialchars($dTable['fee']) ?>"
                                            required>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($dTable['id']) ?>">
                                        <button class="btn btn-primary" type="submit"
                                            name="updateDestination">Update</button>
                                        <a href="?deletedestinaiton=<?= htmlspecialchars($dTable['id']) ?>"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>


        <!--  -->
        <!--  -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</body>

</html>