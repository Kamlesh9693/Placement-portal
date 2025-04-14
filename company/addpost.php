<?php

session_start();

if (empty($_SESSION['id_company'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../db.php");
require_once("../PHPMailer/src/PHPMailer.php");
require_once("../PHPMailer/src/SMTP.php");
require_once("../PHPMailer/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jobtitle = trim($_POST['jobtitle']);
    $description = trim($_POST['description']);
    $minimumsalary = trim($_POST['minimumsalary']);
    $maximumsalary = trim($_POST['maximumsalary']);
    $experience = trim($_POST['experience']);
    $qualification = trim($_POST['qualification']);

    // Save to DB
    $stmt = $conn->prepare("INSERT INTO job_post (id_company, jobtitle, description, minimumsalary, maximumsalary, experience, qualification) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $_SESSION['id_company'], $jobtitle, $description, $minimumsalary, $maximumsalary, $experience, $qualification);
    
    if ($stmt->execute()) {
        $_SESSION['jobPostSuccess'] = true;

        // Step 3: Fetch student emails
        $result = $conn->query("SELECT email FROM users WHERE active=1");

        // Step 4: Send Emails
        while ($row = $result->fetch_assoc()) {
            $mail = new PHPMailer(true);

            try {
                // SMTP Config
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'youremail@gmail.com'; // your email
                $mail->Password = 'your password';    // App Password or email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Email Details
                $mail->setFrom('your-email@gmail.com', 'Placement Cell');
                $mail->addAddress($row['email']);
                $mail->isHTML(true);
                $mail->Subject = "New Placement Drive: $jobtitle";
                $mail->Body = "
                    <h3>New Placement Opportunity</h3>
                    <p><strong>Job Title:</strong> $jobtitle</p>
                    <p><strong>CTC:</strong> ₹$minimumsalary - ₹$maximumsalary</p>
                    <p><strong>Qualification Required:</strong> $qualification</p>
                    <p><strong>Description:</strong><br>$description</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Mail failed: {$mail->ErrorInfo}");
            }
        }

        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
