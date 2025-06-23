<?php
session_start();

include("include/connect.php");

$error = '';
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM contas WHERE username='$username'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verificação de senha (assumindo que está armazenada como hash)
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_conta'] = $row['id_conta'];
            $_SESSION['username'] = $row['username'];
            
            // Redirecionar para a página de perfil
            header("Location: profile.php");
            exit();
        } else {
            $error = 'Nome de usuário ou senha incorretos!';
        }
    } else {
        $error = 'Nome de usuário ou senha incorretos!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Faça login na Drive Up para acessar seus cursos e recursos exclusivos."/>
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="style.css"/>

    <title>Login - Drive Up</title>
    
    <style>
        /* Estilos adicionais para a página de login */
        .login-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: white;
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-size: 28px;
        }
        
        .input-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }
        
        .input1 {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .input1:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52,152,219,0.5);
            outline: none;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .sign {
            text-align: center;
            margin-top: 20px;
        }
        
        .signn {
            color: #3498db;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .signn:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 5px;
        }
        
        .forgot-password a {
            color: #3498db;
            text-decoration: none;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <section class="header" id="header">
        <a href="index.php"><img src="img/banner/logofinal2.png" class="logo" alt="Drive Up Logo" width="100px"/></a>

        <div>
            <ul class="navbar" id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="cursos.php">Cursos</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a class="active" href="login.php">Login</a></li>
                <li><a href="cadastrar.php">Cadastre-se</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li id="lg-bag"></li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div class="mobile" id="mobile">
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <div class="login-container animate__animated animate__fadeIn">
        <h1 class="login-title">Bem-vindo de volta!</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error-message animate__animated animate__shakeX">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" id="login-form">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input class="input1" id="user" name="username" type="text" placeholder="Nome de usuário *" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input class="input1" id="pass" name="password" type="password" placeholder="Senha *" required>
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>
            
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Lembrar-me</label>
                </div>
                <div class="forgot-password">
                    <a href="forgot-password.php">Esqueceu a senha?</a>
                </div>
            </div>
            
            <button type="submit" class="btn" name="submit">Entrar</button>
        </form>

        <div class="sign">
            <p>Não possui uma conta? <a href="cadastrar.php" class="signn">Cadastre-se</a></p>
        </div>
    </div>

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
            <a href="login.php">Login</a>
            <a href="cadastrar.php">Cadastrar</a>
        </div>

        <div class="col">
            <h4>Links Úteis</h4>
            <a href="cursos.php">Cursos</a>
            <a href="contato.php">Suporte</a>
            <a href="politica-privacidade.php">Política de Privacidade</a>
        </div>

        <div class="copyright">
            <p>&copy; 2025 Drive Up. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Scripts JS -->
    <script src="script.js"></script>
    <script>
        // Mostrar/ocultar senha
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#pass');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
        
        // Verificar se há parâmetros de erro na URL
        window.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');
            
            if (error) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message animate__animated animate__shakeX';
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${error}`;
                
                const form = document.getElementById('login-form');
                form.prepend(errorDiv);
            }
        });
        
        // Lembrar usuário
        document.addEventListener('DOMContentLoaded', function() {
            const rememberCheckbox = document.getElementById('remember');
            const usernameInput = document.getElementById('user');
            
            // Verificar se há credenciais salvas
            if (localStorage.getItem('rememberUsername') === 'true') {
                rememberCheckbox.checked = true;
                usernameInput.value = localStorage.getItem('username') || '';
            }
            
            // Salvar credenciais ao marcar "Lembrar-me"
            document.getElementById('login-form').addEventListener('submit', function() {
                if (rememberCheckbox.checked) {
                    localStorage.setItem('rememberUsername', 'true');
                    localStorage.setItem('username', usernameInput.value);
                } else {
                    localStorage.removeItem('rememberUsername');
                    localStorage.removeItem('username');
                }
            });
        });
    </script>
</body>
</html>