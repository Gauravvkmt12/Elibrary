<?php
include "checksession.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-fluid">
  <div class="row align-items-center">
    <div class="col">
      <a href="main.php"><img src="./images/ELibrary.png" alt="ELibrary Logo" class="img-fluid" style="width:200px; height:100px; overflow:hidden;"></a>
    </div>
    <div class="col text-end">
      <div class="dropdown mb-2">
        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="d-flex align-items-center">
          <img src="<?php echo isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : './images/default-profile.jpg'; ?>" 
          alt="Profile Picture" 
          style="width:50px; height:50px; overflow:hidden; border-radius:50%; margin-right:5%;"> 
            <h5> Hi!
            <?php
                if(isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                } else {
                    echo "Username not set";
                } 
            ?>
            </h5>
          </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
          <li><a class="dropdown-item" href="manageaccount.php">Manage Account</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-lg bg-danger">
  <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
          <span class="text-white"><i class="fa-solid fa-bars"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent"  style="justify-content: space-around;">
          <ul class="navbar-nav">
              <li class="nav-item"><a href="main.php" class="nav-link text-white">DASHBOARD</a></li>
              <li class="nav-item"><a href="authors.php" class="nav-link text-white">AUTHORS</a></li>
              <li class="nav-item"><a href="publisher.php" class="nav-link text-white">PUBLISHERS</a></li>
              <li class="nav-item"><a href="categories.php" class="nav-link text-white">CATEGORIES</a></li>
              <li class="nav-item"><a href="books.php" class="nav-link text-white">BOOKS</a></li>
              <li class="nav-item"><a href="regstudent.php" class="nav-link text-white">REG STUDENTS</a></li>
              <li class="nav-item"><a href="bookissue.php" class="nav-link text-white">BOOK ISSUE</a></li>
              <li class="nav-item"><a href="reports.php" class="nav-link text-white">REPORTS</a></li>
            </ul>
      </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/07d6f4b411.js" crossorigin="anonymous"></script>
<script>
  document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
                e.preventDefault();
            }
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
            }
        });
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
</script>
</body>
</html>