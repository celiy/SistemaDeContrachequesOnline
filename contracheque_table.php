<!DOCTYPE html>
<html>
<head>
<body>
    <?php
        include 'db_cheque.php';
        $query = $conexao->prepare("SELECT id_contracheque, id_funcionario, mes_referencia, data_geracao, 
        salario_base, total_vencimentos, total_descontos, salario_liquido FROM contracheque");
        $query->execute();
        $usuarios = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $table = json_encode($usuarios); 
    ?>

    <h1 style="text-align: center; margin-top: 3rem;">Contracheques</h1>

    <?php
        if (isset($table)) {
            echo "<div id='data_cheques' style='display: none;'>$table</div>";
        } 
    ?>

    <section class="table_component" id="cheques" role="region" tabindex="0"></section>

    <script type="module" src="draw_table_cheque.js"></script>
</body>
</html>