<?php
include('includes/config.php');
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>الوسيط | تواصل معنا</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <?php include('includes/links.php'); ?>
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    <!-- Page Content -->
    <div class="container">
        <ol class="breadcrumb mt-5 row justify-content-end">
            <li class="breadcrumb-item">مواقيت الصلاه</li>
            <li class="breadcrumb-item">
                <a class="active p-1" href="index.php">خدمات</a>
            </li>
        </ol>
    </div>
    <?php

    if ($_GET['id'] != '') {
        $_SESSION['id'] = intval($_GET['id']);
    } else {
        echo ("INVALID ID");
    }
    // for ($i=0; $i < 151; $i++) { 
    //     mysqli_query($con,"INSERT INTO ids VALUES ($i,0)");
    // }
    if ($_GET['id'] != '') {
        $_SESSION['id'] = intval($_GET['id']);
        $result = mysqli_query($con, "SELECT present FROM ids WHERE id='" . $_SESSION['id'] . "'");
        if ($row = mysqli_fetch_array($result)) {
            if ($row['present'] == 1) {
                echo ("HE/SHE IS ALREADY PRESENT");
            } else {
                mysqli_query($con, "UPDATE ids SET present=1 WHERE id='" . $_SESSION['id'] . "'");
                $query = mysqli_query($con, "SELECT * FROM ids");
    ?>
                <div class="container">
                    <div class="row hystify-content-center">
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            echo ("<div class='col-6 id'><p>" . $row['id'] . "</p></div>");
                            if ($row['present'] == "1") {
                                echo ("<div class='col-6 present'><p> PRESENT </p></div>");
                            } else {
                                echo ("<div class='col-6 notPresent'><p> NOT PRESENT </p></div>");
                            }
                        }
                        ?>
                    </div>
                </div>
    <?php
            }
        }
    } else {
        echo ("INVALID ID");
    }
    ?>
    <style>
        .present {
            background-color: #000;
            color: #fff;
        }

        .notPresent {
            background-color: #373737;
            color: #fff;
        }

        .id {
            text-align: center;
        }

        .present p,
        .notPresent p,
        .id p {
            width: 100%;
            text-align: center;
        }
    </style>
    <!-- /.container -->
    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>