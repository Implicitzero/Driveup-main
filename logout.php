<?php
include("include/connect.php");
session_start();
// Aqui executa a ação desejada
$id_conta = $_SESSION['id_conta'];
$query = "DELETE FROM carrinho WHERE id_conta = $id_conta";

$result = mysqli_query($con, $query);
$_SESSION['id_conta'] = -1;

$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona o usuário para a página de login ou home
header("Location: login.php");
?>