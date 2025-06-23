<?php
session_start();

if (isset($_POST['submit'])) {
  include("include/connect.php");
  $id_produto = $_GET['id_produto'];
  $id_conta = $_SESSION['id_conta'];
  $qtd = $_POST['qtd'];

  if ($id_conta < 0) {
    header("Location: login.php");
    exit();
  }

  $query = "select * from `carrinho`  where id_conta = $id_conta and id_produto = $id_produto";

  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    echo "<script> alert('Item já foi adicionado ao carrinho!') </script>";

    header("Location: carrinho.php");
    exit();
  } else {

    $query = "INSERT INTO `carrinho` (id_conta, id_produto, cqtd) values ($id_conta, $id_produto, $qtd)";
    $result = mysqli_query($con, $query);
    header("Location: shop.php");
    exit();
  }

}
if (isset($_GET['w'])) {
  include("include/connect.php");
  $id_conta = $_SESSION['id_conta'];
  if ($id_conta < 0) {
    header("Location: login.php");
    exit();
  }
  $id_produto = $_GET['w'];

  $query = "INSERT INTO `WISHLIST` (id_conta, id_produto) values ($id_conta, $id_produto)";

  $result = mysqli_query($con, $query);
  header("Location: sproduct.php?id_produto=$id_produto");
  exit();
}
if (isset($_GET['nw'])) {
  include("include/connect.php");
  $id_conta = $_SESSION['id_conta'];
  $id_produto = $_GET['nw'];

  $query = "DELETE from `WISHLIST` where id_conta = $id_conta and id_produto = $id_produto";

  $result = mysqli_query($con, $query);
  header("Location: sproduct.php?id_produto=$id_produto");
  exit();
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
  <link rel="stylesheet" href="css/sproduct.css">

  <title>Encanto Manual</title>


</head>

<body>
  <section class="header" id="header">
    <a href="index.php"><img src="img/em-logo.png" class="logo" alt="" width="100px"/></a>

    <div>
      <ul class="navbar" id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="shop.php">Produtos</a></li>
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
        <li><a href="admin.php">Admin</a></li>
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

  <?php
  include("include/connect.php");

  if (isset($_GET['id_produto'])) {
    $id_produto = $_GET['id_produto'];
    $query = "SELECT* FROM produtos WHERE id_produto = $id_produto";

    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $id_produtod = $row['id_produto'];
    $produto_nome = $row['produto_nome'];

    $desc = $row['descricao'];
    $qtd = $row['qtdavali'];
    $preco = $row['preco'];
    $cat = $row['categoria'];
    $img = $row['img'];
    $marca = $row['marca'];

    $id_conta = $_SESSION['id_conta'];
    $query = "select * from wishlist where id_conta = $id_conta and id_produto = $id_produto";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);


    echo "
      <section id='prodetails' class='section-p1'>
        <div class='single-pro-image'>
          <img src='product_images/$img' width='100%' id='MainImg' alt=' ' />
        </div>
        <div class='single-pro-details'>
        
          <h2>$produto_nome</h2>
          <h4>$cat - $marca</h4>
          <h4>R$$preco</h4>
          <form method='post'>
          <input type='number' name='qtd' value='1' min='1' max='$qtd'/>
          <button class='normal' name='submit'>Adicionar ao Carrinho</button>";

    if ($row)
      echo "<a  class ='heart' href='sproduct.php?nw=$id_produto'><img src='img/full.png' style='
            margin: auto; width='40px' height='40px'   alt=' ' /></a>";
    else
      echo "<a class ='heart' href='sproduct.php?w=$id_produto'><img src='img/empty.png' style='
            margin: auto; ' width='40px' height='40px'  alt=' ' /></a>";

            echo "
            </form>
            <h4>Detalhes do Produto</h4>
            <span>$desc
            </span>";

   

  echo "</div></section>";
}

$query = "select * from reviews join pedidos on reviews.id_pedido = pedidos.id_pedido join contas on pedidos.id_conta = contas.id_conta where reviews.id_produto = $id_produto";
$result = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($result);

if (!empty($row))
{
  $result = mysqli_query($con, $query);

echo "
<div class = 'rev'>
<h2>Avaliações</h2>
<div class='tb'>
<table><thead><tr><th>Usuário</th>
<th style='min-width: 100px;'>Classificação</th>
<th>Avaliação</th></thead><tbody>";

while ($row = mysqli_fetch_assoc($result)) {
  $user = $row['username'];
  $texto_avalia = $row['texto_avalia'];
  $stars = $row['rating'];

  $empty = 5 - $stars;

  echo "<tr><td>$user</td>
           
            <td style='min-width: 200px;'><div class='star' >";
  for ($i = 1; $i <= $stars; $i++) {
    echo "<i class='fas fa-star'></i>";

  }
  for ($i = 1; $i <= $empty; $i++) {
    echo "<i class='far fa-star'></i>";

  }
  echo "</div></td>
            <td><span>$texto_avalia<span></td></tr>";
}

echo "</tbody></table></div></div>";

}
  ?>


<div class="section-divider"></div>
<footer class="section-p1">
    <div class="col">
        <img class="logo" src="img/em-logo.png" width="100px" alt="Encanto Manual Logo" />
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
        <a href="carrinho.php">Meu carrinho</a>
        <a href="wishlist.php">Lista de desejos</a>
        <a href="profile.php">Perfil</a>
    </div>

    <div class="col install">
        <h4>Formas de Pagamento</h4>
        <p>Oferecemos várias opções para você:</p>
        <img src="img/pay/pay.png" alt="Formas de pagamento" />
    </div>

    <div class="copyright">
        <p>&copy; 2024 Encanto Manual. Todos os direitos reservados.</p>
    </div>
</footer>


  <script>
    var MainImg = document.getElementById("MainImg");
    var smallimg = document.getElementsByClassName("small-img");

    smallimg[0].onclick = function () {
      MainImg.src = smallimg[0].src;
    };
    smallimg[1].onclick = function () {
      MainImg.src = smallimg[1].src;
    };
    smallimg[2].onclick = function () {
      MainImg.src = smallimg[2].src;
    };
    smallimg[3].onclick = function () {
      MainImg.src = smallimg[3].src;
    };
  </script>
  <script src="script.js"></script>
</body>

</html>

<script>
    window.addEventListener("unload", function () {
      // Chamando script PHP para faezr logout de usuário
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "logout.php", false);
      xhr.send();
    });
  </script>