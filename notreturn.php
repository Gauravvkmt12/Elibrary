<?php
// Start output buffering
ob_start();

include "connection.php";
include "nav.php";

// Initialize variables
$records = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['due_date'])) {
    $dueDate = $_POST['due_date'];

    // Query to get records where Return_Date is due
    $query = "SELECT bi.id, rs.StudentName, b.Book_Name, rs.Phone, bi.Return_Date 
          FROM bookissue2 bi
          INNER JOIN regstudent2 rs ON bi.StudentName = rs.StudentName
          INNER JOIN book2 b ON bi.Book_Name = b.Book_Name
          WHERE bi.Return_Date <= ?";
    $stmt = $conn->prepare($query);
    
    // Check for errors in prepared statement
    if (!$stmt) {
        die("Error in prepared statement: " . $conn->error);
    }

    $stmt->bind_param("s", $dueDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
    } else {
        echo "<script>alert('No records found.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Returned Books</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($records)) { ?>
        <div class="container mt-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Book Name</th>
                        <th>Phone</th>
                        <th>Return Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['id']); ?></td>
                            <td><?php echo htmlspecialchars($record['Student_Name']); ?></td>
                            <td><?php echo htmlspecialchars($record['Book_Name']); ?></td>
                            <td><?php echo htmlspecialchars($record['Phone']); ?></td>
                            <td><?php echo htmlspecialchars($record['Return_Date']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</body>
</html>
<?php
// End output buffering and flush
ob_end_flush();
?>
