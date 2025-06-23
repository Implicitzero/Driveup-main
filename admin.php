<?php
session_start();
include("include/connect.php");

if (isset($_POST['submit'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username == "admin1") {

    $query = "select * from contas where username='$username' and password='$password'";
    $result = mysqli_query($con, $query);


    if (mysqli_num_rows($result) > 0) {
      echo "<script> window.open('inventory.php', '_blank') </script>";


    } else {
      echo "<script> alert('Nome de usuário ou senha incorretos!') </script>";
    }

  } else {
    echo "<script> alert('Nome de usuário ou senha incorretos!') </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>

    <link rel="stylesheet" href="style.css"/>

    <title>Login - Drive Up</title>

</head>

<body>
    <section class="header" id="header">
        <a href="index.php"><img src="img/banner/logofinal2.png" class="logo" alt="" width="100px" /></a>

        <div>
            <ul class="navbar" id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="cursos.php">Cursos</a></li>
                <li><a href="contato.php">Contato</a></li>

        <?php

        if ($_SESSION['id_conta'] < 0) {
          echo "   <li><a href='login.php'>Login</a></li>
            <li><a href='cadastrar.php'>Cadastre-se</a></li>
            ";
        } else {
          echo "   <li><a href='profile.php'>Perfil</a></li>
          ";
        }
        ?>
                <li><a class="active" href="admin.php">Admin</a></li>
                <li id="lg-bag">
                    <a href="carrinho.php"><i class="far fa-shopping-bag"></i></a>
                </li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div class="mobile" id="mobile">
            <a href="carrinho.php"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>


    <form method="post" id="form">
        <h3 style="color: darkred; margin: auto"></h3>
        <input class="input1" id="user" name="username" type="text" placeholder="Nome de usuário *">
        <input class="input1" id="pass" name="password" type="password" placeholder="Senha *">
        <button type="submit" class="btn" name="submit">Entrar</button>

    </form>


    <div class="section-divider"></div>
<footer class="section-p1">
    <div class="col">
        <img class="logo" src="img/banner/logofinal2.png" width="100px" alt="Encanto Manual Logo" />
        <h4>Contato</h4>
        <p><strong>Endereço:</strong> Av. Cesário de Melo</p>
        <p><strong>Telefone:</strong> +55 (21) 99604-5109</p>
        <p><strong>Horário:</strong> 9:00 - 17:00</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>

    <div class="col">
        <h4>Minha conta</h4>
        <a href="profile.php">Perfil</a>
    </div>

    <div class="copyright">
        <p>&copy; 2025 Drive Up. Todos os direitos reservados.</p>
    </div>
</footer>

    <script src="script.js"></script>
</body>

</html>