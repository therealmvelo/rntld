<?php
include 'include/config.php';
include 'mailer.php';
include 'logic/password_reset.php';
$db = new DbConnect;
$conn = $db->connect();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <title>title</title>
   </head>
   <body>
    <?php include 'include/header.php';?>
    <div class="container m-5 justify-content-center">
        <form method="post">
            <div class=" col-lg-4 col-sm-7 col-md-7">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control border border-secondary" name="txtEmail" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
   
   </body>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>