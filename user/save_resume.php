<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../db.php");


    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $internship = $_POST["internship"];
    $projects = $_POST["projects"];
    $activities = $_POST["activities"];
    $skills = $_POST["skills"];
    $education = $_POST["education"];

    $stmt = $conn->prepare("INSERT INTO resumes (name, email, phone, address, internship, projects, activities, skills, education) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $email, $phone, $address, $internship, $projects, $activities, $skills, $education);

    if ($stmt->execute()) {
        echo "Resume saved successfully!";
    } else {
        echo "Error saving resume.";
    }

    $stmt->close();
    $conn->close();
}
?>
