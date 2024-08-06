<?php
$title = "Reports-Elibrary";
include "connection.php";
include "header.php";
?>
<title>Reports-Elibrary</title>
<link rel="stylesheet" href="style.css">  
<div class="dots-container">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<div id="content" style="display: none;">
<div class="container">
    <h2 class="text-center mt-2">Reports</h2>
    <div class="col text-center bg-danger">
                <hr>
            </div>
    <div class="row justify-content-around">
        <div class="col-lg-4 col-md-6 mb-4">
        <a href="bookissuereport.php">
            <div class="card bg-danger">
                <div class="card-body">
                <h3 class="text-center text-white">Book Issue Report</h3>
                </div>
            </div>
        </a>
        </div>
    </div>
</div>
</div>
<?php include "footer.php"; ?>
<script src="script.js"></script>