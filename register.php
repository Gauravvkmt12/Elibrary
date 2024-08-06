<?php
include "connection.php";
$alert = "";
$regi = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form submitted, process the data
    
    // Check if all required fields are provided
    if(isset($_POST['username'], $_POST['Name'], $_POST['password'], $_POST['email'], $_POST['phone'], $_POST['address'])){
        $username = $_POST['username'];
        $name = $_POST['Name'];
        $pass = $_POST['password'];
        $password = md5($pass);
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Validation
        if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $alert = "Only letters and white space allowed for username";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $alert = "Only letters and white space allowed for name";
        } elseif (!preg_match("/^\d{10}$/", $phone)) {
            $alert = "Phone number should be 10 digits long and contain only digits";
        }

        $sql = "SELECT * FROM register WHERE Username = '$username'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $alert = "This username is already exist ";
        }
        elseif(empty($alert)) {
            $sql_insert = "INSERT INTO register (Username, Name, Password, Email, Phone, Address) VALUES ('$username', '$name', '$password', '$email', '$phone', '$address')";
            if ($conn->query($sql_insert) === TRUE) {
                $regi = "Register successfully";
            } else {
                echo "Error: " . $sql_insert . "<br>" . $conn->error;
            }
        }
    }    
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/rge.css">
</head>
<body>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h2 class="text-center mb-4">Register</h2>
          <?php if(!empty($alert)): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $alert; ?>
            </div>
          <?php endif; ?>
          <?php if(!empty($regi)): ?>
            <div class="alert alert-success" role="alert">
              <?php echo $regi; ?>
            </div>
          <?php endif; ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter your username" name="username" required>
            </div>
            <div class="form-group">
              <label for="Name">Name</label>
              <input type="text" class="form-control" placeholder="Enter your name" name="Name" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
            </div>
            <div class="form-group">
              <label for="Email">Email</label>
              <input type="Email" class="form-control"  placeholder="Enter your email" name="email" required>
            </div>
            <div class="form-group">
              <label for="phone no">Phone no</label>
              <input type="text" class="form-control" placeholder="Enter your phone no" name="phone" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" placeholder="Enter your address" name="address" required>
            </div><br>
            <button type="submit" class="btn btn-primary btn-block w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
