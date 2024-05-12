<?php
include 'logic/login.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Roomlink | Welcome</title>
</head>

<body>
    <?php include "include/header.php" ?>
    <main class="container form-signin w-10 m-auto col-lg-4 col-sm-6 col-md-6">
        <h1 class="h3 mb-3 fw-normal text-center mt-5 mb-5">welcome to roomlink</h1>
        <form action="login.php" method="post">
        <?php if (!empty($strError)) : ?>
            <div class="bg-warning rounded text-dark text-center">
                    <?php echo $strError; ?>
                </div>
            <?php endif; ?>
            <div class="form-floating border-bottom border-success">
                <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="email" required>
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating border-bottom border-success">
                <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="password"
                    required>
                <label for="txtPassword">Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2 mt-4" type="submit">Sign in</button>
        </form>
        <p class="mt-5 mb-3 text-body-secondary"><a href="password_reset.php">forgot password ?</a></p>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
    crossorigin="anonymous"></script>

</html>
