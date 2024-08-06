<?php
include "connection.php";
include "nav.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if (strtotime($start_date) && strtotime($end_date) && $start_date <= $end_date) {
        $sql = "SELECT 
                    bookissue2.id AS issue_id, 
                    regstudent2.StudentName AS Student_Name, 
                    book2.Book_Name, 
                    bookissue2.Issue_Date, 
                    bookissue2.Return_Date, 
                    regstudent2.Phone, 
                    regstudent2.Email 
                FROM 
                    bookissue2 
                INNER JOIN 
                    regstudent2 ON bookissue2.Student_Name = regstudent2.id
                INNER JOIN 
                    book2 ON bookissue2.Book_Name = book2.id
                WHERE
                    bookissue2.Issue_Date BETWEEN '$start_date' AND '$end_date'";
        $result = $conn->query($sql);

        if ($result === false) {
            die("Error fetching data: " . $conn->error);
        }
        if ($result->num_rows === 0) {
            echo '<script>alert("No books issued in the selected date range.");</script>';
            echo '<script>window.location.href = "bookissuereport.php";</script>';
            exit();
        }
        require_once ('tcpdf/tcpdf.php');
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Book Issue Report');
        $pdf->SetHeaderData('', 0, 'Book Issue Report', '');
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $content = '<h3 style="text-align:center;">Books Issued from ' . date('d F Y', strtotime($start_date)) . ' to ' . date('d F Y', strtotime($end_date)) . '</h3><br>';
        $content .= '<table border="1" style="width:100%;">';
        $content .= '<tr><th style="text-align:center;">S.NO.</th><th style="text-align:center;">Student Name</th><th style="text-align:center;">Book Name</th><th style="text-align:center;">Issue Date</th><th style="text-align:center;">Return Date</th><th style="text-align:center;">Phone</th><th style="text-align:center;">Email</th></tr>';
        $counter = 1;
        while ($row = $result->fetch_assoc()) {
            $content .= '<tr>';
            $content .= '<td style="text-align:center;">' . $counter . '</td>';
            $content .= '<td style="text-align:center;">' . $row['Student_Name'] . '</td>';
            $content .= '<td style="text-align:center;">' . $row['Book_Name'] . '</td>';
            $content .= '<td style="text-align:center;">' . $row['Issue_Date'] . '</td>';
            $content .= '<td style="text-align:center;">' . $row['Return_Date'] . '</td>';
            $content .= '<td style="text-align:center;">' . $row['Phone'] . '</td>';
            $content .= '<td style="text-align:center;">' . $row['Email'] . '</td>';
            $content .= '</tr>';
            $counter++;
        }
        $content .= '</table>';
        $pdf->writeHTML($content, true, false, true, false, '');
        ob_clean();
        $pdf->Output('book_issue_report.pdf', 'D');
        exit();
    } else {
        echo '<script>alert("Invalid date range selected.");</script>';
        echo '<script>window.location.href = "bookissuereport.php";</script>';
        exit();
    }
}
?>
<title>BookIssueReport-Elibrary</title>
<link rel="stylesheet" href="style.css">
<div class="dots-container">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<div id="content" style="display: none;">
<div class="container">
        <h3 class="mt-2">Book Issue Report</h3>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                                <br>
                                <button type="submit" name="search" class="btn btn-danger btn-block">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="script.js"></script> 