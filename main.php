<?php
$title = "Home-Elibrary";
include "connection.php";
include "header.php";
?>
<style>
    .card{padding: 40px 40px;}
    a{text-decoration: none;}
</style>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
        <a href="authors.php" class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title text-center"><?php
                        $sql= "SELECT * FROM author2";
                        $result =mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($result);
                        echo $count;
                        ?></h5>
                    <p class="card-text text-center">ALL AUTHORS</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
        <a href="publisher.php" class="card bg-danger text-white">
                <div class="card-body">
                <h5 class="card-title text-center"><?php
                        $sql= "SELECT * FROM author2";
                        $result =mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($result);
                        echo $count;
                        ?></h5>
                    <p class="card-text text-center">ALL PUBLISHERS</p>
                </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
        <a href="categories.php" class="card bg-danger text-white">
                <div class="card-body">
                <h5 class="card-title text-center"><?php
                        $sql= "SELECT * FROM categories3";
                        $result =mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($result);
                        echo $count;
                        ?></h5>
                    <p class="card-text text-center">ALL CATEGORIES</p>
                </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="books.php" class="card bg-danger text-white">
                <div class="card-body ">
                <h5 class="card-title text-center"><?php
                        $sql= "SELECT * FROM book2";
                        $result =mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($result);
                        echo $count;
                        ?></h5>
                    <p class="card-text text-center">ALL BOOKS</p>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
        <a href="regstudent.php" class="card bg-danger text-white">
                <div class="card-body">
                <h5 class="card-title text-center"><?php
                        $sql= "SELECT * FROM regstudent2";
                        $result =mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($result);
                        echo $count;
                        ?></h5>
                    <p class="card-text text-center">ALL STUDENTS</p>
                </div>
        </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="bookissue.php" class="card bg-danger text-white">
                <div class="card-body">
                <h5 class="card-title text-center"><?php
                        $sql= "SELECT * FROM bookissue2";
                        $result =mysqli_query($conn,$sql);
                        $count=mysqli_num_rows($result);
                        echo $count;
                        ?></h5>
                    <p class="card-text text-center">BOOK ISSUE</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
        <a href="reports.php" class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title text-center">3</h5>
                    <p class="card-text text-center">REPORTS</p>
                </div>
        </a>
        </div>  
    </div>
</div>
<?php include "footer.php"; ?>