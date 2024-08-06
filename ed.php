<?php
include "connection.php";
include "nav.php";

// Number of records per page
$records_per_page = 6;

// Determine current page number
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the SQL LIMIT clause
$offset = ($page_number - 1) * $records_per_page;

// Query to fetch records for the current page
$query = "SELECT * FROM author2 LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $query);

// Start S.NO. count for each page
$start_sno = ($page_number - 1) * $records_per_page + 1;

// Count the total number of rows in the table
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM author2"));

// Calculate total number of pages
$total_pages = ceil($total_rows / $records_per_page);

$alert = '';
if(isset($_GET['success']) && $_GET['success'] == 1) {
    $alert = '<div class="alert alert-success" role="alert">Author deleted successfully.</div>';
} elseif(isset($_GET['error']) && $_GET['error'] == 1) {
    $alert = '<div class="alert alert-danger" role="alert">Failed to delete author.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
</head>
<body>

<div class="container mt-2">
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
        <!-- Alert Messages -->
        <?php if (!empty($alert)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $alert; ?>
            </div>
        <?php endif; ?>

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
                // Display the rows with correct S.NO.
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $start_sno; ?></td>
                        <td class="text-center">
                            <span class="author-text"><?php echo $row["Author_name"]; ?></span>
                            <input type="text" class="form-control author-input" value="<?php echo $row["Author_name"]; ?>" style="display: none;">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success editBtn">Edit</button>
                            <button type="button" class="btn btn-primary saveBtn" style="display: none;">Save Changes</button>
                        </td>
                        <td class="text-center">
                            <!-- Add onclick attribute to trigger confirmation dialog -->
                            <button type="button" class="btn btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['Author_name']; ?>">Delete</button>
                            </td>
                    </tr>
                    <?php
                    $start_sno++; // Increment S.NO. for the next row
                }
                ?>
            </tbody>
        </table>
        
    </div>
</div>

<script>
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const row = btn.closest('tr');
        const authorText = row.querySelector('.author-text');
        const authorInput = row.querySelector('.author-input');
        const saveBtn = row.querySelector('.saveBtn');
        
        // Toggle display of text and input field
        authorText.style.display = 'none';
        authorInput.style.display = 'block';
        saveBtn.style.display = 'inline-block';
        btn.style.display = 'none';
    });
});

document.querySelectorAll('.saveBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const row = btn.closest('tr');
        const authorText = row.querySelector('.author-text');
        const authorInput = row.querySelector('.author-input');
        const editBtn = row.querySelector('.editBtn');
        
        // Update the text with input field value
        authorText.textContent = authorInput.value;
        
        // Toggle display of text and input field
        authorText.style.display = 'inline-block';
        authorInput.style.display = 'none';
        editBtn.style.display = 'inline-block';
        btn.style.display = 'none';
        
    });
});

//for delete the author
// Get all delete buttons
//for delete the author
// Get all delete buttons
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const authorName = btn.getAttribute('data-name');
        
        // Show confirmation dialog
        const confirmDelete = confirm(`Are you sure you want to delete the author '${authorName}'?`);
        
        // If user confirms deletion, redirect to deleteauthor.php with ID parameter
        if(confirmDelete) {
            window.location.href = `deleteauthor.php?id=${id}`;
        }
    });
});





</script>
</body>
</html>
