<?php
$title = "Authors-Elibrary";
include "connection.php";
include "header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['authorName'])) {
    $name = $_POST['authorName'];
    $sql = "INSERT INTO author2 (Author_name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        header("location: authors.php?success=add");
        exit();
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
}
$records_per_page = 6;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;
$query = "SELECT * FROM author2 LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $query);
$start_sno = ($page_number - 1) * $records_per_page + 1;
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM author2"));
$total_pages = ceil($total_rows / $records_per_page);
$alert = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $alert = '<div class="alert alert-success" role="alert">Author deleted successfully.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    $alert = '<div class="alert alert-danger" role="alert">Failed to delete author.</div>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['author_name'])) {
    $id = $_POST['id'];
    $name = $_POST['author_name'];
    $sql = "UPDATE author2 SET Author_name='$name' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("location: authors.php?success=update");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!-- Add Author Modal -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAuthorModalLabel">Add Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addAuthorForm" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="addAuthorName" class="form-label">Author Name:</label>
            <input type="text" class="form-control" id="addAuthorName" name="authorName">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Author</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Author Modal -->
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAuthorModalLabel">Edit Author</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editAuthorForm" method="post">
        <div class="modal-body">
          <input type="hidden" id="editAuthorId" name="id">
          <div class="mb-3">
            <label for="editAuthorName" class="form-label">Author Name:</label>
            <input type="text" class="form-control" id="editAuthorName" name="author_name">
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

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h4>All Authors</h4>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-danger" id="addAuthorBtn" data-bs-toggle="modal" data-bs-target="#addAuthorModal">Add Author</button>
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
                    <th class="text-center">Author Name</th>
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
                        <td class="text-center"><?php echo $row["Author_name"]; ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success editBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['Author_name']; ?>">Edit</button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['Author_name']; ?>">Delete</button>
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
                echo '<a href="authors.php?page=' . $i . '" class="btn btn-success ' . $margin_class . '">' . $i . '</a>';
            }
            ?>
        </div>
    </div>
</div>
<?php include "footer.php" ?>
<script>
// Populate edit modal with author data
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const authorName = btn.getAttribute('data-name');
        document.getElementById('editAuthorId').value = id;
        document.getElementById('editAuthorName').value = authorName;
        var myModal = new bootstrap.Modal(document.getElementById('editAuthorModal'));
        myModal.show();
    });
});

document.getElementById('addAuthorBtn').addEventListener('click', () => {
    var myModal = new bootstrap.Modal(document.getElementById('addAuthorModal'));
    myModal.show();
});
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const authorName = btn.getAttribute('data-name');
        const confirmDelete = confirm(`Are you sure you want to delete the author '${authorName}'?`);
        if(confirmDelete) {
            window.location.href = `deleteauthor.php?id=${id}`;
        }
    });
});
</script>