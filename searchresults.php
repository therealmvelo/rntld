<?php
session_start();
error_reporting(0);
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

include 'logic/searchresults.php';
?>


<!DOCTYPE html>
<html lang="en">

<!--div class="col-lg-8 col-sm-12">
    <h5 class="card-title">Amenities</h5>
    <?php?>/*?>
    $amenities = [
        'WiFi' => $row['WiFi'],
        'Bed' => $row['Bed'],
        'TV' => $row['TV'],
        'Electricity' => $row['Electricity']
    ];

    $availableAmenities = array_filter($amenities, function($value) {
        return $value == 1;
    });

    if (empty($availableAmenities)) {
        echo "<p>No amenities listed for this property.</p>";
    } else {
        echo "<ul class='list-group'>";
        foreach ($availableAmenities as $amenity => $value) {
            echo "<li class='list-group-item'>$amenity</li>";
        }
        echo "</ul>";
    }
    ?>
</div-->
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <!--link rel="stylesheet" href="global/global.css"-->
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <title>  Search | <?php echo $cityName; ?></title>
   </head>
   <style type="text/css">
   .image-container {
      position: relative;
    }

    .text-overlay {
      position: absolute;
      top: 10%;
      left: 20%;
      transform: translate(-50%, -50%);
      color: #fff;
      text-align: center;
    }
    li{
      list-style-type:none;
    }
    a{
  
      text-decoration:none;
    }
    body{
      -webkit-text-size-adjust: 100%;
    }
   </style>
   
   <body>
       <?php 
       include "include/header.php";
       include "include/miniheader.php";
       ?>
 
      
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb mx-5">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a href="#">search</a></li>
    <li class="breadcrumb-item"><a href="#"><?php echo strtolower($cityName); ?></a></li>
  </ol>
</nav>
<?php #include "include/quicksearch.php";?>
 <?php
 if ($result->num_rows === 0) { ?>

  <div class="container">
      <div class="notfound-container mt-5 text-center">
          <img src="resources/icons/dangerous.png" height="80" width="80" alt="">
          <h4>No properties found in this city!</h4>
              <div class="inform">
                  <small>this is probably because the landlords do not know about this platform
                  <br><b>here is how you can let them know about us :</b></small>
                  <ul class="list-group list-group-horizontal col-12 justify-content-center">
                      <!-- Facebook Share -->
                          <li class="nav-link text-secondary">
                              <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.rentlad.co.za" target="_blank">
                                  <img src="resources/icons/facebook.png" height="30" width="30" alt="Facebook">
                              </a>
                          </li>
                          <!-- WhatsApp Share -->
                          <li class="nav-link text-secondary">
                              <a href="whatsapp://send?text=Check out this website for student accomodation: https://www.rentlad.co.za" data-action="share/whatsapp/share" target="_blank">
                                  <img src="resources/icons/whatsapp.png" height="30" width="30" alt="WhatsApp">
                              </a>
                          </li>
                          <!-- Twitter Share -->
                          <li class="nav-link text-secondary">
                              <a href="https://twitter.com/intent/tweet?url=https://www.rentlad.co.za" target="_blank">
                                  <img src="resources/icons/twitter.png" height="30" width="30" alt="Twitter">
                              </a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
<?php } else 
 while ($row = $result->fetch_assoc()) {

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
          <a class="p-1 bg-white rounded border border-danger">R <?php echo $row['Price'];?></a>
        </div>
      </div>
    </div>

    <div class="row g-0">
      <div class="col-lg-3 col-sm-4 col-md-8">
      <div id="propertyCarousel<?php echo $row['PropertyID']; ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="admin/property/images/<?php echo $row['imgFrontView']; ?>" height="200" alt="Front View"class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgSideView']; ?>" height="200" alt="Side View"class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgInside1']; ?>" height="200" alt="Side View" class="rounded rounded-3" style="object-fit:cover;min-width:100%">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $row['imgInside2']; ?>" height="200" alt="Side View" class="rounded rounded-3" style="object-fit:cover;min-width:100%">
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
                    <img class="rounded-circle me-1" width="24" height="24" src="admin/users/images/<?php echo $row['lndProfileImage'];?>" alt="">
                    <p class="m-1 text-dark">posted by<a href="l.profile.php?LandlordID=<?php echo $row['LandlordID']; ?>"> <u><?php echo strtolower($row['lndName']);?></u></a></p>
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
   }?>

  </div>

  <?php
    // Pagination controls
    // Calculate total number of pages
    $total_pages = ceil(5 / $propertiesPerPage);
echo $total_pages,$result->num_rows,$propertiesPerPage;
    // Display pagination controls if there is more than one page
    if ($total_pages > 0) {
        echo "<ul class='pagination justify-content-center'>";
        if ($current_page > 1) {
            echo "<li class='page-item'><a class='page-link' href='?cid=$cityID&page=1&name=$cityName'>First</a></li>";
            echo "<li class='page-item'><a class='page-link' href='?cid=$cityID&page=" . ($current_page - 1) . "&name=$cityName'>Previous</a></li>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item " . ($current_page == $i ? 'active' : '') . "'><a class='page-link' href='?cid=$cityID&page=$i&name=$cityName'>$i</a></li>";
        }
        if ($current_page < $total_pages) {
            echo "<li class='page-item'><a class='page-link' href='?cid=$cityID&page=" . ($current_page + 1) . "&name=$cityName'>Next</a></li>";
            echo "<li class='page-item'><a class='page-link' href='?cid=$cityID&page=$total_pages&name=$cityName'>Last</a></li>";
        }
        echo "</ul>";
    }
?>
   </body>
   <?php include('include/footer.php');?>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>