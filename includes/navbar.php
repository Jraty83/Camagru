<nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
	<!-- <a class="navbar-brand" href="index.php">Camagru</a> -->
    <a class="navbar-brand" href="http://localhost:8080/camagru/index.php">Camagru</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if ($_SESSION['user']) { ?>
          <li class="nav-item">
            <!-- <a class="nav-link" href="user/logout.php">Account Settings</a> -->
            <a class="nav-link" href="http://localhost:8080/camagru/user/settings.php">Account Settings</a>
          </li>
          <li class="nav-item">
          <!-- <a class="nav-link" href="user/logout.php">Logout</a> -->
          <a class="nav-link" href="http://localhost:8080/camagru/user/logout.php">Logout</a>
          <?php } else { ?>
            <li class="nav-item">
            <!-- <a class="nav-link" href="user/login.php">Login</a> -->
            <a class="nav-link" href="http://localhost:8080/camagru/user/login.php">Login</a>
            </li>
            <li class="nav-item">
            <!-- <a class="nav-link active" aria-current="page" href="user/register.php">Sign Up</a> -->
            <a class="nav-link active" aria-current="page" href="http://localhost:8080/camagru/user/register.php">Sign Up</a>
            </li> <?php } ?>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li> -->
      </ul>
      <!-- <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
    </div>
  </div>
</nav>
