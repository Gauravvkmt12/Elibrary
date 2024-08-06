<?php
$title = "Publishers-Elibrary";
include "connection.php";
include "header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['publisherName'])) {
    $name = $_POST['publisherName'];
    $sql = "INSERT INTO publisher2 (publisher_name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        header("location: publisher.php?success=add");
        exit();
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
}
$records_per_page = 6;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;
$query = "SELECT * FROM publisher2 LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $query);
$start_sno = ($page_number - 1) * $records_per_page + 1;
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM publisher2"));
$total_pages = ceil($total_rows / $records_per_page);
$alert = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $alert = '<div class="alert alert-success" role="alert">publisher deleted successfully.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    $alert = '<div class="alert alert-danger" role="alert">Failed to delete publisher.</div>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['publisher_name'])) {
    $id = $_POST['id'];
    $name = $_POST['publisher_name'];
    $sql = "UPDATE publisher2 SET publisher_name='$name' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("location: publisher.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!-- Add publisher Modal -->
<div class="modal fade" id="addpublisherModal" tabindex="-1" aria-labelledby="addpublisherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addpublisherModalLabel">Add publisher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addpublisherForm" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="addpublisherName" class="form-label">publisher Name:</label>
            <input type="text" class="form-control" id="addpublisherName" name="publisherName">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add publisher</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit publisher Modal -->
<div class="modal fade" id="editpublisherModal" tabindex="-1" aria-labelledby="editpublisherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editpublisherModalLabel">Edit publisher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editpublisherForm" method="post">
        <div class="modal-body">
          <input type="hidden" id="editpublisherId" name="id">
          <div class="mb-3">
            <label for="editpublisherName" class="form-label">publisher Name:</label>
            <input type="text" class="form-control" id="editpublisherName" name="publisher_name">
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
            <h4>All Publishers</h4>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-danger" id="addpublisherBtn" data-bs-toggle="modal" data-bs-target="#addpublisherModal">Add publisher</button>
        </div>
    </div>
</div>

<div class="container mt-2">
    <div class="row justify-content-center">
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
                    <th class="text-center">publisher Name</th>
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
                        <td class="text-center"><?php echo $row["publisher_name"]; ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success editBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['publisher_name']; ?>">Edit</button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['publisher_name']; ?>">Delete</button>
                        </td>
                    </tr>
                    <?php
                    $start_sno++;
                }
                ?>
            </tbody>
        </table></div>
        <div class="text-center mb-5 mt-3">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $margin_class = $i > 1 ? 'ms-2' : '';
                echo '<a href="publisher.php?page=' . $i . '" class="btn btn-success ' . $margin_class . '">' . $i . '</a>';
            }
            ?>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script>
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const publisherName = btn.getAttribute('data-name');
        document.getElementById('editpublisherId').value = id;
        document.getElementById('editpublisherName').value = publisherName;
        var myModal = new bootstrap.Modal(document.getElementById('editpublisherModal'));
        myModal.show();
    });
});
document.getElementById('addpublisherBtn').addEventListener('click', () => {
    var myModal = new bootstrap.Modal(document.getElementById('addpublisherModal'));
    myModal.show();
});
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const publisherName = btn.getAttribute('data-name');
        const confirmDelete = confirm(`Are you sure you want to delete the publisher '${publisherName}'?`);
        if(confirmDelete) {
            window.location.href = `deletepublisher.php?id=${id}`;
        }
    });
});
</script>