<?php 
include 'logic/landlord.php';
?>

<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="icon" type="image/x-icon" href="resources/icons/rentld.png" >
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <link rel="stylesheet" href="global/links.css">
       <title><?php echo strtoupper($userName); ?> | Dashboard</title>
   </head>
   <body class="d-inline+">
       <?php include 'include/header.php';?>
       
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-1 mb-2">
                <div class="nav flex-row flex-sm-column" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                    <li class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Properties</li>
                    <li class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Tenants</li>
                    <li class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Analytics</li>
                    <li class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-request" type="button" role="tab" aria-controls="v-pills-request" aria-selected="false">Requests</li>
                    <li class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Support</li>
                    <hr>
                    <a href="l.profile.php?LandlordID=<?php echo $landlordID; ?>" class="text-decoration-none"><li class="nav-link">Account</li></a>
                </div>
        </div>
        <div class="col">
            <div class="tab-content" id="v-pills-tabContent">
            <?php 
                   if(isset($msgReject)){echo $msgReject;}
                   if(isset($bookingRequest)){echo $bookingRequest;}
            ?>           
                <!-- Properties Tab -->
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="container">
                        <!--div class="h4 mb-5">Manage Your Property</div-->
                        <div class="table-container" style="overflow:auto;">
                        <?php 
                            if ($fetchPropertiesResult->num_rows > 0) {?>
      
                                <table class="table table-bordered border-secondary">
                                    <thead>
                                        <tr class="bg-secondary" >
                                            <th>id</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th class="text-center">Date Posted</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php while ($propertyRow = $fetchPropertiesResult->fetch_assoc()) {?>
                                        <tr>
                                            <td class="text-start text-dark"><?php echo $propertyRow['PropertyID'];?></td>
                                            <td><img src="admin/property/images/<?php echo $propertyRow['imgFrontView']; ?>" alt="" style="max-width: 100px;"></td>
                                            <td class="text-center">R <?php echo $propertyRow['Price'];  ?></td>
                                            <td class="text-center"><?php echo $propertyRow['datePosted']; ?></td>
                                            <td class="text-end">
                                                <div class="dropdown ">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Update</button>
                                                        <!--a href="update.php?PropertyID=<?php# echo $propertyRow['PropertyID']; ?>" style="text-decoration: none; color: white;">Update</a-->
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#PropertyTitleUpdateModal<?php echo $propertyRow['PropertyID']; ?>" href="#">Property Title</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#PropertyDescriptionUpdate" href="#">Property Description</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#PropertyRulesUpdate" href="#">Property Rules</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#NumberOfRoomsUpdate" href="#">Number of Rooms</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#PriceUpdate" href="#">Price</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#CityUpdate" href="#">City</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#SuburbUpdate" href="#">Suburb</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#StreetUpdate" href="#">Street</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#HouseNumberUpdate" href="#">House Number</a></li>
                                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#NearestCampusUpdate" href="#">Nearest Campus</a></li>
                                                    </ul>
                                                </div>

                                                <button class="btn btn-danger"data-bs-toggle="modal" data-bs-target="#PropertyDeletion">Delete</button>
                                                <!--deletion confirmation modal-->
                                                <div class="modal fade border border-2 border-danger" id="PropertyDeletion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure you want to delete this property</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">

                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form method="post">
                                                          <input type="hidden" name="PropertyID" value="<?php echo $propertyRow['PropertyID']; ?>">
                                                            <button class="btn btn-danger" name="PropertyDelete"type="submit">Delete</button>
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <!--property title update-->
                                                <div class="modal fade titlemodal" id="PropertyTitleUpdateModal<?php echo $propertyRow['PropertyID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Property Title Update</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <div class="update-result">
                                                          <div class="row mt-3">
                                                            <div class="col-12">
                                                              <input type="text" name="txtTitle" id="txtTitle" placeholder="Enter title" class="form-control border-secondary" required>
                                                            </div>   
                                                          </div>     
                                                        </div>
                                                        <input type="hidden" id="PropertyID" name="propertyID" value="<?php echo $propertyRow['PropertyID']; ?>">                                                       
                                                      </div>
                                                      <div class="modal-footer"  id="modalFooter">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-primary PropertyTitleUpdateBtn" id="PropertyTitleUpdate" data-property-id="<?php echo $propertyRow['PropertyID']; ?>">Submit</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                  </div>
                                                </div>
                                          </td>
                                        </tr>
                                <?php } ?>
                                    </tbody>
                                </table>                                  
                                <?php } else {?> 
                                  
                                  <div class="container">
                                    <div class="notfound-container mt-5 text-center ">
                                      <img src="resources/icons/file.png" height="80" width="80" alt="">
                                      <h4>No Properties Found !</h4>
                                      <div class="inform">
                                        <small>once you list your property it will be shown here <br><b>explore properties and see how other landlords are doing it</b></small>
                                      </div>
                                    </div>
                                  </div>
                                  
                                    <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- tenants... -->
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">       
                <div class="container">
                        <!--div class="h4 mb-5">Your Tenants</div-->
                            <div class="container-fluid" style="overflow:auto;">
                             <?php 
                        // Display tenants
                        if ($fetchTenantsResult->num_rows > 0) {
                            while ($tenantRow = $fetchTenantsResult->fetch_assoc()) {
                                $RequestID = $tenantRow['RequestID'];
                                $stdName = $tenantRow['stdName'] . ' ' . $tenantRow['stdSurname'];
                                $stdEmail = $tenantRow['stdEmail'];
                                $stdProfileImage = $tenantRow['stdProfileImage'];
                                $propertyID = $tenantRow['FK_PropertyID'];
                                ?>    
                                <table class="table table-bordered mt-3 border border-5 border-warning">
                                <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    
                                    <tbody class="table-group-divider border border-dark">
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <img src="admin/users/images/<?php echo $stdProfileImage; ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                                    <div class="ms-3">
                                                        <p class="fw-bold mb-1"><?php echo $stdName; ?></p>
                                                        <p class="text-muted mb-0"><?php echo $stdEmail; ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                            <form method="post" action="">
                                                <input type="hidden" name="tenant" value="removeTenant">
                                                <input type="hidden" name="RequestID" value="<?php echo $RequestID; ?>">
                                                <input type="hidden" name="propertyID" value="<?php echo $propertyID; ?>">
                                                <button type="submit " class="btn btn-danger">Remove Tenant</button>
                                            </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php }} else {?>
                                    <div class="container">
                          <div class="notfound-container mt-5 text-center ">
                            <img src="resources/icons/file.png" height="80" width="80" alt="">
                            <h4>No Tenants Found !</h4>
                              <div class="inform">
                                <small>once you accept tenants they will be shown here <br><b>simply list your property for tenants to find it</b></small>
                              </div>
                          </div>
                     </div>                
                    <?php } ?>
                </div>
            </div>
        </div>
<!-- property perfomance... -->
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">
            <div class="container">
                <div class="h4 mb-5">Overall Property Performance</div>
                    <div class="performance-container" style="overflow:auto;">
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', { 'packages': ['corechart', 'bar'] });
                            google.charts.setOnLoadCallback(drawVisualization);
                                function drawVisualization() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['', 'Price', 'Suggested Price'],
                                            <?php
                                                for ($i = 0; $i < count($propertyData); $i++) {
                                                    echo "['', " . $averagePriceData[$i][1] . ", " . $suggestedPriceData[$i][1] . "],\n";
                                                }
                                            ?>
                                        ]);
                                        var options = {
                                            title: 'Average Price  -  Suggested Price',
                                            vAxis: { title: 'Price' },
                                            hAxis: { title: 'hr' }, // No title for the horizontal axis
                                            seriesType: 'bars',
                                            isStacked: false, // Display bars in a grouped manner
                                            colors: ['#3366CC', '#DC3912'], // Customize colors
                                            legend: { position: 'top', alignment: 'center' }, // Add legend
                                            tooltip: { isHtml: true, textStyle: { fontSize: 14 } }, // Format tooltip
                                            chartArea: { left: 60, top: 50, right: 20, bottom: 80 }, // Adjust chart area
                                            width: '100%',
                                            height: 400,
                                        };
                                        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                                        chart.draw(data, options);
                                    }
                                </script>
                                <div id="chart_div" style="width: 100%; height: 500px;"></div>
                            </div>
                        </div>                                  
                    </div>
                <!--request tab-->    
                    <div class="tab-pane fade" id="v-pills-request" role="tabpanel" aria-labelledby="v-pills-request-tab" tabindex="0">
                        <div class="container">
                            <div class="container-fluid" style="overflow:auto;">
                                <?php if ($fetchRequestsResult->num_rows > 0) {?>                              
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Names</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php while ($row = $fetchRequestsResult->fetch_assoc()) {
                                                $requestID = $row['RequestID'];
                                                $studentID = $row['FK_StudentID'];
                                                $propertyID = $row['FK_PropertyID'];
                                                $studentName = $row['stdName'];
                                                $studentSurname = $row['stdSurname'];
                                                $studentEmail = $row['stdEmail'];
                                                $studentProfileImage = $row['stdProfileImage'];
                                        ?>
                                        <tr>
                                        <td>
                                            <div class="d-flex">
                                                <img src="admin/users/images/<?php echo $studentProfileImage; ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                                <div class="ms-3">
                                                    <p class="fw-bold mb-1"><?php echo $studentName; ?></p>
                                                    <p class="text-muted mb-0"><?php echo $studentEmail; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                    <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="action" value="accept">
                                        <input type="hidden" name="requestID" value="<?php echo $requestID; ?>">
                                        <button class="btn btn-success rounded" type="submit">Accept</button>
                                    </form>

                                    <form method="post" action="">
                                        <input type="hidden" name="action" value="reject">
                                        <input type="hidden" name="requestID" value="<?php echo $requestID; ?>">
                                        <button class="btn btn-danger rounded" type="submit">Reject</button>
                                    </form>
                                        </td>
                                    </tr> 
                            <?php } ?>
                                </tbody>
                            </table>
                        <?php }else{?> <div class="container">
                                                    <div class="notfound-container mt-5 text-center ">
                                                        <img src="resources/icons/file.png" height="80" width="80" alt="">
                                                        <h4>No Request Found !</h4>
                                                        <div class="inform">
                                                            <small>once you list your property students will be able to send booking requests <br><b>simply list your property</b></small>
                                                        </div>
                                                    </div>
                                                </div>                           
                        <?php } ?>

                            </div>
                        </div>
                    </div>
                <!-------- SUPPORT... -->
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">
                    <div class="container">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-center mb-5 mt-5 col-12">How Can We Help</h3>
                                       <p><b>What other landlords ask : </b></p> 
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <!---------->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    <div class="">
                                                    is listing a property free at Rentlad ?
                                                    </div>
                                                </button>
                                                </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            yes, listing a property is completely free at rentlad
                                                        </div>
                                                    </div>
                                            </div>
                                                <!--div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        Accordion Item #2
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        Accordion Item #3
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                                                    </div>
                                                </div>
                                                </div-->
                                            </div>
                                            <div class="mt-4 col-lg-5 col-sm-12 col-md-12">
                                                <fieldset>
                                                    <legend><h5>Email Us at support@rentlad.co.za</h5></legend>
                                                    <!--form action="" class="form-control mt-4">
                                                        <textarea class="form-control border border-dark col-sm-12 col-md-12" name="" id="" ></textarea>
                                                        <input type="submit" class="btn btn-primary text-center fw-semibold rounded col-12" value="Submit">
                                                    </form-->
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <!-- account... -->
                            <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab" tabindex="0">
                                <div class="container">
                                    <h4>Profile</h4>
                                    <p>Welcome to landlord support <?php echo $userName ?>. Feel free to contact us anytime.</p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




<!--property description update-->
<div class="modal fade" id="PropertyDescriptionUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Property Description Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-12"><input type="text" name="txtTitle" id="txtTitle" placeholder="enter title"class="form-control border-secondary" required></div>   
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--property rules update-->
<div class="modal fade" id="PropertyRulesUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Property Rules Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="row mt-4">
        <div class="col-12"> <textarea class="form-control border-secondary" name="txtRules" placeholder="Write your property rules here" id="txtRules"required></textarea></div>   
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--number of rooms update-->
<div class="modal fade" id="NumberOfRoomsUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Number of Rooms Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-4">
          <div class="col-12"><input type="text" name="txtNumberofRooms" id="txtNumberofRooms" placeholder=""class="form-control border-secondary"required></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--price update-->
<div class="modal fade" id="PriceUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Price Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
            <div class="col-12"><input type="text" name="txtPrice" id="txtPrice" placeholder="price of each room"class="form-control border-secondary"required></div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--city update-->
<div class="modal fade" id="CityUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">City Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <div class="col-12">
                  <div class="city-container">
                        <input type="text" name="txtCity" id="txtCity" placeholder="City"class="form-control border-secondary"required>
                        <div id="txtCitySuggestions"></div>
                    </div>  
                </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--suburb update-->
<div class="modal fade" id="SuburbUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Suburb Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-12"><input type="text" name="txtSuburb" id="txtSuburb" placeholder="Surburb"class="form-control border-secondary"required></div> 
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
</div>
<!--street update-->
<div class="modal fade" id="StreetUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Street Name Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
                <div class="col-12"><input type="text" name="txtSuburb" id="txtSuburb" placeholder="Street Name"class="form-control border-secondary"required></div> 
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
</div>
<!--house number update-->
<div class="modal fade" id="HouseNumberUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">House Number Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
                <div class="col-12"><input type="text" name="txtHouseNumber" id="txtHouseNumber" placeholder="House Number"class="form-control border-secondary"required></div>
                               
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
</div>
<!--NearestCampusUpdate-->
<div class="modal fade" id="NearestCampusUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Nearest campus Update</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mt-3">
          <div class="col-12"><input type="text" name="txtNearestCampus" id="txtNearestCampus" placeholder="enter campus or university"class="form-control border-secondary"required></div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>




</div>
<script defer src="updater/updater.js"></script>
   <script src="https://kit.fontawesome.com/b7de9bdb25.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
 </body>
</html>        
   