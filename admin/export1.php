<?php
session_start();

if (empty($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

require_once("../db.php");

// Start building the table structure
$html = '<table border="1">
<tr>
  <th>Student Name</th>
  <th>Student Email</th>
  <th>Company Name</th>
  <th>Role</th>
  <th>CTC</th>
</tr>';

// Run the query from session
$sql = $_SESSION['QUERY'];
$result = $conn->query($sql);

// Loop through result rows and build table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $studentName = $row['firstname'] . ' ' . $row['lastname'];
        $studentEmail = $row['email'];
        $company = $row['jobtitle'];
        $role = $row['experience'];
        $ctc = $row['minimumsalary'];

        $html .= "<tr>
                    <td>{$studentName}</td>
                    <td>{$studentEmail}</td>
                    <td>{$company}</td>
                    <td>{$role}</td>
                    <td>{$ctc}</td>
                  </tr>";
    }
}

$html .= '</table>';

// Set headers for Excel file download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=placed_students.xls');

echo $html;
exit();
