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

    <title>Drive Up</title>

</head>

<body>
    <section class="header" id="header">
        <a href="index.php"><img src="img/banner/logofinal2.png" class="logo" alt="" width="100px"/></a>

        <div>
            <ul class="navbar" id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="cursos.php">Cursos</a></li>
                <li><a class="active" href="contato.php">Contato</a></li>

                <?php

                if ($_SESSION['id_conta'] < 0) {
                    echo "<li><a href='login.php'>Login</a></li>
                          <li><a href='cadastrar.php'>Cadastre-se</a></li>";
                } else {
                    echo "<li><a href='profile.php'>Perfil</a></li>";
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

    <section id="page-header" class="contact-header">
        <h2></h2>

        <p style="color: white;"></p>


       <style>
        #page-header.contact-header {
    background-image: url('img/banner/backdenow.png');
    background-size: cover;        /* Preenche tudo, pode cortar um pouco mas sem distorcer */
    background-position: center;   /* Centraliza a imagem */
    background-repeat: no-repeat;  

    width: 100vw;                  /* Ocupa toda a largura da tela */
    height: 100vh;                  /* Altura proporcional à tela */

    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;

    padding: 14px;
    margin: 0;
        }

       @media (max-width: 768px) {
    #page-header.contact-header {
        height: 30vh;
        padding: 10px;
    }
}

@media (max-width: 480px) {
    #page-header.contact-header {
        height: 25vh;
        padding: 8px;
    }
}
    </style>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>ENTRE EM CONTATO</span>
            <h2>Trabalhe Conosco.</h2>
            <h3>Escritório</h3>
            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p>Av. Cesário de Melo, 2541 - Campo Grande, RJ</p>
                </li>
                <li>
                    <i class="fal fa-envelope"></i>
                    <p>contato@driveup.com</p>
                </li>
                <li>
                    <i class="fal fa-clock"></i>
                    <p>Segunda a Sexta: de 9:00 às 17:00</p>

                </li>
            </div>
        </div>

        <!-- Mapa -->
        <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29404.555971131915!2d-43.57742900579539!3d-22.89235624397002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9be156be65514f%3A0xe57df8ce04f7494e!2sUniversidade%20Augusto%20Motta%20-%20Rio%20de%20Janeiro%20(Campo%20Grande)%20-%20Unidade%20I!5e0!3m2!1spt-BR!2sbr!4v1731349340289!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <div class="people">
            <div>
                <img src="" alt="Sem imagem" />
                <p>
                    <span>Ana Beatriz Monteiro</span>  </br>
                    Email:Anabeatrizg@gmail.com
                </p>
            </div>
            <div>
                <img src="" alt="Sem imagem" />
                <p>
                    <span>Ana caroline Figueira Paulino Pereira</span>  </br>
                    Email: anacm@gmail.com
                </p>
            </div>
            <div>
                <img src="img/people/gabriel.jpg" alt="Sem imagem" />
                <p>
                    <span>Gabriel Sismil</span> </br>
                    Email: Gabriel@gmail.com
                </p>
            </div>

            <div>
                <img src="" alt="Sem imagem" />
                <p>
                    <span>Lucas Cunha Medeiros</span>  <br />
                    Email: LucasCM@gmail.com
                </p>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>
<footer class="section-p1">
    <div class="col">
        <img class="logo" src="img/banner/logofinal2.png" width="100px" alt="Drive Up Logo" />
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

</html>

<script>
window.addEventListener("unload", function() {
  // Chamando o script PHP para fazer logout de usuário
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>