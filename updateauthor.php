<?php
include "connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['authorName'])) {
    $id = $_POST['id'];
    $name = $_POST['authorName'];
    $sql = "UPDATE author2 SET Author_name='$name' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating record']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Form data not received']);
}
?>