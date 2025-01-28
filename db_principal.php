<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";  
$banco = "sistema_contracheque";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
?>