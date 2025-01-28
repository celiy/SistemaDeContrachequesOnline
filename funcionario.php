<?php
session_start();
if (!isset($_SESSION['id_funcionario'])) {
    // Caso não seja um admin, redireciona para a página inic
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Funcionario</title>
</head>
<body>
    <?php include 'navbars/navbar_inicio.php'; ?>

    <div id="contracheques_table" style="margin-top: 10rem;">
        <?php
            include 'db_principal.php';

            if (isset($_SESSION['id_funcionario'])) {
                $id_funcionario = $_SESSION['id_funcionario'];
                $query = $conexao->prepare("SELECT id_contracheque, id_funcionario, mes_referencia, data_geracao, 
                salario_base, total_vencimentos, total_descontos, salario_liquido FROM contracheque
                WHERE id_funcionario = ?");
                $query->bind_param("i", $id_funcionario);
                $query->execute();
                $usuarios = $query->get_result()->fetch_all(MYSQLI_ASSOC);
                $table = json_encode($usuarios); 
            }
        ?>

        <h1 style="text-align: center; margin-top: 3rem;">Contracheques</h1>

        <?php
            if (isset($table)) {
                echo "<div id='data_cheques' style='display: none;'>$table</div>";
            } 
        ?>

        <section class="table_component" id="cheques" role="region" tabindex="0"></section>

        <div>
            <?php
            include 'db_principal.php';
            if (isset($_SESSION['id_funcionario'])) {
                $id_funcionario = $_SESSION['id_funcionario'];
                $query = $conexao->prepare("SELECT id_contracheque_pdf, id_funcionario, filename, 
                time_stamp FROM contracheque_pdf WHERE id_funcionario = ?");
                $query->bind_param("i", $id_funcionario);
                $query->execute();
                $cheques_pdf = $query->get_result()->fetch_all(MYSQLI_ASSOC);
                $table_pdf = json_encode($cheques_pdf);
            }
            ?>

            <section class="table_component">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                ID Cheque PDF
                            </th>
                            <th>
                                ID Funcionário
                            </th>
                            <th>
                                Nome do arquivo
                            </th>
                            <th>
                                Timestamp
                            </th>
                            <th>
                                Download
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        if (isset($table_pdf)) {
                            foreach ($cheques_pdf as $cheque_pdf) {
                                echo "<tr>";
                                echo "<td>" . $cheque_pdf['id_contracheque_pdf'] . "</td>";
                                echo "<td>" . $cheque_pdf['id_funcionario'] . "</td>";
                                echo "<td>" . $cheque_pdf['filename'] . "</td>";
                                echo "<td>" . $cheque_pdf['time_stamp'] . "</td>";
                                echo "<td><a href='uploads/" . $cheque_pdf['filename'] . "'>Download</a></td>";
                                echo "</tr>";
                                $count++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    <script type="module" src="draw_table_cheque_func.js"></script>
</body>
</html>