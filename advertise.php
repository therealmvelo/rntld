<?php 
session_start();
/* Check if a student or landlord is logged in
if (isset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userType'])) {
   $userID = $_SESSION['userID'];
   $userName = $_SESSION['userName'];
   $userType = $_SESSION['userType'];

} else {
   // Redirect users who are not logged in to the login page
   header("Location: login.php");
   exit(); // Ensure that script execution stops after redirection
}*/
?>
<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <title>Advertise</title>
   </head>
   <body>
      <?php include "include/header.php";?>
      <div class="container">

         <div class="h4 text-center m-5">Welcome to our advertising panel</div>
         <h5>Our Ads come in various forms</h5>

         
         <div class="container-fluid">
            <div class="row">
         <div class="col-lg-3 col-sm-12 col-md-6 mt-3">
                <div class="card shadow-sm border border border-secondary rounded-2">
                    <!-- Add the appropriate image source for the city -->
                    <img src="marketing\images\marketing.png" height="200" alt="ad">
                    <div class="card-body">
                        <p class="card-text h5">Ad title</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="searchresults.php?adid=?>" aria-label="just testing aria label" class="btn btn-secondary col-lg-12">Signup</a>
                            </div>
                            <small class="text-body-secondary"><a href="">#Ad</a></small>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="col-lg-3 col-sm-12 col-md-6 mt-3">
                <div class="card shadow-sm border border-secondary rounded-2" style="box-shadow: black 2px 1px 1px 1px;">  
                    <div class="card-header justify-content-end d-flex text-center p-0">
                        <small class="text-start rounded m-1 text-dark px-1 col"><img src="resources/icons/impressions.png" height="15" width="20" alt="verify"></small>
                        <h5 class="text-end bg-dark rounded m-1 text-white px-1">Ad</h5>
                    </div>
                    <!-- Add the appropriate image source for the property -->
                    <img src="marketing\images\marketing.png" height="200" alt="Ad">
                    <div class="card-body">
                        <p class="card-text h5">Ad title</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="booking.php?PropertyID=" class="btn btn-secondary col-lg-12">View</a>
                            </div>
                            <small class="text-body-secondary"><i class="fa-regular fa-clock"></i>date</small>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
      <div class="card mb-3 m-5 border border-secondary rounded-2" style="">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="marketing\images\marketing.png" height="20" class="img-fluid" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text text-end"><small class="text-body-secondary"><a href="" class="btn btn-secondary col-lg-2">View</a></small></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-12 col-md-6 mt-3 mb-5">
                <div class="card shadow-sm border border-secondary rounded-2" style="box-shadow: black 2px 1px 1px 1px;">  
                    <div class="card-header justify-content-end d-flex text-center p-0">
                        <small class="text-start rounded m-1 text-dark px-1 col"><img src="resources/icons/impressions.png" height="15" width="20" alt="verify"></small>
                        <h5 class="text-end bg-dark rounded m-1 text-white px-1">Ad</h5>
                    </div>
                    <!-- Add the appropriate image source for the property -->
                    <div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="marketing\images\marketing.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="marketing\images\marketing.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="marketing\images\marketing.png" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bg-dark text-white rounded rounded-pill fw-bold opacity-25" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon bg-dark text-white rounded rounded-pill fw-bold opacity-25" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
                    <div class="card-body">
                        <p class="card-text h5">Ad title</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="booking.php?PropertyID=" class="btn btn-secondary col-lg-12">View</a>
                            </div>
                            <small class="text-body-secondary"><i class="fa-regular fa-clock"></i>date</small>
                        </div>
                    </div>
                </div>
            </div>

            
      </div>
      
   </body>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>