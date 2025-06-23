<?php
session_start();
header('Content-Type: application/json');
include("include/connect.php");

if (!isset($_SESSION['id_conta']) || $_SESSION['id_conta'] <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Você precisa estar logado para se inscrever.'
    ]);
    exit;
}

$id_conta = intval($_SESSION['id_conta']);
$id_curso = isset($_POST['id_curso']) ? intval($_POST['id_curso']) : 0;

if ($id_curso <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID do curso inválido.'
    ]);
    exit;
}

// Verificar se o curso existe e está ativo
$checkCurso = mysqli_query($con, "SELECT id_curso FROM cursos WHERE id_curso = $id_curso AND ativo = 1");
if (mysqli_num_rows($checkCurso) == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Curso não encontrado ou está inativo.'
    ]);
    exit;
}

// Verificar se já está inscrito
$checkInscricao = mysqli_query($con, "SELECT * FROM usuario_cursos WHERE id_conta = $id_conta AND id_curso = $id_curso");
if (mysqli_num_rows($checkInscricao) > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Você já está inscrito neste curso.'
    ]);
    exit;
}

// Inserir a inscrição
$insert = mysqli_query($con, "INSERT INTO usuario_cursos (id_conta, id_curso) VALUES ($id_conta, $id_curso)");

if ($insert) {
    echo json_encode([
        'success' => true
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao realizar inscrição. Tente novamente.'
    ]);
}
