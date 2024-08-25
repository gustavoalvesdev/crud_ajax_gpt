<?php
include 'db.php';

if (isset($_POST['id']) && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $conn->query("UPDATE records SET name = '$name' WHERE id = $id");
} else if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $result = $conn->query("SELECT * FROM records WHERE id = $id");
    $row = $result->fetch_assoc();
    echo json_encode($row);
}
?>
