<?php
session_start();
header('Content-Type: application/json');

// Verifica se o usuário está logado
if (!isset($_SESSION['id_conta']) || $_SESSION['id_conta'] <= 0) {
    echo json_encode(['success' => false, 'message' => 'Você precisa estar logado para se inscrever.']);
    exit;
}

if (!isset($_POST['id_curso']) || !is_numeric($_POST['id_curso'])) {
    echo json_encode(['success' => false, 'message' => 'ID do curso inválido.']);
    exit;
}

include("include/connect.php");

$id_conta = $_SESSION['id_conta'];
$id_curso = intval($_POST['id_curso']);

// Verifica se já está inscrito
$query = "SELECT * FROM usuario_cursos WHERE id_conta = ? AND id_curso = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'ii', $id_conta, $id_curso);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(['success' => false, 'message' => 'Você já está inscrito neste curso.']);
    exit;
}

// Insere a inscrição
$query = "INSERT INTO usuario_cursos (id_conta, id_curso) VALUES (?, ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'ii', $id_conta, $id_curso);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao se inscrever no curso.']);
}

mysqli_close($con);
