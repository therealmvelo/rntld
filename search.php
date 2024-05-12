<?php
session_start();
error_reporting(E_ALL);
include 'include/config.php';

$db = new DbConnect;
$conn = $db->connect();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
        crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
    <title>title</title>
</head>

<body>
    <?php include 'include/header.php';
             include 'include/miniheader.php';
            # include "include/quicksearch.php";
        ?>


            <?php
    include 'logic/search.php';
    if ($results) {
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $amenities = '';
                if ($row['WiFi']) {
                    $amenities .= '<i class="fas fa-wifi rounded border border-dark p-1"></i></li>';
                }
                if ($row['Bed']) {
                    $amenities .= '<li><i class="fas fa-bed rounded border border-dark p-1"></i></li>';
                }
                if ($row['TV']) {
                    $amenities .= '<li><i class="fas fa-tv rounded border border-dark p-1"></i></li>';
                }
                if ($row['Electricity']) {
                    $amenities .= '<li><i class="fas fa-plug rounded  border border-dark p-1"></i></li>';
                }
                ?>
<div class="container mt-5">
  <div class="card mb-3 mt-5 col-lg-11 col-sm-12">
    <div class="card-header bg-secondary ">
      <div class="row">
        <div class="col-lg-10 text-white">
          <p><?php echo $row['PropertyTitle'];?></p>
        </div>
        <div class="col-lg-2 col-sm-4 text-end fw-bolder">
          <a class="p-1 bg-white rounded border border-danger text-decoration-none" href="#price">R <?php echo $row['Price'];?></a>
        </div>
      </div>
    </div>

    <div class="row g-0">
      <div class="col-lg-3 col-sm-4 col-md-8">
      <div id="propertyCarousel<?php echo $row['PropertyID']; ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="admin/property/images/<?php echo $row['imgFront']; ?>" height="200" alt="Front View"class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgInside1']; ?>" height="200" alt="Side View"class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgInside2']; ?>" height="200" alt="Side View" class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgSide']; ?>" height="200" alt="Side View" class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgFence']; ?>" height="200" alt="Side View" class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgAdditional']; ?>" height="200" alt="Side View" class="rounded rounded-3" style="object-fit:cover;min-width:100%">
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
      </div>
      <!--div--1!-->
      <div class="col-lg-9 col-md-4 col-sm-8">
        <div class="card-body">
          <div class="row">
            <!--Description  container -->
            <div class="col-lg-8 col-sm-12">
              <h5 class="card-title">Description</h5>
              <ul class="list-group">
                <p><?php echo $row['PropertyDescription'];?></p>
              </ul>
            </div>
            <div class="col-lg-4 col-sm-12">
              <div class="row">
                <div class="col-12 text-end card-body">
                  <span class="badge d-flex align-items-center p-0 pe-2 rounded-pill flex-row-reverse">
                    <img class="rounded-circle me-1" width="24" height="24" src="admin/users/images/<?php echo $row['imgProfile'];?>" alt="">
                    <p class="m-1 text-dark">posted by<a href="l.profile.php?LandlordID=<?php echo $row['LandlordID']; ?>"> <u><?php echo strtolower($row['LandlordName']);?></u></a></p>
                    <span class="vr mx-2"></span>
                    <a href="#"><svg class="bi" width="16" height="16"><use xlink:href="#x-circle-fill"/></svg></a>
                  </span>
                  <div class="col-12"><!---verification status-->
                  <?php if ($row["isVerified"] === "yes") { ?>
                    verified <img src="resources/icons/verify.png" height="15" width="15" alt="verify"> <?php }else{?> <small class="text-danger">not verified </small> <img src="resources/icons/close.png" height="15" width="15" alt="not verify"> <?php } ?>
                  </div>
                  <div class="col-12">
                    <h5 class="card-text fw-medium ">  <?php# echo $row['Price'];?> </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Move the button outside the inner row and use 'ms-auto' to push it to the right -->
                <div class="justify-content-end text-end card-text">
                    <a class="btn btn-primary" type="button"  href="booking.php?PropertyID=<?php ecHo $row['PropertyID'];?>">Check Availability <img src="resources/icons/greater-than.png" height="25" width="20" alt=""></a></div>
                </div>
          </div>
          
        </div>
        <div class="card-footer border mt-1 p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="list-unstyled d-flex gap-3 col-6 text-secondary"><?php echo $amenities; ?></div>
                </div>
            </div>
            
      </div>
    </div>
  </div>
</div>
            <?php
       }
      
   } else {?> 
   
   <div class="container">
        <div class="notfound-container mt-5 text-center ">
            <img src="resources/icons/dangerous.png" height="80" width="80" alt="">
            <h4>No Properties Found !</h4>
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
}    
else{echo "An error occurred";}
    
?>
<?php
// Pagination controls
// Calculate total number of pages
$total_pages = ceil($totalRows / $resultsPerPage);

// Display pagination controls if there is more than one page
if ($total_pages > 0) {
    echo "<ul class='pagination justify-content-center'>";
    if ($page > 1) {
        echo "<li class='page-item'><a class='page-link' href='?page=1&search=$searchTerm'>First</a></li>";
        echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "&search=$searchTerm'>Previous</a></li>";
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i&search=$searchTerm'>$i</a></li>";
    }
    if ($page < $total_pages) {
        echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "&search=$searchTerm'>Next</a></li>";
        echo "<li class='page-item'><a class='page-link' href='?page=$total_pages&search=$searchTerm'>Last</a></li>";
    }
    echo "</ul>";
}
?>

</div>
</div>

   </body>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>
