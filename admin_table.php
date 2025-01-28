<!DOCTYPE html>
<html>
<head>
<body>
    <?php
        include 'db_principal.php';
        $query = $conexao->prepare("SELECT id_admin, email, ultimo_acesso, status_ativo FROM admin");
        $query->execute();
        $usuarios = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $table = json_encode($usuarios); 
    ?>

    <h1 style="text-align: center;">Administradores</h1>

    <?php
        if (isset($table)) {
            echo "<div id='data_admins' style='display: none;'>$table</div>";
        } 
    ?>

    <section class="table_component" id="admins" role="region" tabindex="0"></section>

    <script src="draw_table_admins.js"></script>
</body>
</html>