<?php
$title = "Student-Elibrary";
include "connection.php";
include "header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Student_Name'])) {
    $student_name = $_POST['Student_Name'];
    $gender = $_POST['Gender'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $sql = "INSERT INTO regstudent2 (StudentName, Gender, Phone, Email) VALUES ('$student_name', '$gender', '$phone', '$email')";
    if (mysqli_query($conn, $sql)) {
        header("location: regstudent.php?success=add");
        exit();
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
}
$records_per_page = 6;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;
$query = "SELECT * FROM regstudent2 LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $query);
$start_sno = ($page_number - 1) * $records_per_page + 1;
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM regstudent2"));
$total_pages = ceil($total_rows / $records_per_page);
$alert = '';
if (isset($_GET['success']) && $_GET['success'] == 'add') {
    $alert = '<div class="alert alert-success" role="alert">Student added successfully.</div>';
} elseif (isset($_GET['success']) && $_GET['success'] == 'update') {
    $alert = '<div class="alert alert-success" role="alert">Student details updated successfully.</div>';
} elseif (isset($_GET['success']) && $_GET['success'] == 'delete') {
    $alert = '<div class="alert alert-success" role="alert">Student deleted successfully.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    $alert = '<div class="alert alert-danger" role="alert">Failed to delete Student.</div>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['editStudentName'], $_POST['editGender'], $_POST['editPhone'], $_POST['editEmail'])) {
    $id = $_POST['id'];
    $studentName = $_POST['editStudentName'];
    $gender = $_POST['editGender'];
    $phone = $_POST['editPhone'];
    $email = $_POST['editEmail'];
    $sql = "UPDATE regstudent2 SET StudentName='$studentName', Gender='$gender', Phone='$phone', Email='$email' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("location: regstudent.php?success=update");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<title>Student-Elibrary</title>
<link rel="stylesheet" href="style.css">
<div class="dots-container">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<div id="content" style="display: none;">
<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addStudentForm" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="addStudentName" class="form-label">Student Name:</label>
            <input type="text" class="form-control" id="addStudentName" name="Student_Name">
          </div>
          <div class="mb-3">
            <label for="addGender" class="form-label">Gender:</label>
            <select class="form-select" id="addGender" name="Gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="addPhone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="addPhone" name="Phone">
          </div>
          <div class="mb-3">
            <label for="addEmail" class="form-label">Email:</label>
            <input type="text" class="form-control" id="addEmail" name="Email">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- View Student Modal -->
<div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewStudentModalLabel">View Student Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="viewStudentName" class="form-label">Student Name:</label>
          <input type="text" class="form-control" id="viewStudentName" readonly>
        </div>
        <div class="mb-3">
          <label for="viewGender" class="form-label">Gender:</label>
          <input type="text" class="form-control" id="viewGender" readonly>
        </div>
        <div class="mb-3">
          <label for="viewPhone" class="form-label">Phone:</label>
          <input type="text" class="form-control" id="viewPhone" readonly>
        </div>
        <div class="mb-3">
          <label for="viewEmail" class="form-label">Email:</label>
          <input type="text" class="form-control" id="viewEmail" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editStudentForm" method="post">
        <div class="modal-body">
          <input type="hidden" id="editStudentId" name="id">
          <div class="mb-3">
            <label for="editStudentName" class="form-label">Student Name:</label>
            <input type="text" class="form-control" id="editStudentName" name="editStudentName">
          </div>
          <div class="mb-3">
            <label for="editGender" class="form-label">Gender:</label>
            <select class="form-select" id="editGender" name="editGender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editPhone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="editPhone" name="editPhone">
          </div>
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email:</label>
            <input type="text" class="form-control" id="editEmail" name="editEmail">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="container mt-2">
    <div class="row">
        <div class="col">
            <h4>All Students</h4>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-danger" id="addStudentBtn" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
        </div>
    </div>
</div>
<div class="container mt-2">
    <div class="row">
        <?php if(!empty($alert)): ?>
            <div class="alert-container" role="alert">
                <?php echo $alert; ?>
            </div>
        <?php endif; ?>
        <div class="container-fluid table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr class="bg-dark text-white">
                    <th class="text-center">S NO.</th>
                    <th class="text-center">Student Name</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $start_sno; ?></td>
                        <td class="text-center"><?php echo $row["StudentName"]; ?></td>
                        <td class="text-center"><?php echo $row["Gender"]; ?></td>
                        <td class="text-center"><?php echo $row["Phone"]; ?></td>
                        <td class="text-center"><?php echo $row["Email"]; ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary viewBtn"
                                    data-student-name="<?php echo $row['StudentName']; ?>"
                                    data-gender="<?php echo $row['Gender']; ?>"
                                    data-phone="<?php echo $row['Phone']; ?>"
                                    data-email="<?php echo $row['Email']; ?>">
                                View
                            </button>
                        </td>    
                        <td class="text-center">
                            <button type="button" class="btn btn-success editBtn" 
                                    data-id="<?php echo $row['id']; ?>" 
                                    data-name="<?php echo $row['StudentName']; ?>" 
                                    data-gender="<?php echo $row['Gender']; ?>"
                                    data-phone="<?php echo $row['Phone']; ?>"
                                    data-email="<?php echo $row['Email']; ?>">
                                Edit
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['StudentName']; ?>">Delete</button>
                        </td>
                    </tr>
                    <?php
                    $start_sno++;
                }
                ?>
            </tbody>
        </table></div>
        <div class="text-center mt-3 mb-5">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $margin_class = $i > 1 ? 'ms-2' : '';
                echo '<a href="regstudent.php?page=' . $i . '" class="btn btn-success ' . $margin_class . '">' . $i . '</a>';
            }
            ?>
        </div>
    </div>
</div>
</div>
<?php include "footer.php"; ?>
<script>
    document.querySelectorAll('.viewBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            // Get data from the corresponding row
            const studentName = btn.dataset.studentName;
            const gender = btn.dataset.gender;
            const phone = btn.dataset.phone;
            const email = btn.dataset.email;

            // Populate modal with data
            document.getElementById('viewStudentName').value = studentName;
            document.getElementById('viewGender').value = gender;
            document.getElementById('viewPhone').value = phone;
            document.getElementById('viewEmail').value = email;

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('viewStudentModal'));
            myModal.show();
        });
    });

    // Populate edit modal with student data
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const studentName = btn.getAttribute('data-name');
            const gender = btn.getAttribute('data-gender');
            const phone = btn.getAttribute('data-phone');
            const email = btn.getAttribute('data-email');

            // Populate edit form fields
            document.getElementById('editStudentId').value = id;
            document.getElementById('editStudentName').value = studentName;
            document.getElementById('editGender').value = gender;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editEmail').value = email;

            // Show the edit modal
            var myModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
            myModal.show();
        });
    });

    document.getElementById('addStudentBtn').addEventListener('click', () => {
        var myModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
        myModal.show();
    });

    // Delete student
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const studentName = btn.getAttribute('data-name');

            // Show confirmation dialog
            const confirmDelete = confirm(`Are you sure you want to delete the student '${studentName}'?`);

            // If user confirms deletion, redirect to deletestudent.php with ID parameter
            if (confirmDelete) {
                window.location.href = `deletestudent.php?id=${id}`;
            }
        });
    });
</script>
<script src="script.js"></script>