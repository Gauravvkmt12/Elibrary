<?php
include "connection.php";
// Fetch data from books table
$sql = "SELECT bookname, category_id, author_id, publisher_id FROM books";
$result = $conn->query($sql);

if ($result === false) {
    die("Error fetching data: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Book Name</th><th>Category</th><th>Author</th><th>Publisher</th></tr>";
    while($row = $result->fetch_assoc()) {
        $bookname = $row["bookname"];

        // Fetch category name from categories3 table
        $category_id = $row["category_id"];
        $category_query = "SELECT category_name FROM categories3 WHERE id = $category_id";
        $category_result = $conn->query($category_query);
        if ($category_result === false) {
            die("Error fetching category: " . $conn->error);
        }
        $category_row = $category_result->fetch_assoc();
        $category = $category_row["category_name"];

        // Fetch author name from author2 table
        $author_id = $row["author_id"];
        $author_query = "SELECT author_name FROM author2 WHERE id = $author_id";
        $author_result = $conn->query($author_query);
        if ($author_result === false) {
            die("Error fetching author: " . $conn->error);
        }
        $author_row = $author_result->fetch_assoc();
        $author = $author_row["author_name"];

        // Fetch publisher name from publisher2 table
        $publisher_id = $row["publisher_id"];
        $publisher_query = "SELECT publisher_name FROM publisher2 WHERE id = $publisher_id";
        $publisher_result = $conn->query($publisher_query);
        if ($publisher_result === false) {
            die("Error fetching publisher: " . $conn->error);
        }
        $publisher_row = $publisher_result->fetch_assoc();
        $publisher = $publisher_row["publisher_name"];

        echo "<tr><td>$bookname</td><td>$category</td><td>$author</td><td>$publisher</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
