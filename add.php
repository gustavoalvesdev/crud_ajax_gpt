<?php
include 'db.php';

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $conn->query("INSERT INTO records (name) VALUES ('$name')");
}
?>
