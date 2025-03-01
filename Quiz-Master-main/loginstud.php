<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #84fab0, #8fd3f4);
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 50px;
        }

        .form-control {
            border-radius: 25px;
        }

        .btn-success {
            border-radius: 25px;
            font-size: 18px;
            padding: 10px 20px;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/navbar.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="contact.php"><i class="fas fa-address-card"></i> Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <div class="dropdown-menu" aria-labelledby="loginDropdown">
                            <a class="dropdown-item" href="loginstud.php">Student</a>
                            <a class="dropdown-item" href="login.php">Staff</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="signup.php"><i class="fas fa-user-plus"></i> Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title text-center text-primary">Student Login</h4>
                        <form method="POST" autocomplete="off" novalidate>
                            <div class="form-group">
                                <label for="usn">USN</label>
                                <input type="text" class="form-control" id="usn" name="usn" placeholder="Enter your USN" required>
                                <div class="invalid-feedback">USN is required.</div>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="pass" placeholder="Enter your password" required>
                                <div class="invalid-feedback">Password is required.</div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="signup.php" class="text-primary">Don't have an account? Sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PHP Login Logic -->
    <?php
    if (isset($_POST['login'])) {
        if (!empty($_POST['usn']) && !empty($_POST['pass'])) {
            require_once 'sql.php';
            $conn = mysqli_connect($host, $user, $ps, $project);
            if (!$conn) {
                echo "<script>alert('Database connection error. Please try again later!');</script>";
            } else {
                $usn = mysqli_real_escape_string($conn, $_POST['usn']);
                $password = mysqli_real_escape_string($conn, $_POST['pass']);

                $sql = "SELECT * FROM student WHERE usn='$usn'";
                $res = mysqli_query($conn, $sql);

                if (mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    if ($password === $row['pw']) {
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['usn'] = $row['usn'];
                        header("Location: homestud.php");
                        exit();
                    } else {
                        echo "<script>alert('Incorrect password. Please try again.');</script>";
                    }
                } else {
                    echo "<script>alert('User not found. Please sign up first.');</script>";
                }
            }
        } else {
            echo "<script>alert('All fields are required!');</script>";
        }
    }
    ?>

    <!-- Footer -->
    <?php require("footer.php"); ?>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Form Validation Script -->
    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>
