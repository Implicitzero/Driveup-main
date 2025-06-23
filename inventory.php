<?php
include("include/connect.php");

// Função para inserir cursos
if (isset($_POST['ins'])) {
    $nome_curso = mysqli_real_escape_string($con, $_POST['name']);
    $categoria = mysqli_real_escape_string($con, $_POST['categoria']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $duracao = (int)$_POST['duracao'];
    $link_video = mysqli_real_escape_string($con, $_POST['link_video']);
    
    // Processamento da imagem
    $image = $_FILES['photo']['name'];
    $temp_image = $_FILES['photo']['tmp_name'];
    $target_dir = "img/cursos/"; // Alterado para coincidir com a página de cursos
    
    if(move_uploaded_file($temp_image, $target_dir.$image)) {
        $query = "INSERT INTO `cursos` (nome_curso, categoria, descricao, duracao, link_video, imagem) 
                  VALUES ('$nome_curso', '$categoria', '$descricao', $duracao, '$link_video', '$image')";
        
        $result = mysqli_query($con, $query);
        
        if ($result) {
            echo "<script>alert('Curso cadastrado com sucesso!')</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar curso: ".mysqli_error($con)."')</script>";
        }
    } else {
        echo "<script>alert('Erro ao enviar imagem')</script>";
    }
}

// Função para deletar cursos
if (isset($_GET['id_curso'])) {
    $id = (int)$_GET['id_curso'];
    $query = "DELETE FROM cursos WHERE id_curso = $id";
    if(mysqli_query($con, $query)) {
        echo "<script>alert('Curso removido com sucesso!')</script>";
    } else {
        echo "<script>alert('Erro ao remover curso')</script>";
    }
    echo "<script>window.location.href='inventory.php'</script>";
    exit();
}

// Função para atualizar cursos
if (isset($_POST['submitt'])) {
    $id_curso = (int)$_POST['id_curso1'];
    $nome_curso = mysqli_real_escape_string($con, $_POST['name1']);
    $categoria = mysqli_real_escape_string($con, $_POST['categoria1']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao1']);
    $duracao = (int)$_POST['duracao1'];
    $link_video = mysqli_real_escape_string($con, $_POST['link_video1']);
    
    if(!empty($_FILES['photo1']['name'])) {
        $image = $_FILES['photo1']['name'];
        $temp_image = $_FILES['photo1']['tmp_name'];
        move_uploaded_file($temp_image, "img/cursos/".$image);
    } else {
        $image = $_POST['prevphoto'];
    }
    
    $query = "UPDATE `cursos` SET 
              nome_curso = '$nome_curso', 
              categoria = '$categoria', 
              descricao = '$descricao', 
              duracao = $duracao, 
              link_video = '$link_video', 
              imagem = '$image' 
              WHERE id_curso = $id_curso";
    
    $result = mysqli_query($con, $query);
    
    if ($result) {
        echo "<script>alert('Curso atualizado com sucesso!')</script>";
        echo "<script>window.location.href='inventory.php'</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar curso')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Drive Up</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <style>
        :root {
            --driveup-orange: #F48C2B;
            --driveup-blue: #23456A;
            --light: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container1, .container11 {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1, h2 {
            color: var(--driveup-blue);
            border-bottom: 3px solid var(--driveup-orange);
            padding-bottom: 10px;
            margin-top: 0;
        }
        
        form {
            margin-bottom: 30px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        
        label {
            display: block;
            margin: 15px 0 5px;
            color: var(--driveup-blue);
            font-weight: 600;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        button, .insert-btn {
            background-color: var(--driveup-orange);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
            transition: background 0.3s;
        }
        
        button:hover, .insert-btn:hover {
            background-color: #e07d1f;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }
        
        th {
            background-color: var(--driveup-blue);
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f1f1f1;
        }
        
        img.curso-img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
            display: block;
        }
        
        .action-btn {
            padding: 8px 12px;
            font-size: 14px;
            margin: 0 5px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
        
        .delete-btn {
            background-color: #dc3545;
        }
        
        .edit-btn {
            background-color: var(--driveup-blue);
        }
        
        .search-container {
            background: var(--light);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container1">
        <div class="form-container">
            <h2>Cadastrar Novo Curso</h2>
            <form id="insert-form" action="inventory.php" enctype="multipart/form-data" method="post">
                <label for="name">Nome do Curso:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione...</option>
                    <option value="Básico">Curso Básico</option>
                    <option value="Avançado">Curso Avançado</option>
                    <option value="Especialização">Especialização</option>
                </select>
                
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="3" required></textarea>
                
                <label for="duracao">Duração (horas):</label>
                <input type="number" id="duracao" name="duracao" min="1" required>
                
                <label for="link_video">Link do Vídeo:</label>
                <input type="url" id="link_video" name="link_video" required>
                
                <label for="photo">Imagem do Curso:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
                
                <button name="ins" type="submit" class="insert-btn">Cadastrar Curso</button>
            </form>
        </div>
        
        <div class="search-container">
            <h2>Gerenciar Cursos</h2>
            <form id="search-form" action="inventory.php" method="get">
                <label for="search">Buscar Curso:</label>
                <input type="text" id="search" name="search" placeholder="Digite o nome do curso...">
                <button type="submit" class="insert-btn">Buscar</button>
                <a href="inventory.php" class="action-btn" style="background-color: #6c757d;">Limpar</a>
            </form>
            
            <div class="inventory-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Curso</th>
                            <th>Categoria</th>
                            <th>Duração</th>
                            <th>Status</th>
                            <th>Imagem</th>
                            <th>Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM cursos";
                        if(isset($_GET['search']) && !empty($_GET['search'])) {
                            $search = mysqli_real_escape_string($con, $_GET['search']);
                            $query .= " WHERE nome_curso LIKE '%$search%' OR categoria LIKE '%$search%' OR descricao LIKE '%$search%'";
                        }
                        $query .= " ORDER BY data_cadastro DESC";
                        
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            $status_class = $row['ativo'] ? 'status-active' : 'status-inactive';
                            $status_text = $row['ativo'] ? 'Ativo' : 'Inativo';
                            
                            echo "<tr>
                                <td>".$row['id_curso']."</td>
                                <td>".htmlspecialchars($row['nome_curso'])."</td>
                                <td>".htmlspecialchars($row['categoria'])."</td>
                                <td>".$row['duracao']." horas</td>
                                <td><span class='status-badge $status_class'>$status_text</span></td>
                                <td><img src='img/cursos/".htmlspecialchars($row['imagem'])."' class='curso-img'></td>
                                <td>".date('d/m/Y', strtotime($row['data_cadastro']))."</td>
                                <td>
                                    <a href='inventory.php?id_curso=".$row['id_curso']."' class='action-btn delete-btn' onclick='return confirm(\"Tem certeza que deseja excluir este curso?\")'>
                                        <i class='fas fa-trash-alt'></i>
                                    </a>
                                    <a href='inventory.php?id_cursod=".$row['id_curso']."' class='action-btn edit-btn'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php
    if(isset($_GET['id_cursod'])) {
        $id = (int)$_GET['id_cursod'];
        $query = "SELECT * FROM cursos WHERE id_curso = $id";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        
        echo "<div class='container11'>
            <h2>Editar Curso</h2>
            <form id='update-form' action='inventory.php' enctype='multipart/form-data' method='post'>
                <input type='hidden' name='id_curso1' value='".$row['id_curso']."'>
                <input type='hidden' name='prevphoto' value='".htmlspecialchars($row['imagem'])."'>
                
                <label for='name1'>Nome do Curso:</label>
                <input type='text' id='name1' name='name1' value='".htmlspecialchars($row['nome_curso'])."' required>
                
                <label for='categoria1'>Categoria:</label>
                <select id='categoria1' name='categoria1' required>
                    <option value='Básico' ".($row['categoria']=='Básico'?'selected':'').">Curso Básico</option>
                    <option value='Avançado' ".($row['categoria']=='Avançado'?'selected':'').">Curso Avançado</option>
                    <option value='Especialização' ".($row['categoria']=='Especialização'?'selected':'').">Especialização</option>
                </select>
                
                <label for='descricao1'>Descrição:</label>
                <textarea id='descricao1' name='descricao1' rows='3' required>".htmlspecialchars($row['descricao'])."</textarea>
                
                <label for='duracao1'>Duração (horas):</label>
                <input type='number' id='duracao1' name='duracao1' value='".$row['duracao']."' min='1' required>
                
                <label for='link_video1'>Link do Vídeo:</label>
                <input type='url' id='link_video1' name='link_video1' value='".htmlspecialchars($row['link_video'])."' required>
                
                <label for='photo1'>Nova Imagem (opcional):</label>
                <input type='file' id='photo1' name='photo1' accept='image/*'>
                <small>Imagem atual: ".htmlspecialchars($row['imagem'])."</small>
                <div style='margin: 10px 0;'>
                    <img src='img/cursos/".htmlspecialchars($row['imagem'])."' style='max-width: 200px;'>
                </div>
                
                <label for='ativo1'>Status:</label>
                <select id='ativo1' name='ativo1'>
                    <option value='1' ".($row['ativo']?'selected':'').">Ativo</option>
                    <option value='0' ".(!$row['ativo']?'selected':'').">Inativo</option>
                </select>
                
                <button name='submitt' type='submit' class='insert-btn'>Atualizar Curso</button>
            </form>
        </div>";
    }
    
    mysqli_close($con);
    ?>
</body>
</html>