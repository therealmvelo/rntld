<?php
include 'include/config.php';
$db = new DbConnect;
$conn = $db->connect();
include "logic/student.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="global/links.css">
    <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
    <title>Welcome, <?php echo htmlspecialchars($stdName); ?>!</title>
</head>
<body>
    <?php include("include/header.php");?>

      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-3 col-md-2 col-lg-2 mb-2">
                <div class="nav flex-row flex-sm-column mt-1" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                    <li class="nav-link active" id="v-pills-properties-tab" data-bs-toggle="pill" data-bs-target="#v-pills-properties" type="button" role="tab" aria-controls="v-pills-properties" aria-selected="true">Booked Properties</li>
                    <li class="nav-link" id="v-pills-request-tab" data-bs-toggle="pill" data-bs-target="#v-pills-request" type="button" role="tab" aria-controls="v-pills-request" aria-selected="false">Pending Requests</li>
                    <hr>
                    <a href="s.profile.php?StudentID=<?php echo $studentID; ?>" class="text-decoration-none"><li class="nav-link">Account</li></a>
                </div>
            </div>

            <div class="col">                      
              <div class="container mt-5">
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="v-pills-properties" role="tabpanel" aria-labelledby="v-pills-properties-tab" tabindex="0">
                      <?php if ($bookedPropertiesResult->num_rows > 0) {
                         while ($property = $bookedPropertiesResult->fetch_assoc()) {?>   
                          <!--booked property container-->                                                              

                            <div class="card mb-3 mt-5 col-lg-11 col-sm-12">
                              <div class="card-header bg-secondary text-white">
                                <div class="row">
                                  <div class="col-11">
                                    <h5><?php echo $property['PropertyTitle'];?></h5>
                                  </div>
                                  <div class="col">
                                    <a class="p-1 bg-white rounded border border-danger text-decoration-none" href="#price">R <?php echo $property['Price'];?></a>
                                  </div>
                                </div>
                              </div>
                              <div class="row g-0">
                                <div class="col-lg-3 col-sm-4 col-md-8">
                                  <img src="admin/property/images/<?php echo $property['imgFrontView'];?>" class="img-fluid" alt="..." style="object-fit:cover; height:190px;width:100%;">
                                </div>
                                      <!--div--1!-->
                                <div class="col-lg-9 col-md-4 col-sm-8">
                                  <div class="card-body">
                                    <div class="row">
                                          <!-- landlord details -->
                                      <div class="col-lg-8 col-sm-12">
                                        <h5 class="card-title"><u>Landlord Details</u></h5>
                                        <ul class="list-group">
                                          <p><img src="resources/icons/telephone.png" height="15" width="15" alt=""><?php echo " ".$property['lndPhone'];?></p>
                                          <p><img src="resources/icons/mail.png" height="15" width="15" alt=""><?php echo " ".$property['lndEmail'];?></p>
                                        </ul>
                                      </div>
                                      <div class="col-lg-4 col-sm-12">
                                        <div class="row">
                                          <div class="col-12 text-end">
                                            <span class="badge d-flex align-items-center p-0 pe-2 rounded-pill flex-row-reverse">
                                              <img class="rounded-circle me-1" width="24" height="24" src="admin/users/images/<?php echo $property['lndProfileImage'];?>" alt="">
                                              <p class="m-1 text-dark"><?php echo $property['lndName'];?></p>
                                              <span class="vr mx-2"></span>
                                              <a href="#"><svg class="bi" width="16" height="16"><use xlink:href="#x-circle-fill"/></svg></a>
                                            </span>
                                            <div class="col-12">
                                              <?php if ($property["isVerified"] === "yes") { ?>
                                                verified <img src="resources/icons/verify.png" height="15" width="15" alt="verify"> <?php }else{?> <small class="text-danger">landlord not verified </small> <img src="resources/icons/close.png" height="15" width="15" alt="not verify"> <?php } ?>
                                            </div>
                                            <!--div class="col-12">
                                              <h5 class="card-text fw-medium "> R <?php echo $property['Price'];?> p/m</h5>
                                            </div-->
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row border col-sm-12 col-lg-4 ms-auto">
                                              <!-- Move the button outside the inner row and use 'ms-auto' to push it to the right -->
                                      <a class="btn btn-primary" type="button"  href="booking.php?PropertyID=<?php ecHo $property['PropertyID'];?>">Check Availability <img src="resources/icons/greater-than.png" height="25" width="25" alt=""></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="card-footer">
                                <div class="row">
                                  <!--div class="col-lg-6 bg-body-tertiary ">
                                      <div class="list-unstyled d-flex gap-3 col-6 text-secondary"><?php echo $amenities; ?></div>
                                  </div-->
                                </div>
                              </div>
                            </div>

                        <?php }} else {?> 
                        <div class="container">
                          <div class="notfound-container mt-5 text-center ">
                            <img src="resources/icons/dangerous.png" height="80" width="80" alt="">
                            <h4>No Booked Properties Found !</h4>
                              <div class="inform">
                                <small>simply book a property and it will be shown here once the landlord accept you</small>
                              </div>
                          </div>
                                <?php }?>                   
                        </div>

                                                  
                          <!--displayed if the student hasnt booked any properties or not accepted -->
                      <div class="tab-pane fade show" id="v-pills-request" role="tabpanel" aria-labelledby="v-pills-request-tab" tabindex="0">
                        <div class="container"> <?php if ($PendingPropertiesResult->num_rows > 0) { while ($property = $PendingPropertiesResult->fetch_assoc()) {?>
                          <div class="container mt-5">
                          <div class="card mb-3 mt-5 col-lg-11 col-sm-12">
                            <div class="card-header bg-secondary text-white">
                              <div class="row">
                                <div class="col-11">
                                  <h5><?php echo $property['PropertyTitle'];?></h5>
                                </div>
                                <div class="col">
                                  <a class="p-1 bg-white rounded border border-danger text-decoration-none" href="#price">R <?php echo $property['Price'];?></a>
                                </div>
                              </div>
                            </div>
                            <div class="row g-0">
                              <div class="col-lg-3 col-sm-4 col-md-8">
                                <img src="admin/property/images/<?php echo $property['imgFrontView'];?>" class="img-fluid" alt="..." style="object-fit:cover; height:190px;width:100%;">
                              </div>
                                    <!--div--1!-->
                              <div class="col-lg-9 col-md-4 col-sm-8">
                                <div class="card-body">
                                  <div class="row">
                                        <!-- landlord details -->
                                    <div class="col-lg-8 col-sm-12">
                                      <h5 class="card-title"><u>Landlord Details</u></h5>
                                      <ul class="list-group">
                                        <p><img src="resources/icons/telephone.png" height="15" width="15" alt=""><?php echo " ".$property['lndPhone'];?></p>
                                        <p><img src="resources/icons/mail.png" height="15" width="15" alt=""><?php echo " ".$property['lndEmail'];?></p>
                                      </ul>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                      <div class="row">
                                        <div class="col-12 text-end">
                                          <span class="badge d-flex align-items-center p-0 pe-2 rounded-pill flex-row-reverse">
                                            <img class="rounded-circle me-1" width="24" height="24" src="admin/users/images/<?php echo $property['lndProfileImage'];?>" alt="">
                                            <p class="m-1 text-dark"><?php echo $property['lndName'];?></p>
                                            <span class="vr mx-2"></span>
                                            <a href="#"><svg class="bi" width="16" height="16"><use xlink:href="#x-circle-fill"/></svg></a>
                                          </span>
                                          <div class="col-12">
                                            <?php if ($property["isVerified"] === "yes") { ?>
                                              verified <img src="resources/icons/verify.png" height="15" width="15" alt="verify"> <?php }else{?> <small class="text-danger">landlord not verified </small> <img src="resources/icons/close.png" height="15" width="15" alt="not verify"> <?php } ?>
                                          </div>
                                          <!--div class="col-12">
                                            <h5 class="card-text fw-medium "> R <?php echo $property['Price'];?> p/m</h5>
                                          </div-->
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row border col-sm-12 col-lg-4 ms-auto">
                                            <!-- Move the button outside the inner row and use 'ms-auto' to push it to the right -->
                                    <a class="btn btn-danger" type="button"  href="booking.php?PropertyID=<?php ecHo $property['PropertyID'];?>">Cancel<img src="resources/icons/greater-than.png" height="25" width="25" alt=""></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card-footer">
                              <div class="row">
                                <div class="col-lg-6 bg-body-tertiary ">
                                    <div class="list-unstyled d-flex gap-3 col-6 text-secondary"><?php echo $amenities; ?></div>
                                </div>
                              </div>
                            </div>
                          </div>
                                    <?php }} else {?>
                                      <div class="container">
                            <div class="notfound-container mt-5 text-center ">
                              <img src="resources/icons/file.png" height="80" width="80" alt="">
                              <h4>No Pending Requests Found !</h4>
                                <div class="inform">
                                  <small>once you request to book a property it will be shown here <br><b>explore properties and make a booking</b></small>
                                </div>
                            </div>
                          </div>
                                      <?php }?> 
                            </div>
                          </div>
                        </div>
                      </div>
                    
                      <!--tabcontent end-->
                    </div>
                
            </div>
          </div>
          
       </div>
       
</body>
<script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>
