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

    <link rel="stylesheet" href="style.css"/>

    <title>Drive Up - Cursos Gratuitos</title>

</head>

<body>
    <section class="header" id="header">
        <a href="index.php"><img src="img/banner/logofinal2.png" class="logo" alt="" width="100px"/></a>

        <div>
            <ul class="navbar" id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="cursos.php">Cursos</a></li>
                <li><a href="contato.php">Contato</a></li>

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

    <section id="page-header" class="courses-header">
        <h2></h2>
        <p style="color: white;"></p>

        <style>
            #page-header.courses-header {
             background-image: url('img/banner/backdenow.png');
             background-size: cover;
             background-position: center;
             width: 100vw;
             height: 100vh;
            }
        </style>
    </section>

    <section id="courses" class="section-p1">
    <h2>Conheça Nossos Cursos</h2>
    <p>Todos os nossos cursos são completamente gratuitos</p>
    
    <div class="course-container">
        <?php
        include("include/connect.php");
        
        // Consulta para obter os cursos do banco de dados
        $query = "SELECT * FROM cursos WHERE ativo = 1";
        $result = mysqli_query($con, $query);
        
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="course-box" data-course-id="<?= $row['id_curso'] ?>">
                    <div class="course-img">
                        <img src="img/cursos/<?= $row['imagem'] ?>" alt="<?= $row['nome_curso'] ?>">
                    </div>
                    <div class="course-details">
                        <h3><?= $row['nome_curso'] ?></h3>
                        <p><?= $row['descricao'] ?></p>
                        <div class="course-info">
                            <span><i class="fas fa-clock"></i> <?= $row['duracao'] ?> horas</span>
                            <span><i class="fas fa-user-graduate"></i> <?= $row['nivel'] ?></span>
                        </div>
                        <div class="course-badge">GRATUITO</div>
                        <?php if($_SESSION['id_conta'] < 0): ?>
                            <a href="cadastrar.php" class="normal">Cadastre-se para Acessar</a>
                        <?php else: ?>
                            <button class="normal">Saiba Mais</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Nenhum curso disponível no momento.</p>";
        }
        ?>
    </div>
</section>
        
    <section id="course-benefits" class="section-p1">
    <h2>Por que escolher nossos cursos?</h2>
    <div class="benefits-container">
        <!-- Benefício 1 -->
        <div class="benefit-box">
            <i class="fas fa-car-side"></i>
            <h3>Frota Moderna</h3>
            <p>Carros novos e bem equipados para seu aprendizado</p>
            <div class="free-badge">GRATUITO</div>
        </div>
        
        <!-- Benefício 2 -->
        <div class="benefit-box">
            <i class="fas fa-chalkboard-teacher"></i>
            <h3>Instrutores Qualificados</h3>
            <p>Profissionais experientes e pacientes</p>
            <div class="free-badge">GRATUITO</div>
        </div>
        
        <!-- Benefício 3 -->
        <div class="benefit-box">
            <i class="fas fa-clock"></i>
            <h3>Horários Flexíveis</h3>
            <p>Aulas nos horários que melhor se adaptam à sua rotina</p>
            <div class="free-badge">GRATUITO</div>
        </div>
        
        <!-- Benefício 4 -->
        <div class="benefit-box">
            <i class="fas fa-medal"></i>
            <h3>Alto Índice de Aprovação</h3>
            <p>Mais de 95% dos nossos alunos são aprovados</p>
            <div class="free-badge">SEM CUSTO</div>
        </div>
    </div>
</section>


<!-- Adicione estas bibliotecas no <head> -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.course-box').forEach(course => {
        course.addEventListener('click', function(e) {
            // Impede a ação se clicar no botão "Saiba Mais"
            if(e.target.closest('.normal')) return;
            
            const courseId = this.dataset.courseId;
            
            <?php if(isset($_SESSION['id_conta']) && $_SESSION['id_conta'] > 0): ?>
                // Usuário logado - faz a inscrição via AJAX
                fetch('inscrever_curso.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_curso=' + courseId
                })
                .then(response => {
                    if(!response.ok) {
                        throw new Error('Erro na rede');
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Inscrição realizada!',
                            text: 'Você agora está inscrito neste curso.',
                            confirmButtonText: 'Ver meus cursos',
                            showCancelButton: true,
                            cancelButtonText: 'Continuar navegando'
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location.href = 'profile.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ops...',
                            text: data.message || 'Erro ao se inscrever no curso'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Não foi possível completar a inscrição. Tente novamente.'
                    });
                    console.error('Erro:', error);
                });
            <?php else: ?>
                // Usuário não logado - redireciona para cadastro
                Swal.fire({
                    icon: 'info',
                    title: 'Cadastre-se primeiro',
                    text: 'Você precisa estar logado para se inscrever nos cursos.',
                    confirmButtonText: 'Fazer login',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed) {
                        window.location.href = 'cadastrar.php';
                    }
                });
            <?php endif; ?>
        });
    });
});
</script>

</html>