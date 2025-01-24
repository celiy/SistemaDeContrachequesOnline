<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <nav>
    <div class="navbar">
      <div class="logo"><a href="index.php">Sistema Online de Contracheque</a></div>
      <ul class="menu">
        <li><a href="index.php">Inicio</a></li>
       
        <?php 
          if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_funcionario'])) {
            echo '<li><a href="login.php">Login</a></li>';
          }
        ?>
        <?php 
          if (isset($_SESSION['id_admin'])) {
            echo '<li><a href="administrativo.php">Adminstrativo</a></li>';
            echo '<li><a href="sair.php">Sair</a></li>';
          }
          if (isset($_SESSION['id_funcionario'])) {
            echo '<li><a href="funcionario.php">Funcionário</a></li>';
            echo '<li><a href="sair.php">Sair</a></li>';
          }
        ?>
      </ul>
    </div>
  </nav>
</body>
</html>