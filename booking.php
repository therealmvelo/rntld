<?php 
include 'logic/booking.php';
?>

<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
       <link rel="stylesheet" href="https://unpkg.com/leaflet-search@2.9.11/dist/leaflet-search.min.css" />

       <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
       <script src="https://unpkg.com/leaflet-search@2.9.11/dist/leaflet-search.min.js"></script>
       <title>Property booking</title>   
       	<style>
    body {
	margin: 0;
}

.image-grid {
	--gap: 16px;
	--num-cols: 4;
	--row-height: 150px;

	box-sizing: border-box;
	padding: var(--gap);

	display: grid;
	grid-template-columns: repeat(var(--num-cols), 1fr);
	grid-auto-rows: var(--row-height);
	gap: var(--gap);
}

.image-grid>img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.image-grid-col-2 {
	grid-column: span 2;
}

.image-grid-row-2 {
	grid-row: span 2;
}

/* Anything udner 1024px */
@media screen and (max-width: 1024px) {
	.image-grid {
		--num-cols: 2;
		--row-height: 200px;
	}
}
/*lighbox style*/
.custom-row > .custom-column {
  padding: 0 8px;
}

.custom-row::after {
  content: "";
  display: table;
  clear: both;
}

.custom-column {
  float: left;
  width: 120px;
}

/* The Modal (background) */
.custom-modal {
  display: none;
  position: fixed;
  z-index: 9999;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.custom-modal-content {
  position: relative;
  background-color: grey;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
  overflow:hidden;
}

/* The Close Button */
.custom-close {
  color: white;
  position: absolute;
  top: 100px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.custom-close:hover,
.custom-close:focus {
  color: white;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.custom-cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.custom-prev,
.custom-next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.custom-next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.custom-prev:hover,
.custom-next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.custom-hover-shadow {
  transition: 0.3s;
}

.custom-hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.rounded-image{
    border-radius:0%;
}
  </style>  
   </head>
   <body style="background-color:#CFEBF2"; >
    <?php include "include/header.php";?>
    
    
      
      

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb mx-5 mt-3">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item "><a href="#" class="text-secondary">booking</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $Title;?></li>
  </ol>
</nav>
<div class="container min-vh-100">
    <div class="alert mb-0" role="alert">
        <p class="border border-info p-1 rounded">
            <i class="fa-solid fa-circle-info text-info"></i> this property currently has <?php echo $NumberOfRooms; ?> rooms available
        </p>
    </div>
    <div class="col-12">
        <?php
        if ($userType === "student" && $NumberOfRooms > 0) {
            ?>
            <!--display booking from if student looged in [frm start]-->
            <div class="container text-center">
                <form method="post" id="dateRangeForm" name="propertyBooking" class="col mb-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 p-0">
                                <div class="input-group mb-0">
                                    <span class="input-group-text border border-5 border-warning" id="basic-addon01">check-in</span>
                                    <input type="date" class="form-control border border-5 border-warning" id="fromDate" name="checkInDate" required>
                                </div>
                            </div>
                            <div class="col-lg-5 p-0">
                                <div class="input-group m-0 text-start">
                                    <span class="input-group-text border border-5 border-warning" id="basic-addon1">check-out</span>
                                    <input type="date" class="form-control border border-5 border-warning m-0 col-12" id="toDate" name="checkOutDate" required>
                                </div>
                            </div>
                            <button class="btn col-lg-2 d-flex justify-content-center border border-5 border-warning bg-primary btn text-white fw-bolder" type="submit" name="submit">
                                book
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!--[frm end-->
        <?php } elseif ($userType === "landlord") {
            echo "";
        } else {
            echo "<div class='bg-warning text-danger rounded fw-semibold px-1'>this property is fully booked</div>";
        } ?>
        <!---a href="payment.php?PropertyID=<?php# echo $PropertyID;?>"><button type="button" class="btn btn-primary">Reserve this room for R<?php# echo $Price;?></button></a-->
    </div>

    <div class="col-12">
        <?php echo $bookingSent; ?>
        <!--hidden carousel on large screens -->
        <div id="carouselExample" class="carousel slide mt-3 mb-3 rounded d-block d-lg-none" style="height:200px;overflow:hidden;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="admin/property/images/<?php echo $imgFront; ?>" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $imgSide; ?>" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="admin/property/images/<?php echo $imgInside1; ?>" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!--carousel end-->
    </div>   
    <div class="col-12">
      <div class="image-grid rounded border border-dark bg-white position-relative rounded d-none d-lg-grid">
      <!-- Sponsored label positioned at the top right corner -->
        <div class="btn text-end bg-white shadow p-1 position-absolute top-0 end-0 rounded m-1" onclick="openModal();">View All Images</div>
        <!-- Your images go here -->
          <img class="image-grid-col-2 image-grid-row-2 rounded col-md-12" src="admin/property/images/<?php echo $imgFront; ?>" alt="architecture" onclick="openModal();currentSlide(1)">
          <img src="admin/property/images/<?php echo $imgInside2; ?>" alt="architecture" onclick="openModal();currentSlide(2)">
          <img src="admin/property/images/<?php echo $imgInside1; ?>" alt="architecture" onclick="openModal();currentSlide(3)">
          <img src="admin/property/images/<?php echo $imgFence; ?>" alt="architecture" onclick="openModal();currentSlide(4)">
          <img src="admin/property/images/<?php echo $imgAdditional; ?>" alt="architecture" onclick="openModal();currentSlide(5)" class="d-none d-lg-grid">
      </div>
    </div>
    
        <!--lightbox modal-->
        <div id="myModal" class="custom-modal">
            <span class="custom-close custom-cursor btn-close " onclick="closeModal()">&times;</span>
            <div class="custom-modal-content">
                <div class="mySlides">
                    <div class="numbertext">1 / 4</div>
                    <img src="admin/property/images/<?php echo $imgFront; ?>" style="width: 1auto;height: auto;max-height: 70vh;object-fit:">
                </div>
                <div class="mySlides">
                    <div class="numbertext">1 / 4</div>
                    <img src="admin/property/images/<?php echo $imgInside1; ?>" style="width: 1auto;height: auto;max-height: 70vh;">
                </div>
                <div class="mySlides">
                    <div class="numbertext">2 / 4</div>
                    <img src="admin/property/images/<?php echo $imgInside2; ?>" style="width: 1auto;height: auto;max-height: 70vh;">
                </div>
                <div class="mySlides">
                    <div class="numbertext">3 / 4</div>
                    <img src="admin/property/images/<?php echo $imgFence; ?>" style="width: 1auto;height: auto;max-height: 70vh;">
                </div>
                <div class="mySlides">
                    <div class="numbertext">4 / 4</div>
                    <img src="admin/property/images/<?php echo $imgAdditional; ?>" style="width: 1auto;height: auto;max-height: 70vh;">
                </div>
                <a class="custom-prev custom-cursor" onclick="plusSlides(-1)">&#10094;</a>
                <a class="custom-next custom-cursor" onclick="plusSlides(1)">&#10095;</a>
                <div class="caption-container">
                    <p id="caption"></p>
                </div>
                <div class="container-fluid">
                    <div class="custom-row">
                        <div class="custom-column">
                            <img class="demo custom-cursor" src="admin/property/images/<?php echo $imgFront; ?>" height="100" style="width:100px;object-fit:cover;" onclick="currentSlide(1)" alt="Nature and sunrise">
                        </div>
                        <div class="custom-column">
                            <img class="demo custom-cursor" src="admin/property/images/<?php echo $imgInside1; ?>" height="100" style="width:100px" onclick="currentSlide(2)" alt="Snow">
                        </div>
                        <div class="custom-column">
                            <img class="demo custom-cursor" src="admin/property/images/<?php echo $imgInside2; ?>" height="100" style="width:100px" onclick="currentSlide(3)" alt="Mountains and fjords">
                        </div>
                        <div class="custom-column">
                            <img class="demo custom-cursor" src="admin/property/images/<?php echo $imgFence; ?>" height="100" style="width:100px" onclick="currentSlide(4)" alt="Northern Lights">
                        </div>
                        <div class="custom-column">
                            <img class="demo custom-cursor" src="admin/property/images/<?php echo $imgAdditional; ?>" height="100" style="width:100px" onclick="currentSlide(5)" alt="Northern Lights">
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="row mt-3 mb-5">
  <div class="col-lg-6">
      <div class="accordion mb-5" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong class="bg-dark rounded p-1 text-warning">Description</strong>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body border-bottom border-end border-start border-secondary rounded position-relative ">
                            <div class="justify-content-end d-flex text-center p-0">
                                <div class="text-end text-secondary px-1 position-absolute top-0 end-0 h5">#</div>
                            </div>                            
                            <?php echo $Description; ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <strong class="bg-dark rounded p-1 text-warning">Rules</strong>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body border border-secondary rounded position-relative">
                            <div class="justify-content-end d-flex text-center p-0">
                                <div class="text-end text-secondary px-1 position-absolute top-0 end-0 h5">#</div>
                            </div> 
                            <p><?php echo $Rules; ?></p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <strong class="bg-dark rounded p-1 text-warning">Facilities</strong>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body border border-secondary rounded position-relative">
                            <div class="justify-content-end d-flex text-center p-0">
                                <div class="text-end text-secondary px-1 position-absolute top-0 end-0 h5">#</div>
                            </div> 
                          <?php echo '<small>'.$amenities.'</small>'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-lg-6">
        <!--map containing the exact coords of the property-->
        <div class="card mt-0 rounded border border-success" id="mapcontainer">
            <div class="card-header bg-success text-white">this property is <span id="distance"></span> km away from <?php echo "<b>".strtolower($cname)."</b>"; ?></div>
            <div class="map card-body" id="map" style="min-height:230px"></div>
        </div>
        <!--map end-->
    </div> 
    <div class="col-lg-6">
        <!--div class="card">
            <div class="card-header">landlord</div>
            <div class="card-text"><?php echo $landlordName,$landlordSurname,$landlordNumber,$landlordEmail; ?></div>
            <div class="row d-flex justify-content-center align-items-center h-100">
        
      </div>
        </div-->
        <div class="container mt-5">
            <div class="card border border-3 border-secondary position-relative ">
                <div class="card-header justify-content-end d-flex text-center p-0">
                    <small class="text-end bg-danger rounded m-1 px-1 position-absolute top-0 end-0">landlord</small>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-4">
                        <img src="admin/users/images/<?php echo $landlordProfileImg; ?>" class="rounded-image rounded" alt="Profile Image" width="150">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo strtoupper($landlordName." ".$landlordSurname); ?></h5>
                        <div class="p"><?php echo $getDetails['propertyCount'].' '."Properties";?></div>
                        <a href="#" class="link">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--landlord card end-->
    </div>



        </div>
    </div>
</div>
<?php include 'include/footer.php'; ?>
<script>
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
    }

    var map;

    // Arrays to store coordinates
    var coordinates = [];

    // Function to initialize the map with a marker at the specified coordinates
    function initMap(latitude, longitude, customIconClass) {
        // Check if the map has been initialized
        if (!map) {
            // Initialize the map
            map = L.map('map').setView([latitude, longitude], 25);

            // Add a tile layer to the map (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
        }

        // Add a marker to the map at the specified coordinates
        var marker = L.marker([latitude, longitude]).addTo(map);

        // Set custom marker icon if provided
        if (customIconClass) {
            var customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<i class="h3 ' + customIconClass + '"></i>',
                iconSize: [32, 32], // Size of the icon
                iconAnchor: [16, 32] // Point of the icon which will correspond to marker's location
            });
            marker.setIcon(customIcon);
        }
        // Add coordinates to the array
        coordinates.push([<?php echo $clatitude;?>, <?php echo $clongitude;?>]);

        var popupContent;
        if (latitude == <?php echo $clatitude;?> && longitude == <?php echo $clongitude;?>) {
            popupContent = "<div class='card'><div class='card-title fw-bold'><?php echo $cname;?></div>";
        } else {
            popupContent = '<p>property you are viewing</p>';
        }
        marker.bindPopup(popupContent);

        // Show popup on mouseover
        marker.on('mouseover', function (e) {
            marker.openPopup();
        });

        // Hide popup on mouseout
        marker.on('mouseout', function (e) {
            marker.closePopup();
        });
    }

    // Call the function to initialize the map with the provided coordinates and custom icon class
    initMap(<?php echo $latitude ?>, <?php echo $longitude ?>, 'text-danger fa-solid fa-building');
    initMap(<?php echo $clatitude;?>, <?php echo $clongitude;?>, 'text-danger fa-solid fa-building-columns');

    // Function to draw route on map
    function drawRoute(route) {
        L.polyline(route, { color: 'blue' }).addTo(map);
    }

    // Function to decode polyline geometry from OSRM
    function decodePolyline(polyline) {
        var coordinates = [];
        var index = 0;
        var lat = 0;
        var lng = 0;

        while (index < polyline.length) {
            var shift = 0;
            var result = 0;

            do {
                var byte = polyline.charCodeAt(index++) - 63;
                result |= (byte & 0x1f) << shift;
                shift += 5;
            } while (byte >= 0x20);

            var deltaLat = ((result & 1) ? ~(result >> 1) : (result >> 1));
            lat += deltaLat;

            shift = 0;
            result = 0;

            do {
                var byte = polyline.charCodeAt(index++) - 63;
                result |= (byte & 0x1f) << shift;
                shift += 5;
            } while (byte >= 0x20);

            var deltaLng = ((result & 1) ? ~(result >> 1) : (result >> 1));
            lng += deltaLng;

            coordinates.push([lat / 1e5, lng / 1e5]);
        }

        return coordinates;
    }

      // Function to calculate distance between two coordinates in kilometers using Haversine formula
  function calculateDistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius of the Earth in kilometers
    var dLat = deg2rad(lat2 - lat1);
    var dLon = deg2rad(lon2 - lon1);
    var a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var distance = R * c; // Distance in kilometers
    return distance;
  }

  function deg2rad(deg) {
    return deg * (Math.PI / 180);
  }
    // Function to get route between two coordinates using OSRM
    function getRoute(startCoord, endCoord) {
        var osrmUrl = 'https://router.project-osrm.org/route/v1/driving/';
        var waypoints = startCoord[1] + ',' + startCoord[0] + ';' + endCoord[1] + ',' + endCoord[0];
        var requestUrl = osrmUrl + waypoints + '?alternatives=false&geometries=polyline';

        fetch(requestUrl)
            .then(response => response.json())
            .then(data => {
                if (data.code === 'Ok' && data.routes && data.routes.length > 0 && data.routes[0].geometry) {
                    var decodedRoute = decodePolyline(data.routes[0].geometry);
                    drawRoute(decodedRoute);

                    var distance = calculateDistance(startCoord[0], startCoord[1], endCoord[0], endCoord[1]);
                    document.getElementById('distance').innerHTML = distance.toFixed(2);

                } else {
                    console.error('Error fetching route:', data);
                }
            })
            .catch(error => console.error('Error fetching route:', error));
    }

    // Predefined start and end coordinates
    var startCoord = [<?php echo $latitude ?>, <?php echo $longitude ?>]; // Example start coordinate
    var endCoord = [<?php echo $clatitude;?>, <?php echo $clongitude;?>]; // Example end coordinate

    // Get route between start and end coordinates
    getRoute(startCoord, endCoord);
</script>

   </body>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>