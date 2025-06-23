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

    <title>Sobre nós</title>

    <style>
    .paragraph {
        line-height: 1.5;
    }
    </style>


</head>

<body>
    <section class="header" id="header">
        <a href="index.php"><img src="img/em-logo.png" class="logo" alt="" width="100px"/></a>

        <div>
            <ul class="navbar" id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Produtos</a></li>
                <li><a class="active" href="sobre.php">Sobre</a></li>
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

    <section id="page-header" class="about-header">
        <h2>O encanto que realmente é manual.</h2>

        <p style="color: white;">Arte feita a mão para você!</p>

        
    <style>
        #page-header.about-header {
        background-image: url("img/banner/banner006.jpg");
        }

        #about-head {
        display: flex;
        align-items: center;
        }

        #about-head img {
        width: 50%;
        height: auto;
        }

        #about-head div {
        padding-left: 40px;
        }
    </style>    
    </section>

    <section id="about-head" class="section-p1">
        <img src="img/banner/banner003.jpg" alt="" />
        <div>
            <h2>Sobre nós</h2>
            <p class="paragraph">
                Criando uma ponte entre artesãos talentosos e consumidores que valorizam o trabalho manual e o design autêntico. Aqui, cada peça conta uma história única, feita com dedicação por mãos habilidosas. Queremos fortalecer essa conexão, proporcionando um espaço onde a arte e o consumo consciente se encontram, promovendo a valorização do feito à mão e o impacto positivo na sociedade.
            </p>
            <br /><br />
        
        </div>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="" />
            <h6>Frete grátis</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="" />
            <h6>Peça online</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f3.png" alt="" />
            <h6>Economize</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f4.png" alt="" />
            <h6>Promoções</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f5.png" alt="" />
            <h6>Boa venda</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f6.png" alt="" />
            <h6>Suporte 24/7</h6>
        </div>
    </section>

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

<style>
    /* Linha divisória entre conteúdo e rodapé */
.section-divider {
  width: 100%;
  height: 2px;
  background-color: #e0e0e0; /* Linha divisória sutil */
  margin: 20px 0;
}

/* Estilos do rodapé */
footer {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 40px 20px;
  background-color: #333; /* Fundo escuro para o rodapé */
  color: #fff; /* Texto claro */
}

footer .col {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 20px;
  flex: 1 1 200px; /* Ajusta as colunas automaticamente */
}

footer .logo {
  margin-bottom: 20px;
}

footer h4 {
  font-size: 16px;
  color: #ff523b; /* Destaque nos títulos */
  margin-bottom: 15px;
}

footer a {
  font-size: 13px;
  color: #bbb; /* Links claros */
  margin: 0 0 8px;
  text-decoration: none;
}

footer a:hover {
  color: #ff523b; /* Efeito hover nos links */
}

footer p {
  font-size: 13px;
  margin: 0 0 8px;
}

.social-icons a {
  display: inline-block;
  width: 30px;
  height: 30px;
  margin-right: 8px;
  color: #ff523b;
  text-align: center;
  line-height: 30px;
  font-size: 14px;
  border: 1px solid #ff523b;
  border-radius: 50%;
}

.social-icons a:hover {
  color: #333;
  background-color: #ff523b;
}

/* Área de direitos autorais */
footer .copyright {
  width: 100%;
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid #444;
  margin-top: 20px;
  font-size: 12px;
  color: #bbb;
}

/* Responsividade */
@media (max-width: 768px) {
  footer {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  footer .col {
    align-items: center;
  }

  .social-icons a {
    margin: 5px;
  }
}

</style>

    <script src="script.js"></script>
</body>

</html>

<script>
window.addEventListener("unload", function() {
  // Call a PHP script to log out the user
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>