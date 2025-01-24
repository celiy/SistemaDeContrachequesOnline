<!DOCTYPE html>
<html>
<head>
<body>
    <?php
        include 'db_users.php';
        $query = $conexao->prepare("SELECT id_funcionario, nome, email, cpf, data_emissao,
                departamento, cargo, salario_base FROM funcionario");
        $query->execute();
        $funcionarios = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $table = json_encode($funcionarios); 
    ?>

    <h1 style="text-align: center; margin-top: 3rem;">Funcionários</h1>

    <?php
        if (isset($table)) {
            echo "<div id='data' style='display: none;'>$table</div>";
        } 
    ?>

    <section class="table_component" role="region" tabindex="0"></section>

    <script src="draw_table.js"></script>
</body>
</html>