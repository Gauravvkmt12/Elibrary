<?php
$title = "Book-Elibrary";
include "connection.php";
include "header.php";
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM book2 WHERE id = $delete_id";
    $conn->query($delete_query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_book'])) {
    $name = $_POST['Book_Name'];
    $category = $_POST['Category'];
    $author = $_POST['Author'];
    $publisher = $_POST['Publisher'];
    $add_query = "INSERT INTO book2 (Book_Name, Category, Author, Publisher) VALUES ('$name', '$category', '$author', '$publisher')";
    $conn->query($add_query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_book'])) {
    $id = $_POST['book_id'];
    $name = $_POST['Book_Name'];
    $category = $_POST['Category'];
    $author = $_POST['Author'];
    $publisher = $_POST['Publisher'];
    $edit_query = "UPDATE book2 SET Book_Name = '$name', Category = '$category', Author = '$author', Publisher = '$publisher' WHERE id = $id";
    $conn->query($edit_query);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
$categories_query = "SELECT id, category_name FROM categories3";
$categories_result = $conn->query($categories_query);
$authors_query = "SELECT id, author_name FROM author2";
$authors_result = $conn->query($authors_query);
$publishers_query = "SELECT id, publisher_name FROM publisher2";
$publishers_result = $conn->query($publishers_query);
$records_per_page = 6;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;
$start_sno = ($page_number - 1) * $records_per_page + 1;
$total_rows = $conn->query("SELECT * FROM book2")->num_rows;
$total_pages = ceil($total_rows / $records_per_page);
$book_query = "SELECT b.id, b.Book_Name, c.category_name, a.author_name, p.publisher_name 
               FROM book2 b
               JOIN categories3 c ON b.Category = c.id
               JOIN author2 a ON b.Author = a.id
               JOIN publisher2 p ON b.Publisher = p.id
               LIMIT $offset, $records_per_page";
$book_result = $conn->query($book_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col">
                <h4>All Books</h4>
            </div>
            <div class="col text-end">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addBookModal">Add Book</button>
            </div>
        </div>
    </div>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="container-fluid table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th class="text-center">S NO.</th>
                            <th class="text-center">Book Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Author</th>
                            <th class="text-center">Publisher</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $book_result->fetch_assoc()): ?>
                        <tr>
                            <td class='text-center'><?= $start_sno++ ?></td>
                            <td class='text-center'><?= $row["Book_Name"] ?></td>
                            <td class='text-center'><?= $row["category_name"] ?></td>
                            <td class='text-center'><?= $row["author_name"] ?></td>
                            <td class='text-center'><?= $row["publisher_name"] ?></td>
                            <td class='text-center'>
                                <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editBookModal<?= $row["id"] ?>'>Edit</button>
                            </td>
                            <td class='text-center'>
                                <button type='button' class='btn btn-danger' onclick='deleteBook(<?= $row["id"] ?>)'>Delete</button>
                            </td>
                        </tr>
                        <!-- Edit Book Modal -->
                        <div class="modal fade" id="editBookModal<?= $row["id"] ?>" tabindex="-1" aria-labelledby="editBookModalLabel<?= $row["id"] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editBookModalLabel<?= $row["id"] ?>">Edit Book</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="">
                                            <input type="hidden" name="book_id" value="<?= $row["id"] ?>">
                                            <div class="mb-3">
                                                <label for="Book_Name" class="form-label">Book Name</label>
                                                <input type="text" class="form-control" name="Book_Name" value="<?= $row["Book_Name"] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Category" class="form-label">Category</label>
                                                <select class="form-select" name="Category" required>
                                <option value="">Select a option</option>
                                <?php
                                // Reset categories result pointer
                                $categories_result->data_seek(0);
                                while ($cat = $categories_result->fetch_assoc()): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Author" class="form-label">Author</label>
                                                <select class="form-select" name="Author" required>
                            <option value="">Select a option</option>
                                <?php
                                // Reset authors result pointer
                                $authors_result->data_seek(0);
                                while ($auth = $authors_result->fetch_assoc()): ?>
                                    <option value="<?= $auth['id'] ?>"><?= $auth['author_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Publisher" class="form-label">Publisher</label>
                                                <select class="form-select" name="Publisher" required>
                            <option value="">Select a option</option>
                                <?php
                                // Reset publishers result pointer
                                $publishers_result->data_seek(0);
                                while ($pub = $publishers_result->fetch_assoc()): ?>
                                    <option value="<?= $pub['id'] ?>"><?= $pub['publisher_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                                            </div>
                                            <button type="submit" name="edit_book" class="btn btn-primary">Save changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3 mb-2">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $margin_class = $i > 1 ? 'ms-2' : '';
                    $active_class = $i == $page_number ? 'active' : '';
                    echo '<a href="books.php?page=' . $i . '" class="btn btn-success ' . $margin_class . ' ' . $active_class . '">' . $i . '</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="Book_Name" class="form-label">Book Name</label>
                            <input type="text" class="form-control" name="Book_Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="Category" class="form-label">Category</label>
                            <select class="form-select" name="Category" required>
                                <option value="">Select a option</option>
                                <?php
                                // Reset categories result pointer
                                $categories_result->data_seek(0);
                                while ($cat = $categories_result->fetch_assoc()): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Author" class="form-label">Author</label>
                            <select class="form-select" name="Author" required>
                            <option value="">Select a option</option>
                                <?php
                                // Reset authors result pointer
                                $authors_result->data_seek(0);
                                while ($auth = $authors_result->fetch_assoc()): ?>
                                    <option value="<?= $auth['id'] ?>"><?= $auth['author_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Publisher" class="form-label">Publisher</label>
                            <select class="form-select" name="Publisher" required>
                            <option value="">Select a option</option>
                                <?php
                                // Reset publishers result pointer
                                $publishers_result->data_seek(0);
                                while ($pub = $publishers_result->fetch_assoc()): ?>
                                    <option value="<?= $pub['id'] ?>"><?= $pub['publisher_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteBook(bookId) {
            if (confirm('Are you sure you want to delete this book?')) {
                window.location.href = '<?= $_SERVER['PHP_SELF'] ?>?delete_id=' + bookId;
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
