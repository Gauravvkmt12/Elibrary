<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["issueId"]) && isset($_POST["condition"])) {
    // Retrieve the issue ID and condition from the POST data
    $issueId = $_POST["issueId"];
    $condition = $_POST["condition"];

    // Update the status column to "N" for the corresponding record
    $updateSql = "UPDATE bookissue2 SET Status = 'N' WHERE id = '$issueId'";

    if ($conn->query($updateSql) === TRUE) {
        // Insert condition into the database
        $condition = $conn->real_escape_string($condition); // Sanitize input
        $insertConditionSql = "UPDATE bookissue2 SET condition2 = '$condition' WHERE id = '$issueId'";
        
        if ($conn->query($insertConditionSql) === TRUE) {
            // Redirect back to the original page
            header("Location: bookissue.php");
            exit();
        } else {
            // Error updating condition
            echo "Error updating condition: " . $conn->error;
        }
    } else {
        // Error updating status
        echo "Error updating status: " . $conn->error;
    }
} else {
    // Invalid request
    echo "Invalid request.";
}
?>
