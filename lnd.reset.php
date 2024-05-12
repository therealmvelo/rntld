<?php
include 'include/config.php';
include 'logic/lnd.reset.php';
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
    <div class="container m-5">
        <div class="form-container w-10 m-auto col-lg-4 col-sm-6 col-md-6">
            <form method="post">
                <div class="form-group">
                    <div class="form-floating border-bottom border-success rounded">
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password" required>
                        <label for="txtPassword">Create Password</label>
                    </div>
                    <div class="form-floating border-bottom border-success rounded">
                        <input type="password" class="form-control" id="txtConfirmPassword" name="txtConfirmPassword" placeholder="Confirm Password" required>
                        <label for="txtConfirmPassword">Confirm Password</label>
                    </div>      
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>


  </div>
  

    </div>
   
   </body>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>