<nav class="navbar navbar-expand-lg bg-success sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" aria-label="logo text">
      <svg width="200" height="60" xmlns="http://www.w3.org/2000/svg">
        <text x="0" y="40" font-family="MV Boli" font-size="40" fill="white">RentLad.</text>
      </svg>
    </a>
    <!-- Navbar links visible on large screens -->
    <ul class="navbar-nav g-2 d-flex text-white d-none d-lg-flex">

      <?php if (!isset($_SESSION['userID'], $_SESSION['userName'])) {?>
      <li class="nav-item">
        <a class="nav-link text-white" href="login.php"aria-label="login">log in</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="signup.php" aria-label="signup">sign up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white fw-bold" href="listyourproperty.php" aria-label="list your property">list your property</a>
      </li>
      <?php }else{ 
        $userID= $_SESSION['userID'];
        $User = $_SESSION['userName'];
        $userType = $_SESSION['userType'];
        $dashboardURL = ($userType === 'landlord') ? 'landlord.dashboard.php' : 'student.dashboard.php';?>

        <ul class="navbar-nav g-2 d-flex text-white d-none d-lg-flex">
        <?php if ($userType == "landlord") { ?>
            <a class="nav-link fw-bold mx-5 text-white" href="listyourproperty.php" aria-label="list your property">List Your Property</a>
        <?php } ?>
        <li class="nav-item">
          <span class="badge d-flex align-items-center p-1 pe-2 border border-2 border-warning rounded-pill mt-1">
            <a href="<?php echo $dashboardURL; ?>" class="text-white text-decoration-none "><img class="rounded-circle me-1 bg-white" width="24" height="24" src="resources/icons/user.png" alt="">
              <?php echo $User; ?></a>
          </span>
        </li>
      </ul>
      <a class="nav-link text-white" href="logout.php" aria-label="logout"><i class="fa-solid fa-right-from-bracket text-white mt-1"></i></a>

      <?php }?>
      
    </ul>

    <!-- Offcanvas toggle button visible on small screens -->
    <button class="navbar-toggler d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav" aria-controls="offcanvasNav" aria-label="offcanvas btn">
    <span class="navbar-toggler-icon" style="background-image: url('resources/icons/more.png');
    background-size: cover;background-position: center;"></span>
    </button>
  </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <hr>
  <div class="offcanvas-body">
    <!-- Offcanvas menu links -->
    <ul class="navbar-nav g-2 d-flex text-dark d-lg-none">
    <?php if (!isset($_SESSION['userID'], $_SESSION['userName'])) {?>
      <li class="nav-item">
        <a class="nav-link text-dark" href="login.php" aria-label="login"><img src="resources/icons/sign-in.png" height="25" width="25" alt=""> log in</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" href="signup.php" aria-label="signup"></i><img src="resources/icons/add-user.png" height="25" width="25" alt=""> sign up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link fw-bold text-dark" href="listyourproperty.php" aria-label="list your property"><img src="resources/icons/house-plus.png" height="25" width="25" alt="">list your property</a>
      </li>
      <?php }else{ ?>
         <a class="nav-link text-dark" href="<?php echo $dashboardURL; ?>" aria-label="list your property"><img src="resources/icons/user.png" height="25" width="25" alt=""> My Account</a>
         <?php if ($userType == "landlord") { ?>
            <a class="nav-link fw-bold text-dark" href="listyourproperty.php" aria-label="list your property"><img src="resources/icons/house-plus.png" height="25" width="25" alt=""> List Your Property</a>
        <?php } ?>
         <a class="nav-link text-dark" href="logout.php" aria-label="logout"><img src="resources/icons/logout.png" height="25" width="25" alt=""> log out</a>
      <?php  }?>
    </ul>
  </div>
</div>
