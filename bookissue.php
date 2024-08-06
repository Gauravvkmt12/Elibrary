<?php
$title = "BookIssue-Elibrary";
include "connection.php";
include "header.php";
$records_per_page = 6;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;
$query = "SELECT * FROM bookissue2 LIMIT $offset, $records_per_page";
$start_sno = ($page_number - 1) * $records_per_page + 1;
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookissue2"));
$total_pages = ceil($total_rows / $records_per_page);
$alert_message = '';
if(isset($_POST['addBookBtn'])) {
    $studentID = $_POST['studentName'];
    $bookID = $_POST['bookName'];
    $issueDate = $_POST['issueDate'];
    $returnDate = $_POST['returnDate'];
    $status = 'Y';
        $insertSql = "INSERT INTO bookissue2 (Student_Name, Book_Name, Issue_Date, Return_Date, Status) 
        VALUES ('$studentID', '$bookID', '$issueDate', '$returnDate', '$status')";
        if ($conn->query($insertSql) === TRUE) {
            $alert_message = "New record added successfully.";
            } else {
                $alert_message = "Error: " . $insertSql . "<br>" . $conn->error;
            echo "Error executing query: " . $insertSql . "<br>" . $conn->error;
}
}
if(isset($_POST['deleteBtn'])) {
    $deleteId = $_POST['deleteId'];
    $deleteSql = "DELETE FROM bookissue2 WHERE id = '$deleteId'";
    if ($conn->query($deleteSql) === TRUE) {
        $alert_message = "Record deleted successfully.";
    } else {
        $alert_message = "Error deleting record: " . $conn->error;
    }
}
$sql = "SELECT 
            bookissue2.id AS issue_id, 
            regstudent2.StudentName AS Student_Name, 
            book2.Book_Name, 
            bookissue2.Issue_Date, 
            bookissue2.Return_Date, 
            bookissue2.Status,
            regstudent2.Phone, 
            regstudent2.Email 
        FROM 
            bookissue2 
        INNER JOIN 
            regstudent2 ON bookissue2.Student_Name = regstudent2.id
        INNER JOIN 
            book2 ON bookissue2.Book_Name = book2.id
        LIMIT $offset, $records_per_page";
$result = $conn->query($sql);
if ($result === false) {
    die("Error fetching data: " . $conn->error);
}
?>
<link rel="stylesheet" href="style.css">
<div class="dots-container">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<div id="content" style="display: none;">
<!-- Add Book Issue Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Add Book Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <select class="form-select" id="studentName" name="studentName" required>
                            <option value="">Select Student Name</option>
                            <?php
                            $student_query = "SELECT id, StudentName FROM regstudent2";
                            $student_result = $conn->query($student_query);
                            if ($student_result->num_rows > 0) {
                                while ($student_row = $student_result->fetch_assoc()) {
                                    echo "<option value='" . $student_row['id'] . "'>" . $student_row['StudentName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bookName" class="form-label">Book Name</label>
                        <select class="form-select" id="bookName" name="bookName" required>
                            <option value="">Select Book Name</option>
                            <?php
                            $book_query = "SELECT id, Book_Name FROM book2";
                            $book_result = $conn->query($book_query);
                            if ($book_result->num_rows > 0) {
                                while ($book_row = $book_result->fetch_assoc()) {
                                    echo "<option value='" . $book_row['id'] . "'>" . $book_row['Book_Name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="issueDate" class="form-label">Issue Date</label>
                        <input type="date" class="form-control" id="issueDate" name="issueDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="returnDate" class="form-label">Return Date</label>
                        <input type="date" class="form-control" id="returnDate" name="returnDate" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addBookBtn">Add Book Issue</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Book Issue Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookModalLabel">Edit Book Issue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="editBookForm" action="return_book.php">
                    <div class="mb-3">
                        <label for="editStudentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="editStudentName" name="editStudentName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editBookName" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="editBookName" name="editBookName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="editPhone" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editIssueDate" class="form-label">Issue Date</label>
                        <input type="text" class="form-control" id="editIssueDate" name="editIssueDate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editReturnDate" class="form-label">Return Date</label>
                        <input type="text" class="form-control" id="editReturnDate" name="editReturnDate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition</label>
                        <input type = "text" class="form-control" id="condition" name = "condition" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="returnBookBtn">Return Book</button>
                    <input type="hidden" id="returnBookIssueId" name="issueId">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal code here -->
<!-- Alert message -->
<?php if (!empty($alert_message)): ?>
    <div class="container mt-2">
        <div class="alert alert-<?php echo strpos($alert_message, 'successfully') !== false ? 'success' : 'danger'; ?>" role="alert">
            <?php echo $alert_message; ?>
        </div>
    </div>
<?php endif; ?>
<div class="container mt-2">
    <div class="row">
        <div class="col">
            <h4>All Books Issue</h4>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-danger" id="addcategoryBtn" data-bs-toggle="modal" data-bs-target="#addBookModal">Add Book Issue</button>
        </div>
    </div>
</div>
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class ="container-fluid table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
            <tr class="bg-dark text-white">
                    <th class="text-center">S NO.</th>
                    <th class="text-center">Student Name</th>
                    <th class="text-center">Book Name</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Issue Date</th>
                    <th class="text-center">Return Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
            $counter = $start_sno;
            while($row = $result->fetch_assoc()) {
            $status = $row["Status"];
            $statusClass = $status == 'Y' ? 'bg-danger text-white' : '';
            ?>
                <tr>
                    <td class='text-center'><?php echo $counter; ?></td>
                    <td><?php echo $row["Student_Name"]; ?></td>
                    <td><?php echo $row["Book_Name"]; ?></td>
                    <td><?php echo $row["Phone"]; ?></td>
                    <td><?php echo $row["Email"]; ?></td>
                    <td class='text-center'><?php echo $row["Issue_Date"]; ?></td>
                    <td class='text-center'><?php echo $row["Return_Date"]; ?></td>
                    <td class="text-center" style="background-color: <?php echo $status == 'Y' ? '#dc3545' : '#28a745'; ?>; color: white;">
                    <?php echo $status == 'Y' ? 'ISSUE' : 'RETURN'; ?>
                    </td>
                    <td class="text-center">
                    <button type="button" class="btn btn-primary editBtn" data-id="<?php echo $row['issue_id']; ?>" data-student-name="<?php echo $row['Student_Name']; ?>" data-book-name="<?php echo $row['Book_Name']; ?>" data-phone="<?php echo $row['Phone']; ?>" data-email="<?php echo $row['Email']; ?>" data-issue-date="<?php echo $row['Issue_Date']; ?>" data-return-date="<?php echo $row['Return_Date']; ?>" data-bs-toggle="modal" data-bs-target="#editBookModal">Edit</button>
                    </td>
                    <td class="text-center">
                    <form method="post" onsubmit="return confirmDelete();">
                    <input type="hidden" name="deleteId" value="<?php echo $row['issue_id']; ?>">
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                    </form>
                    </td>
                </tr>
                <?php
                    $counter++;
                    }
                } else {
                ?>
                <tr>
                    <td colspan='10' class='text-center'>No data available</td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table></div>
        <div class="text-center mb-5 mt-3">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $margin_class = $i > 1 ? 'ms-2' : '';
                $active_class = $i == $page_number ? 'active' : '';
                echo '<a href="bookissue.php?page=' . $i . '" class="btn btn-success ' . $margin_class . ' ' . $active_class . '">' . $i . '</a>';
            }
            ?>
        </div>
    </div>
</div>
</div>
<?php include "footer.php"; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.editBtn');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var issueId = this.dataset.id;
                document.getElementById('returnBookIssueId').value = issueId;
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.editBtn');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var studentName = this.dataset.studentName;
                var bookName = this.dataset.bookName;
                var phone = this.dataset.phone;
                var email = this.dataset.email;
                var issueDate = this.dataset.issueDate;
                var returnDate = this.dataset.returnDate;
                document.getElementById('editStudentName').value = studentName;
                document.getElementById('editBookName').value = bookName;
                document.getElementById('editPhone').value = phone;
                document.getElementById('editEmail').value = email;
                document.getElementById('editIssueDate').value = issueDate;
                document.getElementById('editReturnDate').value = returnDate;
            });
        });
    });
    function confirmDelete() {
        return confirm("Are you sure you want to delete it?");
    }
</script>
<script src="script.js"></script>