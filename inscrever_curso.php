<?php
session_start();
include("include/connect.php");

header('Content-Type: application/json');

if(!isset($_SESSION['id_conta']) || $_SESSION['id_conta'] < 0) {
    echo json_encode(['success' => false, 'message' => 'Você precisa estar logado']);
    exit();
}

$id_conta = $_SESSION['id_conta'];
$id_curso = $_POST['id_curso'];

// Verificar se já está inscrito
$checkQuery = "SELECT * FROM usuario_cursos WHERE id_conta = $id_conta AND id_curso = $id_curso";
$checkResult = mysqli_query($con, $checkQuery);

if(mysqli_num_rows($checkResult) > 0) {
    echo json_encode(['success' => false, 'message' => 'Você já está inscrito neste curso']);
    exit();
}

// Inscrever no curso
$insertQuery = "INSERT INTO usuario_cursos (id_conta, id_curso, status) VALUES ($id_conta, $id_curso, 'EM ANDAMENTO')";
$insertResult = mysqli_query($con, $insertQuery);

echo json_encode(['success' => $insertResult]);
?>