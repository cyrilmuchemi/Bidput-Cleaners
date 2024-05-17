<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Signup - Bidput Cleaners</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?=ROOT?>/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?=ROOT?>/assets/tlib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="<?=ROOT?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/admin-style.css">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div id="toast_box">

                    </div>
                    <form action="ajax.php" method="post" id="signupForm">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3>Sign Up</h3>
                                <div id="ajax-response"></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Jack" required>
                                <span id="first_name_error" class="error"></span><br>
                                <label for="floatingText">First Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Mwas" required>
                                <span id="last_name_error" class="error"></span><br>
                                <label for="floatingText">Last Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                <span id="email_error" class="error"></span><br>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                <span id="password_error" class="error"></span><br>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-group">
                                <!-- Google reCAPTCHA block -->
                                <div class="g-recaptcha" data-sitekey="<?= "6LcxQdApAAAAAIR_8CgwiUfHJ52bqPQP0fyw3XTy"?>"></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <a href="">Forgot Password</a>
                            </div>
                            <button type="submit" id="sign-up-submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                            <p class="text-center mb-0">Already have an Account? <a href="<?=ROOT?>/login">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/chart/chart.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/easing/easing.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/waypoints/waypoints.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="<?=ROOT?>/assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="<?=ROOT?>/assets/js/main-admin.js"></script>
    <script src="<?=ROOT?>/assets/js/index.js" type="module"></script>
</body>

</html>