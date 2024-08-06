<?php 
include "connection.php";

// Check if 'id' parameter is set and not empty
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Prepare the SQL statement
    $sql = "DELETE FROM publisher2 WHERE id='$id'";
    
    // Execute the query
    $results = mysqli_query($conn, $sql);
    
    // Check if deletion was successful
    if($results){
        // Redirect back to authors.php with success message
        header("location: publisher.php?success=1");
        exit();
    } else {
        // Redirect back to authors.php with error message
        header("location: publisher.php?error=1");
        exit();
    }
} else {
    // Redirect back to authors.php with error message
    header("location: publisher.php?error=1");
    exit();
}
?>