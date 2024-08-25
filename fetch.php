<?php
include 'db.php';

$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(id) AS id FROM records");
$custCount = $result->fetch_all(MYSQLI_ASSOC);
$total = $custCount[0]['id'];
$pages = ceil($total / $limit);

$query = $conn->query("SELECT * FROM records LIMIT $start, $limit");

$output = '';
$output .= '<table class="table table-bordered table-striped">';
$output .= '<thead><tr><th>ID</th><th>Nome</th><th>Ação</th></tr></thead>';
$output .= '<tbody>';

while ($row = $query->fetch_assoc()) {
    $output .= '<tr>';
    $output .= '<td>' . $row['id'] . '</td>';
    $output .= '<td>' . $row['name'] . '</td>';
    $output .= '<td>
                    <button onclick="editRecord(' . $row['id'] . ')" class="btn btn-info">Editar</button>
                    <button onclick="deleteRecord(' . $row['id'] . ')" class="btn btn-danger">Excluir</button>
                </td>';
    $output .= '</tr>';
}

$output .= '</tbody>';
$output .= '</table>';

$output .= '<nav>';
$output .= '<ul class="pagination justify-content-center">';

for ($i = 1; $i <= $pages; $i++) {
    $output .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="readRecords(' . $i . ')">' . $i . '</a></li>';
}

$output .= '</ul>';
$output .= '</nav>';

echo $output;
?>
