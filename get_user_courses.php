<?php
session_start();
include("include/connect.php");

header('Content-Type: application/json');

if(!isset($_SESSION['id_conta'])) {
    echo json_encode([]);
    exit();
}

$id_conta = $_SESSION['id_conta'];
$query = "SELECT c.*, uc.data_inscricao, uc.status 
          FROM cursos c
          JOIN usuario_cursos uc ON c.id_curso = uc.id_curso
          WHERE uc.id_conta = $id_conta
          ORDER BY uc.data_inscricao DESC";

$result = mysqli_query($con, $query);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($courses);
?>