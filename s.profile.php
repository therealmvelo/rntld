<?php
include 'logic/s.profile.php';
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
          if ($StudentProfileResults->num_rows > 0 ){?>
       

    <div class="col-12">
          <!--Card-->
          <div class="card overflow-hidden border border-dark" style="height:360px;overflow:auto;" id="cover">
            <img src="admin/city/images/city.jpeg" height="150" class="card-img-top" alt="...">
              <?php while ($row = $StudentProfileResults->fetch_assoc()) { ?>  
            <!--Card body-->
            <div class="card-body p-1" style="transform:translatey(-80px);">
              <!--avatar-->
              <a href="#!.html" class="mx-3">
                <img src="admin/users/images/<?php echo $row["ProfileImage"]; ?>"  class="mb-3"  width="160" height="150" alt="" style="border-radius:70px">
              </a>
              
              <h5 class="mx-3">
                <a class="text-decoration-none"><?php echo $row["Name"] . " " . $row["Surname"];?></a> <img src="resources/icons/verify.png" height="25" width="25" alt="verify">
              </h5>
            
          <hr class="m-0">
          
          <div class="mt-0">
             <ul class="list-group list-group-horizontal">
                <li class="nav-link text-secondary"><img src="resources/icons/telephone.png" height="30" width="30" class="" alt="..."> <?php echo $row["PhoneNumber"]; ?></li>
                <li class="nav-link text-secondary"><img src="resources/icons/mail.png" height="30" width="30" class="" alt="..."> <?php echo $row["Email"]; ?></li>
            </ul>
          </div>
           
           
          </div>
          
        </div> 
           <?php }}?> 
          
      </div>
  </div>

  
  <div class="container justify-content-center align-items-center col-12 d-flex ">
    <h3 class="text-secondary rounded p-1">suggested properties</h3>
  </div>
  <div class="container">
    <?php if($SuggestedPropertiesResults->num_rows > 0 ){?>
            <?php while($row = $SuggestedPropertiesResults->fetch_assoc()) { ?>
    <div class="card mb-3 mt-5 col-lg-11 col-sm-12 alert">
               <div class="card-header bg-secondary text-white">
                   <div class="row">
                       <div class="col-11">
                           <h5><?php echo $row['PropertyTitle']; ?></h5>
                       </div>
                       <div class="col-1 text-end">
                       <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                   </div>
               </div>
   
               <div class="row">
                   <div class="col-lg-3 col-sm-4 col-md-8">
                       <img src="admin/property/images/<?php echo $row['imgFrontView']; ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height:100%;width:100%;">
                   </div>
   
                   <div class="col-lg-9 col-md-4 col-sm-8">
                       <div class="card-body">
                           <div class="row">
                               <div class="col-lg-8 col-sm-12">
                                   <h5 class="card-title">Description</h5>
                                   <p><?php echo $row['PropertyDescription']; ?></p>
                               </div>
                               <div class="col-lg-12 col-sm-12 col-md-12 ">
                                   <div class="row">
                                       <div class="col-12 text-end">
                                           <span class="badge d-flex align-items-center p-0 pe-2 rounded-pill flex-row-reverse">
                                               <img class="rounded-circle me-1" width="24" height="24" src="admin/users/images/<?php echo $row['lndProfileImage']; ?>" alt="">
                                               <p class="m-1 text-dark"><?php echo $row['lndName'] . " " . $row['LandlordSurname']; ?></p>
                                               <span class="vr mx-2"></span>
                                               <a href="#"><svg class="bi" width="16" height="16"><use xlink:href="#x-circle-fill" /></svg></a>
                                           </span>
                                       </div>
                                       <div class="col-12 text-end">
                                        <?php if ($row["isVerified"] === "yes") { ?>
                                            verified <img src="resources/icons/verify.png" height="15" width="15" alt="verify"> <?php }else{?> <small class="text-danger">landlord not verified </small> <img src="resources/icons/close.png" height="15" width="15" alt="not verify"> <?php } ?>
                                       </div>
                                       <div class="col-12 text-end ">
                                           <h5 class="card-text fw-medium "> R <?php echo $row['Price']; ?> p/m</h5>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row border col-sm-12 col-lg-4 ms-auto mx-1">
                           <a class="btn btn-primary" type="button" href="booking.php?PropertyID=<?php echo $row['PropertyID']; ?>">Check Availability <img src="resources/icons/greater-than.png" height="25" width="25" alt=""></a>
                       </div>
                   </div>
               </div>
           </div> 
<?php }} ?>
  </div>
            </div>
 
 
   </body>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>