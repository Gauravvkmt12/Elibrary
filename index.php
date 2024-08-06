<?php
include "connection.php";
$alert = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $sql = "SELECT * FROM register WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password']; 
            if (md5($password) === $hashed_password) {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['profile_picture'] = $row['profile_picture'];
                header('Location: main.php');
                exit();
            } else {
                $alert = "Invalid username or password";
            }
        } else {
            $alert = "Invalid username or password";
        }
        mysqli_free_result($result);
    } else {
        $alert = "Database query error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
    <title>LOGIN</title>
    <style>
      .form-control:focus{box-shadow:none;}
    </style>
</head>
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h2 class="text-center mb-4">ELibrary</h2>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
            <?php if(!empty($alert)): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $alert; ?>
            </div>
          <?php endif; ?>
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter your username" name="username" required>
            </div>
            <div class="form-group position-relative">
              <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password position-absolute top-50 end-0 translate-middle-y me-2 mt-2" style="cursor: pointer;"></span>
            </div>
            <div class="d-flex">
              <a href="#" class="ms-auto text-underline text-danger mb-1 " data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password</a>
              </div>
            <button type="submit" class="btn btn-danger btn-block w-100">Login</button><br></br>
          </form>
          <a href="register.php"><button type="submit" class="btn btn-primary btn-block w-100">Sign up</button></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-lock-fill" style="font-size: 2rem;"></i>
                </div>
                <p class="text-center">You can reset your password here.</p>
                <form action="change_password.php" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email address">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  document.querySelector('.toggle-password').addEventListener('click', function (e) {
    const passwordField = document.querySelector('#password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
  });
</script>
</body>
</html>