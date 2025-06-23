<?php
session_start();


if (isset($_GET['lo'])) {
  $_SESSION['id_conta'] = -1;
  header("Location: index.php");
  exit();

}

if (isset($_POST['submit'])) {
  include("include/connect.php");
  $id_conta = $_SESSION['id_conta'];

  $nome = $_POST['a1'];
  $sobrenome = $_POST['a2'];
  $email = $_POST['a3'];
  $cpf = $_POST['a4'];
  $contato = $_POST['a5'];
  $data_nasc = $_POST['a6'];
  $password = $_POST['a7'];

  $query = "select * from contas where (cpf='$cpf' or contato='$contato' or email='$email') and id_conta != $id_conta ";

  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  if (!empty($row['id_conta'])) {
    echo "<script> alert('Essa conta já existe!'); setTimeout(function(){ window.location.href = 'profile.php'; }, 10); </script>";
    exit();
  }
  if (strtotime($data_nasc) > time()) {
    echo "<script> alert('Data inválida!'); setTimeout(function(){ window.location.href = 'profile.php'; }, 10); </script>";
    exit();
  }
  if (preg_match('/\D/', $cpf) || strlen($cpf) < 11) {
    echo "<script> alert('CPF inválido!'); setTimeout(function(){ window.location.href = 'profile.php'; }, 10); </script>";
    exit();
  }
  if (preg_match('/\D/', $contato) || strlen($contato) < 11) {
    echo "<script> alert('Número de contato inválido. Número deve conter 11 dígitos!'); setTimeout(function(){ window.location.href = 'profile.php'; }, 10); </script>";
    exit();
  }
  if ($password < 8) {
    echo "<script> alert('Senha muito curta. Sua senha deve ter no mínimo 8 caracteres!'); setTimeout(function(){ window.location.href = 'cadastrar.php'; }, 100); </script>";
    exit();
  }

  $query = "UPDATE contas SET nome = '$nome', sobrenome='$sobrenome', email='$email', contato='$contato', cpf='$cpf', data_nasc='$data_nasc', password='$password' WHERE id_conta = $id_conta";

  $result = mysqli_query($con, $query);
  header("Location: profile.php");
  exit();
}


if (isset($_POST['abc'])) {
  include("include/connect.php");

  $id_pedido = $_GET['odd'];

  $query = "select * from `detal_pedidos` where id_pedido = $id_pedido";
  $result = mysqli_query($con, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    include("include/connect.php");

    $id_produto = $row['id_produto'];


    $text = $_POST["$id_produto-te"];
    $star = $_POST["$id_produto-rating"];
    $query;
    if (empty($text))
      $query = "insert into `reviews` (id_pedido, id_produto, texto_avalia, rating) values ($id_pedido, $id_produto, NULL, $star)";
    else
      $query = "insert into `reviews` (id_pedido, id_produto, texto_avalia, rating) values ($id_pedido, $id_produto, '$text', $star)";


    $result2 = mysqli_query($con, $query);
  }

  header("Location: profile.php");
  exit();
}

if (isset($_GET['c'])) {
  header("Location: profile.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="css/profile.css">
    <title>Perfil - Drive Up</title>
    <style>
        /* Estilos anteriores permanecem */
        
        /* Novos estilos para botões */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 20px;
        }
        
        .action-btn {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-btn i {
            font-size: 1rem;
        }
        
        .btn-home {
            background-color: #088178;
        }
        
        .btn-home:hover {
            background-color: #066a63;
        }
        
        .btn-courses {
            background-color: #4CAF50;
        }
        
        .btn-courses:hover {
            background-color: #3e8e41;
        }
        
        .btn-contact {
            background-color: #2196F3;
        }
        
        .btn-contact:hover {
            background-color: #0b7dda;
        }
        
        .btn-logout {
            background-color: #f44336;
        }
        
        .btn-logout:hover {
            background-color: #d32f2f;
        }
        
        /* Melhorias na exibição dos dados */
        .profile-data table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .profile-data td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-data td:first-child {
            font-weight: 600;
            width: 30%;
        }
        
        .profile-data tr:last-child td {
            border-bottom: none;
        }
        /* SEÇÃO MEUS CURSOS */
.card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
    margin-bottom: 40px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.card-body {
    padding: 30px;
}

h2 {
    color: #2c3e50;
    font-size: 28px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f1f1;
    position: relative;
}

h2::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, #088178, #4CAF50);
}

/* GRADE DE CURSOS */
.course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-top: 20px;
}

/* CARD DE CURSO */
.course-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid #f0f0f0;
    position: relative;
}

.course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border-color: rgba(8, 129, 120, 0.2);
}

/* IMAGEM DO CURSO */
.course-img {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.course-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.course-card:hover .course-img img {
    transform: scale(1.08);
}

/* CONTEÚDO DO CURSO */
.course-content {
    padding: 22px;
}

.course-title {
    font-size: 1.25rem;
    margin-bottom: 12px;
    color: #2c3e50;
    font-weight: 600;
    line-height: 1.4;
}

.course-content p {
    color: #7f8c8d;
    font-size: 0.95rem;
    margin-bottom: 20px;
    line-height: 1.5;
}

/* META INFORMAÇÕES */
.course-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.course-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.9rem;
    color: #666;
}

.course-meta i {
    color: #088178;
}

.course-status {
    background-color: #4CAF50;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* BOTÃO ASSISTIR AULA */
.watch-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: linear-gradient(135deg, #088178 0%, #066a63 100%);
    color: white;
    padding: 12px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
    margin-top: 15px;
}

.watch-btn i {
    transition: transform 0.3s ease;
}

.watch-btn:hover {
    background: linear-gradient(135deg, #066a63 0%, #055a54 100%);
    box-shadow: 0 5px 15px rgba(8, 129, 120, 0.3);
}

.watch-btn:hover i {
    transform: translateX(3px);
}

/* MENSAGEM SEM CURSOS */
.card-body > p {
    text-align: center;
    color: #7f8c8d;
    font-size: 1.1rem;
    padding: 30px 0;
}

.card-body > p a {
    color: #088178;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 1px dashed #088178;
}

.card-body > p a:hover {
    color: #055a54;
    border-bottom-style: solid;
}

/* RESPONSIVIDADE */
@media (max-width: 1024px) {
    .course-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 30px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    h2 {
        font-size: 24px;
    }
    
    .course-img {
        height: 180px;
    }
}

@media (max-width: 480px) {
    .course-grid {
        grid-template-columns: 1fr;
    }
    
    .card-body {
        padding: 15px;
    }
    
    .course-content {
        padding: 18px;
    }
}

        
    </style>
</head>

<body>
    <section class="header" id="header">
        <a href="index.php"><img src="img/banner/logofinal2.png" class="logo" alt="" width="100px"/></a>
        <div>
            <ul class="navbar" id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="cursos.php">Cursos</a></li>
                <li><a href="contato.php">Contato</a></li>
                <?php if ($_SESSION['id_conta'] < 0): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="cadastrar.php">Cadastre-se</a></li>
                <?php else: ?>
                    <li><a class="active" href="profile.php">Perfil</a></li>
                <?php endif; ?>
                <li><a href="admin.php">Admin</a></li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div class="mobile" id="mobile">
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <div class="profile-container">
        <!-- Menu Lateral -->
        <div class="sidenav">
            <div class="profile">
                <img src="img/people/user.png" alt="" width="100" height="100">
                <?php
                include("include/connect.php");
                $id_conta = $_SESSION['id_conta'];
                $query = "SELECT * FROM contas WHERE id_conta = $id_conta";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
                
                $nome = $row['nome'];
                $sobrenome = $row['sobrenome'];
                $name = $nome . " " . $sobrenome;
                ?>
                
                <div class="name"><?= $name ?></div>
                <div class="job">Cliente</div>
            </div>
            
            <div class="action-buttons">
                <a href="index.php" class="action-btn btn-home">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="cursos.php" class="action-btn btn-courses">
                    <i class="fas fa-book"></i> Cursos
                </a>
                <a href="contato.php" class="action-btn btn-contact">
                    <i class="fas fa-envelope"></i> Contato
                </a>
                <a href="profile.php?lo=1" class="action-btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>
            </div>
            
            <div class="sidenav-url">
                <div class="url">
                    <a href='profile.php?upd=1' class="btn logup">Atualizar Dados</a>
                    <hr align="center">
                </div>
                <?php if (isset($_GET['odd'])): ?>
                    <div class="url">
                        <a href='profile.php' class='btn logup'>Cancelar</a>
                        <hr align="center">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="main">
            <h2>Dados Pessoais</h2>
            <div class="card">
                <div class="card-body profile-data">
                    <?php if (isset($_GET['upd'])): ?>
                        <!-- Formulário de atualização -->
                        <form class='form1' method='post'>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Nome</td>
                                        <td>:</td>
                                        <td><input name='a1' type='text' value='<?= $row['nome'] ?>'></td>
                                    </tr>
                                    <tr>
                                        <td>Sobrenome</td>
                                        <td>:</td>
                                        <td><input name='a2' type='text' value='<?= $row['sobrenome'] ?>'></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><input name='a3' type='text' value='<?= $row['email'] ?>'></td>
                                    </tr>
                                    <tr>
                                        <td>CPF</td>
                                        <td>:</td>
                                        <td><input name='a4' type='text' value='<?= $row['cpf'] ?>' maxlength='11'></td>
                                    </tr>
                                    <tr>
                                        <td>Celular</td>
                                        <td>:</td>
                                        <td><input name='a5' type='text' value='<?= $row['contato'] ?>' maxlength='11'></td>
                                    </tr>
                                    <tr>
                                        <td>Data de nascimento</td>
                                        <td>:</td>
                                        <td><input name='a6' type='date' value='<?= $row['data_nasc'] ?>'></td>
                                    </tr>
                                    <tr>
                                        <td>Senha</td>
                                        <td>:</td>
                                        <td><input name='a7' type='password' value='<?= $row['password'] ?>'></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button name='submit' type='submit' class='btn-submit'>Salvar Alterações</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    <?php else: ?>
                        <!-- Exibição dos dados -->
                        <table>
                            <tbody>
                                <tr>
                                    <td>Nome</td>
                                    <td>:</td>
                                    <td><?= $row['nome'] ?></td>
                                </tr>
                                <tr>
                                    <td>Sobrenome</td>
                                    <td>:</td>
                                    <td><?= $row['sobrenome'] ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td><?= $row['email'] ?></td>
                                </tr>
                                <tr>
                                    <td>CPF</td>
                                    <td>:</td>
                                    <td><?= $row['cpf'] ?></td>
                                </tr>
                                <tr>
                                    <td>Celular</td>
                                    <td>:</td>
                                    <td><?= $row['contato'] ?></td>
                                </tr>
                                <tr>
                                    <td>Data de Nascimento</td>
                                    <td>:</td>
                                    <td><?= date('d/m/Y', strtotime($row['data_nasc'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Nome de Usuário</td>
                                    <td>:</td>
                                    <td><?= $row['username'] ?></td>
                                </tr>
                                <tr>
                                    <td>Gênero</td>
                                    <td>:</td>
                                    <td><?= $row['genero'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Seção de Cursos (permanece igual) -->
            <?php if (!isset($_GET['odd'])): ?>
                <h2>Meus Cursos</h2>
                <div class="card">
                    <div class="card-body">
                        <?php
                        $query = "SELECT c.*, uc.data_inscricao 
                                  FROM cursos c
                                  JOIN usuario_cursos uc ON c.id_curso = uc.id_curso
                                  WHERE uc.id_conta = $id_conta
                                  ORDER BY uc.data_inscricao DESC";
                        
                        $result = mysqli_query($con, $query);
                        
                        if(mysqli_num_rows($result) > 0): ?>
                            <div class="course-grid">
                                <?php while($course = mysqli_fetch_assoc($result)): ?>
                                    <div class="course-card">
                                        <div class="course-img">
                                            <img src="img/cursos/<?= $course['imagem'] ?>" alt="<?= $course['nome_curso'] ?>">
                                        </div>
                                        <div class="course-content">
                                            <h3 class="course-title"><?= $course['nome_curso'] ?></h3>
                                            <p><?= substr($course['descricao'], 0, 100) ?>...</p>
                                            <div class="course-meta">
                                                <span><i class="fas fa-clock"></i> <?= $course['duracao'] ?>h</span>
                                                <span class="course-status">EM ANDAMENTO</span>
                                            </div>
                                            <a href="<?= $course['link_video'] ?>" target="_blank" class="watch-btn">
                                                <i class="fas fa-play"></i> Assistir Aula
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>Você ainda não está inscrito em nenhum curso. <a href="cursos.php">Explore nossos cursos</a></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="section-p1">
        <!-- ... (código do footer permanece igual) -->
    </footer>

    <!-- Scripts (permanecem iguais) -->
    <script src="script.js"></script>
    <script>
    // Sistema de avaliação por estrelas
    function bruh(param) {
        const ratingFields = document.querySelectorAll('#a-' + param + '-rating');
        ratingFields.forEach(ratingField => {
            const stars = ratingField.querySelectorAll('input[type="radio"]');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    for (let i = 0; i < star.value; i++) {
                        stars[i].checked = true;
                        stars[i].nextElementSibling.classList.add('checked');
                    }
                    for (let i = star.value; i < stars.length; i++) {
                        stars[i].checked = false;
                        stars[i].nextElementSibling.classList.remove('checked');
                    }
                });
            });
        });
    }
    
    // Logout ao sair da página
    window.addEventListener("unload", function() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "logout.php", false);
        xhr.send();
    });
    </script>
</body>
</html>

<script>
window.addEventListener("unload", function() {
  // Chamando o script PHP para fazer logout
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "logout.php", false);
  xhr.send();
});
</script>