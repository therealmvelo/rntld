<?php
session_start();
error_reporting(0);
include 'include/config.php';
include 'logic/index.php';
?>
<!DOCTYPE html>
<html lang="en" >
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta property="og:description" content="RentLad Accomodation - Discover Your Perfect Accomodation">
       <meta property="og:image" content="resources/images/roomlink.png">
       <title property="og:title">RentLad - Student Accomodation</title>
       <meta property="og:type" content="website">
       <meta name="twitter:title" content="RentLad - Student Accomodation">
       <meta name="twitter:description" content="RentLad Accomodation - Discover Your Perfect Accomodation">
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <style>
    .custom-container {
        overflow-x:auto;
        width:auto;
    }
  </style>
    </head>
   <body style="background-color:#CFEBF2";>
<?php 
    include "include/header.php";
    include "include/miniheader.php";
    #include "include/quicksearch.php"  
?>

</div>
<div class="container">
    
    <h3 class="mt-2">Popular Cities and Towns</h3>
    <p style="margin-top: 0">Explore the most viewed places</p>    
    <div class="container-fluid">
        <div class="row">
            <?php
                $sql = "SELECT City.CityID, CityImage, City.CityName, COUNT(Property.PropertyID) AS NumProperties
                FROM City
                LEFT JOIN Property ON City.CityID = Property.FK_CityID
                GROUP BY City.CityID
                ORDER BY NumProperties DESC
                LIMIT 4
                ";
    $result = $conn->query($sql);
    $counter = 0; // Counter to keep track of cities

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>        
            <div class="col-lg-3 col-sm-12 col-md-6 mt-3">
                <div class="card shadow-sm">
                    <!-- Add the appropriate image source for the city -->
                    <img src="admin/city/images/<?php echo $row['CityImage']; ?>" height="200" alt="" class="rounded rounded-3">
                    <div class="card-body">
                        <p class="card-text h5"><?php echo $row['CityName']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="searchresults.php?cid=<?php echo $row['CityID'];?>&name=<?php echo $row['CityName']?>" aria-label="just testing aria label" class="btn btn-primary col-lg-12">Explore</a>
                            </div>
                            <small><a href="" class="text-danger fw-bolder text-decoration-none h6 p-1"><?php echo $row['NumProperties']; ?> Properties</a></small>
                        </div>
                    </div>
                </div>
            </div>
      <?php
      $counter++;
      if ($counter == 3 ) {
          break; // Break the loop after displaying the first three cities
      }  
    }?>

    <!--advertisement--->
    <div class="col-lg-3 col-sm-12 col-md-6 mt-3">
        <div class="card shadow-sm border">
            <img src="marketing\images\marketing.png" height="200" alt="Ad">
            <div class="card-body">
                <p class="card-text h5"><?php echo "Advertisement"; ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="" aria-label="just testing aria label" class="btn btn-primary col-lg-12">Explore</a>
                    </div>
                    <small class="text-body-secondary"><a href="">sponsered</a></small>
                </div>
            </div>
        </div>
    </div>

    <?php 
    } else {
        echo "<p class='bg-danger rounded'>No cities found.</p>";
    }
    ?>
        </div>
    </div>
    
</div>
<div class="container">
    <div class="row">
    <div class="card mt-5 border border-secondary" style="">
        
  <div class="row g-0">
    <div class="col-md-4">
      <img src="marketing\images\marketing.png" height="20" class="img-fluid" alt="...">
    </div>
    <div class="col-md-8">
        <div class="card-header justify-content-end d-flex text-center p-0 position-relative">
            <small class="text-end bg-secondary rounded m-1 text-warning px-1 position-absolute top-0 end-0">Sponsored</small>
        </div>
        <div class="card-body">

            <h5 class="card-title">sponsered content</h5>
                <p class="card-text">This is a wider text showing sample content for demonstration of which is just blah blah blah and more blar bit not blurry though. This content is a little bit longer.</p>
                     <div class="row">
                        <div class="col justify-content-start ">
                            <p class="card-text"><small class="text-body-secondary">#Ad</small></p>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 justify-content-end">
                            <p class="card-text">
                                <small class="text-body-secondary">
                                    <a href="" aria-label="just testing aria label" class="btn col-12 border border-primary ">Sign Up -></a>
                                </small>
                            </p>
                        </div>
                    </div>
        
                </div>
        </div>
  </div>
</div>
    </div>
</div>
<div class="container mb-5">
        <div class="row">
            <h3 class="mt-5">Featured Rooms</h3>
            <p style="margin-top:0">Explore properties on high demand</p>
            <?php       
                $sql = "SELECT * FROM Property ORDER BY RAND() LIMIT 4";
                $result = $conn->query($sql);
                $counter = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $viewCount = $row['ViewCount'];
                        $FormattedViewCount = formatNumber($viewCount);

                        $datePosted = new DateTime($row['datePosted']);
                        $formattedDate = $datePosted->format('j M Y');
            ?>
          
<div class="col-lg-3 col-sm-12 col-md-6 mt-3">
    <div class="card shadow-sm" style="box-shadow: black 2px 1px 1px 1px;"> 
        <div class="card-header justify-content-end d-flex p-0">
            <small class="text-start rounded m-1 text-secondary px-1 col"><?php echo htmlspecialchars($FormattedViewCount); ?> <i class="fa-solid fa-eye"></i></small>
            <h6 class="text-end p-1 fw-bold">R <?php echo $row['Price'];?></h6>
        </div>
        <div id="propertyCarousel<?php echo $row['PropertyID']; ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="admin/property/images/<?php echo $row['imgFrontView']; ?>" height="200" alt="Front View"class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgSideView']; ?>" height="200" alt="Side View"  style="object-fit:cover;width:100%;">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgInside1']; ?>" height="200" alt="Side View"  style="object-fit:cover;width:100%;">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgInside2']; ?>" height="200" alt="Side View"  style="object-fit:cover;width:100%;">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgFence']; ?>" height="200" alt="Side View"  style="object-fit:cover;width:100%;">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgAdditional']; ?>" height="200" alt="Side View" style="object-fit:cover;width:100%;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel<?php echo $row['PropertyID']; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon  bg-dark text-white rounded rounded-pill fw-bold" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel<?php echo $row['PropertyID']; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon  bg-dark text-white rounded rounded-pill fw-bold" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $row['PropertyTitle']; ?></p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="booking.php?PropertyID=<?php echo $row['PropertyID'];?>" class="btn btn-primary col-lg-12">View</a>
                </div>
                <small class="text-body-secondary"><i class="fa-regular fa-clock"></i> <?php echo  $formattedDate; ?></small>
            </div>
        </div>
    </div>
</div>
            <?php
                $counter++;
                if ($counter == 3 ) {
                    break; // Break the loop after displaying the first three cities
                    }
                }?>
                    <div class="col-lg-3 col-sm-12 col-md-6 mt-3">
                        <div class="card shadow-sm" style="box-shadow: black 2px 1px 1px 1px;"> 
                         
                            <div class="card-header justify-content-end d-flex text-center p-0">
                                <small class="text-start rounded m-1 text-dark px-1 col"><?php echo htmlspecialchars($FormattedViewCount); ?> <img src="resources/icons/impressions.png" height="15" width="22" alt="verify"></small>
                                <h5 class="text-end bg-dark rounded m-1 text-warning px-1">#Ad</h5>
                            </div>
                            <!-- Add the appropriate image source for the property -->
                            
                            <img src="marketing\images\marketing.png" alt="" class="img-fluid rounded-bottom" style="object-fit:cover;height:212px">

                            <div class="card-body">
                            <p class="card-text h5">this is just an ad</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                    <a href="booking.php?PropertyID=<?php echo $row['PropertyID'];?>" class="btn btn-primary col-lg-12">View</a>
                                    </div>
                                    <small class="text-body-secondary"><i class="fa-regular fa-clock"></i> <?php echo  $formattedDate; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            } else {?>
                <div class="container">
                    <div class="notfound-container mt-5 text-center ">
                        <img src="resources/icons/dangerous.png" height="80" width="80" alt="">
                        <h4>No Featured Rooms Found !</h4>
                        <div class="inform">
                            <small>this is probably because the landlords do not know about this paltform <br><b>here is how you can let them know about us :</b></small>
                            <ul class="list-group list-group-horizontal col-12 justify-content-center ">
                            <li class="nav-link text-secondary"><img src="resources/icons/facebook.png" height="30" width="30" class="" alt="..."></li>
                            <li class="nav-link text-secondary"><img src="resources/icons/whatsapp.png" height="30" width="30" class="" alt="..."></li>
                            <li class="nav-link text-secondary"><img src="resources/icons/twitter.png" height="30" width="30" class="" alt="..."></li>
                            </ul> 
                        </div>
                    </div>
                </div>
                
           <?php }
                $conn->close();
            ?>
        </div>
    </div>       
<div class="container">
<div class="card mb-3 border-info mt-3 position-relative">
    <div class="card-header justify-content-end d-flex text-center p-0">
        <small class="text-end bg-secondary rounded m-1 text-warning px-1 position-absolute top-0 end-0">Sponsored</small>
    </div>
    <div class="row g-0">
        <div class="col-md-4">
            <img src="marketing\images\marketing.png" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Advert</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <div class="row">
                    <div class="col-8"><p class="card-text"><small class="text-body-secondary">12 June 2020</small></p></div>
                    <div class="col-4 text-end"><button class="btn btn-primary" type="button" aria-label="take action">Learn More</button></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
        <!-- Footer content -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Contact</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      support@rentlad.co.za
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<?php include "include/footer.php"; ?>

    <!-- Scripts (Bootstrap JS, custom scripts, etc.) -->
    <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>