<?php
session_start();
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();

$LandlordID = $_GET["LandlordID"];
$LandlordSQL = "SELECT
        l.lndEmail AS Email,
        l.lndPhone AS PhoneNumber,
        l.lndName AS Name,
        l.lndProfileImage AS ProfileImage,
        l.lndSurname AS Surname,
        l.isVerified AS isVerified,
        l.lndProfileImage AS ProfileImage,
        COUNT(p.PropertyID) AS NumberOfPropertiesOwned,
        COALESCE(SUM(b.Status = 'accept'), 0) AS NumberOfStudentsBooked
        FROM
        landlord l
        LEFT JOIN property p ON l.LandlordID = p.FK_LandlordID
        LEFT JOIN booking_request b ON p.PropertyID = b.FK_PropertyID
        WHERE
        l.LandlordID = ?
        GROUP BY
        l.LandlordID;
";
$LandlordStmt = $conn->prepare($LandlordSQL);

if (!$LandlordStmt) {
    die('Error: ' . $conn->error); // Print the error message
}

$LandlordStmt->bind_param("i", $LandlordID);
$LandlordStmt->execute();
$LandlordStmtResults = $LandlordStmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <title>profile</title>
       <style>
        .card-img-top {
            width: 100%;
            top: 50%;
            left: 50%;
            object-fit: cover;
        }
       </style>
   </head>
   <body>
       <?php include 'include/header.php'; 
        if ($LandlordStmtResults->num_rows > 0 ){?>
    <div class="col-12">
          <!--Card-->
          <div class="card overflow-hidden border border-dark" style="height:440px">
            <img src="admin/city/images/city.jpeg" height="150" class="card-img-top" alt="...">
    <?php while ($row = $LandlordStmtResults->fetch_assoc()){?>
            <!--Card body-->
            <div class="card-body" style="transform:translatey(-90px);">
              <!--avatar-->
              <a href="#!.html" class="" >
                <img src="admin/users/images/<?php echo $row['ProfileImage']; ?>" class="mb-3"  width="160" height="150" alt="" style="border-radius:70px">
              </a>
              
              <h5 class="">
                <a class="text-decoration-none"><?php echo htmlspecialchars($row["Name"] ." " . $row["Surname"]); ?></a> <?php if ($row["isVerified"] === "yes") { ?>
                    <img src="resources/icons/verify.png" height="25" width="25" alt="verify"> <?php }else{?> <img src="resources/icons/close.png" height="15" width="15" alt="not verify"> <?php } ?>
              </h5>
            
          <hr class="m-0">
          <div class="">
            <ul class="list-group list-group-horizontal">
                <li class="nav-link text-secondary"><img src="resources/icons/town.png" height="30" width="30" class="" alt="..."> <?php echo $row["NumberOfPropertiesOwned"];?> properties</li>
                <li class="nav-link text-secondary"><img src="resources/icons/graduated.png" height="30" width="30" class="" alt="..."> <?php echo $row["NumberOfStudentsBooked"]; ?> students</li>
            </ul>
             <div class="text-end">
            
          </div>
          <div class="mt-4">
             <ul class="list-group list-group-horizontal">
                <li class="nav-link text-secondary"><img src="resources/icons/telephone.png" height="30" width="30" class="" alt="..."> <?php echo $row["PhoneNumber"]; ?></li>
                <li class="nav-link text-secondary"><img src="resources/icons/mail.png" height="30" width="30" class="" alt="..."> <?php echo $row["Email"]; ?></li>
            </ul>
          </div>
           
           
          </div>
          
        </div> 
         <?php } }?>   
          
</div><small class="text-center  bg-secondary-subtle ">this is what other users will see when they visit your profile</small>
  </div>

 
 
   </body>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>