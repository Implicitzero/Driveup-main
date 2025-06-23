<?php
session_start();
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
    <link rel="stylesheet" href="css/review.css">

    <title>Avaliação</title>
   
</head>

<body>
  
    <?php

    if (isset($_GET['odd'])) {
        include("include/connect.php");

        $id_pedido = $_GET['odd'];

        $query = "select * from `detal_pedidos` where id_pedido = $id_pedido";
        $result = mysqli_query($con, $query);

        echo "<form method='post'> <table><thead>
    <tr>
        <th>Img</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Avaliação</th>
        <th>Classificação</th>
    </tr>
    </thead><tbody>";

    $row_number = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      // ...
      include("include/connect.php");

        $id_produto = $row['id_produto'];
        $query = "select * from produtos where id_produto = $id_produto";

        $result2 = mysqli_query($con, $query);

        $row2 = mysqli_fetch_assoc($result2);

        $img = $row2['img'];
        $produto_nome = $row2['produto_nome'];
        $preco = $row2['preco'];
      echo "
        <tr>
          <td>$produto_nome</td>
          <td><img src='product_images/$img' width='20px' height='20px' alt='Product 1'></td>
          <td>$preco</td>
          <td><input type='text' name='$id_produto-review'></td>
          <td>
            <fieldset class='rating'>
              <input type='radio' id='rating1' name='rating' value='1'><label for='rating1'></label>
              <input type='radio' id='rating2' name='rating' value='2'><label for='rating2'></label>
              <input type='radio' id='rating3' name='rating' value='3'><label for='rating3'></label>
              <input type='radio' id='rating4' name='rating' value='4'><label for='rating4'></label>
              <input type='radio' id='rating5' name='ratingr' value='5'><label for='rating5'></label>
            </fieldset>
          </td>
        </tr>";
      $row_number++;
    }
        echo"</tbody></table></form>";
    } 
    ?>

        <script src="script.js"></script>
</body>

</html>

<script>
  // Pegando todos os campos "rating" na página
  const ratingFields = document.querySelectorAll('.rating');

  // Loop acontecendo em cada campo "rating"
  ratingFields.forEach(ratingField => {
    // Pegando todas as estrelas no campo "rating"
    const stars = ratingField.querySelectorAll('input[type="radio"]');

    // Loop acontecendo em cada campo "star"
    stars.forEach(star => {
      // Evento de ouvir "click" nessa estrela
      star.addEventListener('click', function() {
        // Define a estrela clicada e todas as estrelas anteriores a ela para serem verificadas e preenchidas
        for (let i = 0; i < star.value; i++) {
          console.log('hello');
          stars[i].checked = true;
          stars[i].nextElementSibling.classList.add('checked');
        }

        // Define todas as estrelas após a estrela clicada ser desmarcada ou vazia
        for (let i = star.value; i < stars.length; i++) {
          stars[i].checked = false;
          console.log('hello');

          stars[i].nextElementSibling.classList.remove('checked');
        }
      });
    });
  });
</script>