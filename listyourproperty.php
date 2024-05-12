<?php
include 'logic/listyourproperty.php';
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

       <title>List Your Property</title>
       <style>
        #suggestions{
            list-style-type: none;
        }

        .txtCitySuggestions {
            cursor: pointer;
        }

        .txtCitySuggestions:hover {
            background-color: #f2f2f2;
        }

        .bold {
            font-weight: bold;
        }
        #mapcontainer{
            resize: both;
        }
       </style>
   </head>
   <body>
   <?php include "include/header.php" ?>
   
   <div class="container">
    <div class="row mx-1 mb-5">
        
        <form method="post" enctype="multipart/form-data" autocomplete="off">
        <!--h1 class="text-center">List your property</h1-->
        <h1 class="text-center my-5">List Your Property</h1>
            <h5 class="text-secondary">Basic information</h5>
            <div class="row mt-3">
                <div class="col-lg-2 col-sm-12"><label class="form-label">Title</label></div>
                <div class="col-lg-9 col-sm-12"><input type="text" name="txtTitle" id="txtTitle" placeholder="enter title"class="form-control border-secondary" required></div>   
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-12"><label class="form-label">Description</label></div>
                <div class="col-lg-9 col-sm-12"> <textarea class="form-control border-secondary" name="txtDescription" placeholder="Describe your property" id="txtDescription" required></textarea></div>   
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-12"><label class="form-label">Rules</label></div>
                <div class="col-lg-9 col-sm-12"> <textarea class="form-control border-secondary" name="txtRules" placeholder="Write your property rules here" id="txtRules"required></textarea></div>   
            </div>
            <h5 class="text-secondary mt-4">Price & location</h5>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Number of rooms</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtNumberofRooms" id="txtNumberofRooms" placeholder=""class="form-control border-secondary"required></div>
                <div class="col-lg-1 col-sm-6"><label class="form-label">Price</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtPrice" id="txtPrice" placeholder="price of each room"class="form-control border-secondary"required></div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">City</label></div>
                <div class="col-lg-4 col-sm-6">
                  <div class="city-container">
                        <input type="text" name="txtCity" id="txtCity" placeholder="City"class="form-control border-secondary"required>
                        <div id="txtCitySuggestions"></div>
                    </div>  
                </div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Surburb</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtSuburb" id="txtSuburb" placeholder="Surburb"class="form-control border-secondary"required></div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label for="txtStreetName" class="form-label" id="lblStreetName">Street</label></div>
                <div class="col-lg-4 col-sm-6">
                    <div class="autocomplete" style="">
                        <input type="text" name="txtStreetName" id="txtStreetName" placeholder="Street name"class="form-control border-secondary" required></div>
                        <div id="suggestions"></div>                       
                    </div>
                <div class="col-lg-2 col-sm-6"><label class="form-label">House Number</label></div>
                <div class="col-lg-3 col-sm-6"><input type="text" name="txtHouseNumber" id="txtHouseNumber" placeholder=""class="form-control border-secondary"required></div>
                               
            </div>
            <!--map-->
            <div class="card row col-sm-12 col-md-12 col-lg-11 mt-4 rounded border border-success" id="mapcontainer">
                <div class="card-header bg-success text-white">click to place the marker on your property for tenants to find it</div>
                <div class="map card-body" id="map" style="min-height:200px"></div>
                <div class="card-footer bg-dark "><button type="button" class="btn rounded border border-warning bg-white text-dark">confirm location</button></div>
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Nearest campus or university</label></div>
                <div class="col-lg-9 col-sm-6"><input type="text" name="txtNearestCampus" id="txtNearestCampus" placeholder="enter campus or university"class="form-control border-secondary"required><div class="rounded rounded-bottom bg-secondary-subtle" id="campusList"></div> </div>
                
            </div>
            <div class="row mt-4">
            <div class="col-lg-2 col-sm-12">
                <p>Provided Facilities</p>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input border-secondary" name="chkWiFi" id="chkWifi" value="WiFi">
                <label for="chkWifi">WiFi</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input border-secondary" name="chkBed" id="chkBed" value="Bed">
                <label for="chkBed">Bed</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input border-secondary" name="chkTV" id="chkTV" value="TV">
                <label for="chkTV">TV</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input border-secondary" name="chkElectricity" id="chkElectricity" value="Electricity">
                <label for="chkElectricity">Electricity</label>
            </div>

            </div>
            <h5 class="text-secondary mt-4">Property Images</h5>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Front View</label></div>
                <div class="col-lg-4 col-sm-6"><input type="file" name="imgFrontView" id="" class="form-control border-secondary"required accept=".jpg, .jpeg, .png"></div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Side View</label></div>
                <div class="col-lg-4 col-sm-6"><input type="file" name="imgSideView" id=""class="form-control border-secondary"required accept=".jpg, .jpeg, .png"></div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Inside (1)</label></div>
                <div class="col-lg-4 col-sm-6"><input type="file" name="imgInside1" id="" class="form-control border-secondary"required accept=".jpg, .jpeg, .png"></div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Inside (2)</label></div>
                <div class="col-lg-4 col-sm-6"><input type="file" name="imgInside2" id="" class="form-control border-secondary"required accept=".jpg, .jpeg, .png"></div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Property Fence</label></div>
                <div class="col-lg-4 col-sm-6"><input type="file" name="imgFence" id="" placeholder="City"class="form-control border-secondary" accept=".jpg, .jpeg, .png"></div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Additional Picture</label></div>
                <div class="col-lg-4 col-sm-6"><input type="file" name="imgAdditional" id="" placeholder="Surburb"class="form-control border-secondary" accept=".jpg, .jpeg, .png"></div> 
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-8"><input type="checkbox" class="form-check-input border-secondary mx-1" name="isFeatured" id="Feature"><label for="Feature">Feature this property</label></div>
                <div class="col-lg-3 col-sm-12"><a href=""><button class="btn btn-primary col-12" type="submit" name="propertysubmit">Submit</button></a></div>
            </div>

            <input id="lat" name="latitude" class="d-none">
            <input id="lng" name="longitude" class="d-none">
            
        </form>
    </div>
</div>

<?php include "include/footer.php"?>

<script>
const searchInput = document.getElementById('txtStreetName');
const suggestionsList = document.getElementById('suggestions');
let addedStreetNames = [];
let map; // Declaring map outside any function
var marker;
var clickedLat;
var clickedLng;

searchInput.addEventListener('input', () => {
  const searchTerm = searchInput.value;
  if (searchTerm.trim() !== '') {
    getSuggestions(searchTerm);
  } else {
    clearSuggestions();
  }
});

function getSuggestions(query) {
  const apiUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json`;

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      displayStreetNameSuggestions(data, query);
    })
    .catch(error => console.error('Error:', error));
}

function displayStreetNameSuggestions(suggestions, query) {
  clearSuggestions();

  suggestions.forEach(result => {
    let streetName = result.address?.road || result.address?.pedestrian || result.name || 'Unknown Street';

    if (!addedStreetNames.includes(streetName)) {
      addedStreetNames.push(streetName);

      const suggestionItem = document.createElement('li');
      suggestionItem.className = 'suggestion';
      
      // Highlight matching text in bold
      const index = streetName.toLowerCase().indexOf(query.toLowerCase());
      const boldedStreetName = index !== -1 ? streetName.substr(0, index) + "<strong class='bg-secondary rounded'>" + streetName.substr(index, query.length) + "</strong>" + streetName.substr(index + query.length) : streetName;

      suggestionItem.innerHTML = boldedStreetName;

      suggestionItem.addEventListener('click', () => {
        searchInput.value = streetName;
        clearSuggestions();
        
        // Fetch and log coordinates when a street name is clicked
        const apiUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(streetName)}&format=json`;

fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            const firstResult = data[0];
            const lt = parseFloat(firstResult.lat);
            const ln = parseFloat(firstResult.lon);

            console.log('Street Coordinates:', lt, ln);
            console.log('Found address:', firstResult.display_name);

            // Check if map is not initialized yet
            if (!map) {  
                map = L.map('map').setView([lt, ln], 20);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                let marker;

                // Event listener for when the user clicks on the map
                map.on('click', function(e) {
                    // If there's already a marker, remove it
                    if(marker) {
                        map.removeLayer(marker);
                    }
                    // Add a marker at the clicked location
                    marker = L.marker(e.latlng).addTo(map);

                    // Retrieve the coordinates of the clicked location
                    clickedLat = e.latlng.lat;
                    clickedLng = e.latlng.lng;
                                        // Set clicked coordinates to the input fields
                    document.getElementById("lat").value = e.latlng.lat.toString();
                    document.getElementById("lng").value = e.latlng.lng.toString();

                    console.log('Clicked Coordinates:', clickedLat, clickedLng);
                    console.log(typeof document.getElementById("lng").value);
                    console.log(document.getElementById("lng").value);
                });
            } else {
                map.setView([lt, ln], 20);
            }
        } else {
            console.log('Coordinates not found for', streetName);
        }
    })
    .catch(error => console.error('Error:', error));

        });
        suggestionsList.appendChild(suggestionItem);
        }

  });

  // Show the suggestions container
  suggestionsList.style.display = 'block';
}

function clearSuggestions() {
  // Hide and clear the suggestions container
  suggestionsList.style.display = 'none';
  suggestionsList.innerHTML = '';
  addedStreetNames = [];
}

document.addEventListener("DOMContentLoaded", function() {
  // List of items
  var items = ['Elangeni TVET College - Kwamashu Campus', 'Elangeni TVET College - Ntuzuma Campus', 'Orange', 'Pineapple', 'Mango', 'Grapes'];

  var input = document.getElementById('txtNearestCampus');
  var autocompleteList = document.getElementById('campusList');

  input.addEventListener('input', function() {
    var value = this.value;
    autocompleteList.innerHTML = '';

    if (!value) {
      return;
    }

    items.forEach(function(item) {
      if (item.toLowerCase().includes(value.toLowerCase())) {
        var itemElement = document.createElement('div');
        itemElement.textContent = item;
        itemElement.classList.add('autocomplete-item');
        itemElement.addEventListener('click', function() {
          input.value = item;
          autocompleteList.innerHTML = '';
        });
        autocompleteList.appendChild(itemElement);
      }
    });
  });

  document.addEventListener('click', function(event) {
    if (!autocompleteList.contains(event.target)) {
      autocompleteList.innerHTML = '';
    }
  });
});

   </script>
   <script src="resources/js/lengthvalidate.js"></script>
   <script src="resources/js/autocomplete.js"></script>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
   </html>