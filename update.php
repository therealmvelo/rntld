<?php
session_start();
error_reporting(0);
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

// Check if the user is logged in and is not a student
if (isset($_SESSION['userID']) && isset($_SESSION['userName']) && isset($_SESSION['userType']))  {
    $userID = $_SESSION['userID'];
    $Username = $_SESSION['userName'];
    $UserType = $_SESSION['userType'];
} else {
    $UserType = null;
}

if ($UserType == "Student") {
    header("Location: notallowed.php");
    exit();
} elseif ($UserType == null) {
    header("Location: login.php");
    exit();
}

include 'logic/update.php';
?>


<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <title>Update Your Property</title>

       <style>
        img{
            height:90px;
            width:100px;
        }
       </style>
   </head>
   <body>
   <a class="navbar-brand m-4" href="index.php" aria-label="logo text">
      <svg width="200" height="60" xmlns="http://www.w3.org/2000/svg">
        <text x="0" y="40" font-family="MV Boli" font-size="40" fill="green">RentLad.</text>
      </svg>
    </a>
    <hr>
   <div class="container">
    <div class="row mx-1">
        <?php echo $feedback;?>
    <form method="post" enctype="multipart/form-data">
        <!--h1 class="text-center">List your property</h1-->
        <h1 class="text-center my-5">Update Your Property</h1>
            <h5 class="text-secondary">Basic information</h5>
            <div class="row mt-3">
                <?php# if(isset($msg)){echo $msg;} ?>
                <div class="col-lg-2 col-sm-12"><label class="form-label">Title</label></div>
                <div class="col-lg-9 col-sm-12"><input type="text" name="txtTitle" value="<?php echo $propertyTitle;?>" placeholder="enter title"class="form-control border-secondary" required></div>   
            </div>
            
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-12"><label class="form-label">Description</label></div>
                <div class="col-lg-9 col-sm-12"> <textarea class="form-control border-secondary" name="txtDescription" placeholder="Describe your property" value="<?php echo $PropertyDescription;?>" required></textarea></div>   
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-12"><label class="form-label">Rules</label></div>
                <div class="col-lg-9 col-sm-12"> <textarea class="form-control border-secondary" name="txtRules" placeholder="Write your property rules here" value="<?php echo $PropertyRules;?>" required></textarea></div>   
            </div>
            <h5 class="text-secondary mt-4">Price & location</h5>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Number of rooms</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtNumberofRooms" value="<?php echo $NumberOfRooms;?>" placeholder=""class="form-control border-secondary"required></div>
                <div class="col-lg-1 col-sm-6"><label class="form-label">Price</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtPrice" value="<?php echo $Price;?>" placeholder="price of each room"class="form-control border-secondary"required></div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">City</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtCity" value="<?php echo $CityName;?>" placeholder="City"class="form-control border-secondary"required></div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Surburb</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtSuburb" value="<?php echo $Suburb;?>" placeholder="Surburb"class="form-control border-secondary"required></div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label for="txtStreetName" class="form-label" id="lblStreetName">Street</label></div>
                <div class="col-lg-4 col-sm-6"><input type="text" name="txtStreet" value="<?php echo $Street;?>" placeholder="Street name"class="form-control border-secondary" required></div>
                    <!--div class="form-container col-lg-2">
                        <ul id="suggestions" class="container text-primary"></ul>
                    </div-->
                <div class="col-lg-2 col-sm-6"><label class="form-label">House Number</label></div>
                <div class="col-lg-3 col-sm-6"><input type="text" name="txtHouseNumber" value="<?php echo $HouseNumber;?>" placeholder=""class="form-control border-secondary"required></div>
                
                 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Nearest campus or university</label></div>
                <div class="col-lg-9 col-sm-6"><input type="text" name="txtCampus" value="<?php echo $NearestCampus;?>" placeholder="enter campus or university"class="form-control border-secondary"required></div> 
            </div>
            <div class="row mt-4">
                 <div class="col-lg-2 col-sm-12"><p>Provided Facilities</p></div>
                 <div class="col">
                    <input type="checkbox"class="form-check-input border-secondary" name="chkWifi" id="chkWifi">
                    <label for="chkWifi">WiFi</label>
                </div>
                <div class="col">
                    <input type="checkbox"class="form-check-input border-secondary" name="chkBed" id="chkBed">
                    <label for="checkus">Bed</label>
                </div>
                <div class="col">
                    <input type="checkbox"class="form-check-input border-secondary" name="chkTV" id="chkTV">
                    <label for="heckme">TV</label>
                </div>
                <div class="col">
                    <input type="checkbox"class="form-check-input border-secondary" name="chkFurniture" id="chkFurniture">
                    <label for="chkFurniture">Food</label>
                </div>
            </div>
            <h5 class="text-secondary mt-4">Property Images</h5>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Front View</label></div>
                <div class="col-lg-4 col-sm-6">
                    <input type="file" name="imgFrontView" value="" class="form-control border-secondary"required>
                    <img src="admin/property/images/<?php echo $imgFrontView;?>" alt="front view image">
                </div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Side View</label></div>
                <div class="col-lg-4 col-sm-6">
                    <input type="file" name="imgSideView" class="form-control border-secondary"required>
                    <img src="admin/property/images/<?php echo $imgSideView;?>" alt="side view image">
                </div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Inside (1)</label></div>
                <div class="col-lg-4 col-sm-6">
                    <input type="file" name="imgInside1" class="form-control border-secondary"required>
                    <img src="admin/property/images/<?php echo $imgInside1;?>" alt="inside view image">
                </div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Inside (2)</label></div>
                <div class="col-lg-4 col-sm-6">
                    <input type="file" name="imgInside2" class="form-control border-secondary"required>
                    <img src="admin/property/images/<?php echo $imgInside2;?>" alt="inside view image">
                </div> 
            </div>
            <div class="row mt-4">
                <div class="col-lg-2 col-sm-6"><label class="form-label">Property Fence</label></div>
                <div class="col-lg-4 col-sm-6">
                    <input type="file" name="imgFence" class="form-control border-secondary">
                    <img src="admin/property/images/<?php echo $imgFence;?>" alt="property fence image">
                </div> 
                <div class="col-lg-1 col-sm-6"><label class="form-label">Additional Picture</label></div>
                <div class="col-lg-4 col-sm-6">
                    <input type="file" name="imgAdditional" placeholder="Surburb"class="form-control border-secondary">
                    <img src="admin/property/images/<?php echo $imgAdditional;?>" alt="additional image">
                </div> 
            </div>
            <div class="row mt-4">
                <!--div class="col-lg-8"><input type="checkbox" class="form-check-input border-secondary mx-1" name="isFeatured" id="Feature"><label for="Feature">Feature this property</label></div-->
                <div class="col-lg-3 col-sm-12"><button class="btn btn-primary col-12" value="submit" type="submit" name="propertyupdate">Submit</button></div>
            </div>
        </form>
    </div>
</div>

<?php# include "include/footer.php"?>
   </body>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>