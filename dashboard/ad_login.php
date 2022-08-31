<?php
session_start();
include('includes/db_conn.php');
include('includes/functions.php');
$info = $show = '';
if (isset($_REQUEST['login'])) {
    $info = admin_login($conn);
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Admin Login - Job Board</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/starter-template/">



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Custom styles for this template -->
    <link href="assets/style.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="col-lg-10 mx-auto p-3 py-md-5 text-center">
            <main>
                <h1 class="feuturette-title">
                    Admin Login
                </h1>
                <div class="col-md-4 mx-auto my-4">
                    <form action="ad_login.php" class="row g-3 needs-validation text-start login-form" novalidate method="post">
                        <div class="col-md-12">
                            <label for="input1" class="form-label">E-mail</label>
                            <input type="text" class="form-control" name="username" required id="input1">
                        </div>
                        <div class="col-md-12">
                            <label for="input2" class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" required id="input2">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success w-100" name="login">Login</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>



    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/main.js"></script>

</body>

</html>