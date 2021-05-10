<nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <a class="navbar-brand" href="http://localhost:8080/camagru/index.php">Camagru</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if ($_SESSION['user']) { ?>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost:8080/camagru/webcam/webcam.php">Add/Delete Pics!</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost:8080/camagru/user/settings.php">Account Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost:8080/camagru/user/logout.php">Logout</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost:8080/camagru/user/login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost:8080/camagru/user/register.php">Sign Up</a>
          </li> <?php } ?>
      </ul>
    </div>
  </div>
</nav>
