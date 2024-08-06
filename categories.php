<?php
$title = "Categories-Elibrary";
include "connection.php";
include "header.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoryName'])) {
    $name = $_POST['categoryName'];
    $sql = "INSERT INTO categories3 (category_name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        header("location: categories.php?success=add");
        exit();
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }
}
$records_per_page = 6;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;
$query = "SELECT * FROM categories3 LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $query);
$start_sno = ($page_number - 1) * $records_per_page + 1;
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories3"));
$total_pages = ceil($total_rows / $records_per_page);
$alert = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $alert = '<div class="alert alert-success" role="alert">category deleted successfully.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    $alert = '<div class="alert alert-danger" role="alert">Failed to delete category.</div>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['category_name'])) {
    $id = $_POST['id'];
    $name = $_POST['category_name'];
    $sql = "UPDATE categories3 SET category_name='$name' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("location: categories.php?success=update");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>category</title>
</head>
<body>

<!-- Add category Modal -->
<div class="modal fade" id="addcategoryModal" tabindex="-1" aria-labelledby="addcategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addcategoryModalLabel">Add category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addcategoryForm" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="addcategoryName" class="form-label">category Name:</label>
            <input type="text" class="form-control" id="addcategoryName" name="categoryName">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit category Modal -->
<div class="modal fade" id="editcategoryModal" tabindex="-1" aria-labelledby="editcategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editcategoryModalLabel">Edit category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editcategoryForm" method="post">
        <div class="modal-body">
          <input type="hidden" id="editcategoryId" name="id">
          <div class="mb-3">
            <label for="editcategoryName" class="form-label">category Name:</label>
            <input type="text" class="form-control" id="editcategoryName" name="category_name">
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
            <h4>All Category</h4>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-danger" id="addcategoryBtn" data-bs-toggle="modal" data-bs-target="#addcategoryModal">Add Category</button>
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
                    <th class="text-center">Categories</th>
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
                        <td class="text-center"><?php echo $row["category_name"]; ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success editBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['category_name']; ?>">Edit</button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['category_name']; ?>">Delete</button>
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
                echo '<a href="categories.php?page=' . $i . '" class="btn btn-success ' . $margin_class . '">' . $i . '</a>';
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
        const categoryName = btn.getAttribute('data-name');
        document.getElementById('editcategoryId').value = id;
        document.getElementById('editcategoryName').value = categoryName;
        var myModal = new bootstrap.Modal(document.getElementById('editcategoryModal'));
        myModal.show();
    });
});
document.getElementById('addcategoryBtn').addEventListener('click', () => {
    var myModal = new bootstrap.Modal(document.getElementById('addcategoryModal'));
    myModal.show();
});
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const categoryName = btn.getAttribute('data-name');
        
        // Show confirmation dialog
        const confirmDelete = confirm(`Are you sure you want to delete the category '${categoryName}'?`);
        
        // If user confirms deletion, redirect to deletecategory.php with ID parameter
        if(confirmDelete) {
            window.location.href = `deletecategory.php?id=${id}`;
        }
    });
});
</script>