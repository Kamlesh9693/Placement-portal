<?php
session_start();
session_destroy();
header("Location: ../index.php"); // or any other login/home page
exit();
?>
