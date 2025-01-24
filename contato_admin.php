<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contato com o Administrador</title>
</head>
<body>
    <?php include 'navbars/navbar_inicio.php'; ?>

    <h1 style="text-align: center; margin-top: 10rem;">Contato com o Administrador</h1>
    <p style="text-align: center; margin-bottom: 2rem; margin-top: 1rem;">
        Insira seu endereço de E-mail que uma mensagem será enviada para o Administrador</p>

    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'db_users.php';
        $email = $_POST['email'];

        $query = $conexao->prepare("SELECT email FROM funcionario WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $usuario = $query->get_result()->fetch_assoc();

        if (!$usuario) {
            $erro = "Credenciais inválidas.";
        } else {
            $sql = "INSERT INTO contato_admin (email) VALUES (?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    ?>

    <?php
    if (isset($erro)) {
        echo "<p style='color:red; text-align: center;'>$erro</p>";
    }
    ?>

    <form action="contato_admin.php" method="POST">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email">

        <input type="submit" value="Enviar">
    </form>
</body>
</html>