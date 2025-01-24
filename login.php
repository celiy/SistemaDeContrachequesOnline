<?php
session_start(); // Inicia a sessão para armazenar as variáveis de login, caso sejam bem-sucedidas.

if (isset($_SESSION['id_funcionario']) && !empty($_SESSION['id_funcionario'])) {
    // Caso já esteja logado, redireciona para a página inicial do funcionário
    header('Location: funcionario.php');
    exit();
}

if (isset($_SESSION['id_admin']) && !empty($_SESSION['id_admin'])) {
    // Caso já esteja logado, redireciona para a página inicial do adminstrativo
    header('Location: administrativo.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário de login
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_digitada = $senha;

    // Conexão com o banco de dados
    include 'db_users.php';

    // Verifica se o e-mail existe no banco de dados
    $query = $conexao->prepare("SELECT email, senha, id_admin FROM usuario WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $usuario = $query->get_result()->fetch_assoc();

    // Verifica se o admin foi encontrado e se a senha corresponde
    if ($usuario && $usuario['senha'] == $senha_digitada) {
        $_SESSION['id_admin'] = $usuario['id_admin'];
        header('Location: administrativo.php');
        exit();
    } else {
        $erro = "Credenciais inválidas.";
    }

    // Verifica se o e-mail existe no banco de dados
    $query = $conexao->prepare("SELECT email, senha, id_funcionario FROM funcionario WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $usuario = $query->get_result()->fetch_assoc();

    // Verifica se o funcionario foi encontrado e se a senha corresponde
    if ($usuario && $usuario['senha'] == $senha_digitada) {
        $_SESSION['id_funcionario'] = $usuario['id_funcionario'];
        header('Location: funcionario.php');
        exit();
    } else {
        $erro = "Credenciais inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body style="margin-top: 7rem;">
<?php include 'navbars/navbar_inicio.php'; ?>

<h1 style="text-align: center;">Login</h1>

<?php
if (isset($erro)) {
    echo "<p style='color:red; text-align: center;'>$erro</p>";
}
?>

<form action="login.php" method="POST">
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <p>Esqueceu a senha? <a href='contato_admin.php'>Entre em Contato com Administrador</a></p>

    <input type="submit" value="Entrar">
</form>

</body>
</html>
