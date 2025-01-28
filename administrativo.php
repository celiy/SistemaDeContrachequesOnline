<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    // Caso não seja um admin, redireciona para a página inic
    header('Location: index.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['form_type'] == 'funcionario') {
        // Recebe os dados do formulário de login
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $admissao = $_POST['admissao'];
        $departamento = $_POST['departamento'];
        $cargo = $_POST['cargo'];
        $salario = $_POST['salario'];
        $senha_digitada = $senha;

        // Inclua a conexão com o banco de dados
        include 'db_principal.php';
        $funcionario = null;
        try {
            // Verifica se o e-mail existe no banco de dados
            $query = $conexao->prepare("SELECT email FROM funcionario WHERE email = ?");
            $query->bind_param("s", $email);
            $query->execute();
            $funcionario = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro_funcionario = $e->getMessage();
        }

        if ($funcionario) {
            $erro_funcionario = "E-mail ja cadastrado: " . $funcionario['email'];
        } else {
            try {
                // Insere o funcionário no banco de dados 
                $sql = "INSERT INTO funcionario (nome, email, senha, cpf, 
                        data_admissao, departamento, cargo, salario_base) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conexao->prepare($sql);
                $stmt->execute([$nome, $email, $senha_digitada, $cpf, $admissao, $departamento, $cargo, $salario]);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro_funcionario = $e->getMessage();
            }
        }
    } else if ($_POST['form_type'] == 'update_func') {
        // Recebe os dados do formulário de login
        $func_id = $_POST['id_func'];
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $admissao = $_POST['admissao'];
        $departamento = $_POST['departamento'];
        $cargo = $_POST['cargo'];
        $salario = $_POST['salario'];

        // Inclua a conexão com o banco de dados
        include 'db_principal.php';
        $funcionario = null;
        try {
            // Verifica se o e-mail existe no banco de dados
            $query = $conexao->prepare("SELECT email FROM funcionario WHERE email = ?
                AND id_funcionario != ?");
            $query->bind_param("si", $email, $func_id);
            $query->execute();
            $funcionario = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro_funcionario = $e->getMessage();
        }

        if ($funcionario) {
            $erro_funcionario = "E-mail ja cadastrado: " . $funcionario['email'];
        } else {
            try {
                // Atualiza o funcionário no banco de dados 
                $sql = "UPDATE funcionario SET nome = ?, email = ?, senha = ?, cpf = ?, 
                        data_admissao = ?, departamento = ?, cargo = ?, salario_base = ?
                        WHERE id_funcionario = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->execute([$nome, $email, $senha_digitada, $cpf, $admissao, $departamento, $cargo, $salario, $func_id]);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro_funcionario = $e->getMessage();
            }
        }
    } else if ($_POST['form_type'] == 'update_cheque') {
        // Recebe os dados do formulário de login
        $cheque_id = $_POST['id_cheque'];
        $mes_referencia = $_POST['mes'];
        $geracao = $_POST['geracao'];
        $salario_base = $_POST['salario'];
        $vencimentos = $_POST['vencimentos'];
        $desconto = $_POST['desconto'];
        $liquido = $_POST['liquido'];
        $funcionario_id = $_POST['funcionario'];

        $func_id = null;
        try {
            include 'db_principal.php';
            // Verifica se o funcionário existe no banco de dados
            $query = $conexao->prepare("SELECT id_funcionario FROM funcionario WHERE id_funcionario = ?");
            $query->bind_param("s", $funcionario_id);
            $query->execute();
            $func_id = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro_cheque = $e->getMessage();
        }

        if ($func_id) {
            try {
                include 'db_principal.php';
                // Atualiza o funcionário no banco de dados 
                $sql = "UPDATE contracheque SET mes_referencia = ?, data_geracao = ?, salario_base = ?, total_vencimentos = ?, total_descontos = ?, salario_liquido = ?
                        WHERE id_contracheque = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->execute([$mes_referencia, $geracao, $salario_base, $vencimentos, $desconto, $liquido, $cheque_id]);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro_cheque = $e->getMessage();
            }
        } else {
            $erro_cheque = "Funcionario com ID informado não existe.";
        }
    } else if ($_POST['form_type'] == 'admin') {
        // Recebe os dados do formulário de login
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha_digitada = $senha;

        // Inclua a conexão com o banco de dados
        include 'db_principal.php';
        $admin = null;
        try {
            // Verifica se o e-mail existe no banco de dados
            $query = $conexao->prepare("SELECT email FROM admin WHERE email = ?");
            $query->bind_param("s", $email);
            $query->execute();
            $admin = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro_admin = $e->getMessage();
        }

        if ($admin) {
            $erro_admin = "E-mail ja cadastrado: " . $admin['email'];
        } else {
            try {
                // Insere o funcionário no banco de dados 
                $sql = "INSERT INTO admin (email, senha, ultimo_acesso, status_ativo) VALUES (?, ?, ?, ?)";
                $stmt = $conexao->prepare($sql);
                $data_atual = date('Y-m-d H:i:s');
                $stmt->execute([$email, $senha_digitada, $data_atual, 1]);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro_admin = $e->getMessage();
            }
        }
    } else if ($_POST['form_type'] == 'contracheque') {
        // Recebe os dados do formulário de login
        $mes_referencia = $_POST['mes'];
        $geracao = $_POST['geracao'];
        $salario_base = $_POST['salario'];
        $vencimentos = $_POST['vencimentos'];
        $desconto = $_POST['desconto'];
        $liquido = $_POST['liquido'];
        $funcionario_id = $_POST['funcionario'];

        $func_id = null;
        try {
            include 'db_principal.php';
            // Verifica se o funcionário existe no banco de dados
            $query = $conexao->prepare("SELECT id_funcionario FROM funcionario WHERE id_funcionario = ?");
            $query->bind_param("s", $funcionario_id);
            $query->execute();
            $func_id = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro_cheque = $e->getMessage();
        }

        if ($func_id) {
            try {
                include 'db_principal.php';
                // Insere o funcionário no banco de dados 
                $sql = "INSERT INTO contracheque (mes_referencia, data_geracao, salario_base, total_vencimentos,
                total_descontos, salario_liquido, id_funcionario)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conexao->prepare($sql);
                $data_atual = date('Y-m-d H:i:s');
                $stmt->execute([$mes_referencia, $geracao, $salario_base, $vencimentos, $desconto, $liquido, $funcionario_id]);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro_cheque = $e->getMessage();
            }
        } else {
            $erro_cheque = "Funcionario com ID informado não existe.";
        }
    } else if ($_POST['form_type'] == 'delete_func') {
        $funcionario_id = $_POST['value_to_delete'];

        $func_id = null;
        try {
            include 'db_principal.php';
            // Verifica se o funcionário existe no banco de dados
            $query = $conexao->prepare("SELECT id_funcionario FROM funcionario WHERE id_funcionario = ?");
            $query->bind_param("s", $funcionario_id);
            $query->execute();
            $func_id = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }

        if ($func_id) {
            try {
                include 'db_principal.php';
                // Deleta o funcionário no banco de dados 
                $sql = "DELETE FROM funcionario WHERE id_funcionario = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("i", $funcionario_id);
                $stmt->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
        } else {
            $erro = "Funcionario com ID informado não existe.";
        }
    } else if ($_POST['form_type'] == 'delete_cheque') {
        $cheque_id = $_POST['value_to_delete_cheque'];

        $ch_id = null;
        try {
            include 'db_principal.php';
            $query = $conexao->prepare("SELECT id_contracheque FROM contracheque WHERE id_contracheque = ?");
            $query->bind_param("s", $cheque_id);
            $query->execute();
            $ch_id = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }

        if ($ch_id) {
            try {
                include 'db_principal.php';
                // Deleta o funcionário no banco de dados 
                $sql = "DELETE FROM contracheque WHERE id_contracheque = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("i", $cheque_id);
                $stmt->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
        } else {
            $erro = "Contracheque com ID informado não existe.";
        }
    } else if ($_POST['form_type'] == 'delete_admin') {
        $admin_id = $_POST['value_to_delete_admin'];

        $usr_id = null;
        try {
            include 'db_principal.php';
            // Verifica se o funcionário existe no banco de dados
            $query = $conexao->prepare("SELECT id_admin FROM admin WHERE id_admin = ?");
            $query->bind_param("s", $admin_id);
            $query->execute();
            $usr_id = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }

        if ($usr_id) {
            try {
                include 'db_principal.php';
                // Deleta o funcionário no banco de dados 
                $sql = "DELETE FROM admin WHERE id_admin = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("i", $admin_id);
                $stmt->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
        } else {
            $erro = "Admin com ID informado não existe.";
        }
    } else if ($_POST['form_type'] == 'contracheque_pdf') {
        $targetDir = 'uploads/';
        $targetFile = $targetDir . basename($_FILES["pdfFile"]["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $func_id_pdf = $_POST['funcionario_id_pdf'];

        $func_id = null;
        try {
            include 'db_principal.php';
            // Verifica se o funcionário existe no banco de dados
            $query = $conexao->prepare("SELECT id_funcionario FROM funcionario WHERE id_funcionario = ?");
            $query->bind_param("s", $func_id_pdf);
            $query->execute();
            $func_id = $query->get_result()->fetch_assoc();
        } catch (Exception $e) {
            $erro_cheque = $e->getMessage();
        }

        if (!$func_id) {
            $erro_cheque = "Funcionario com ID informado não existe.";
        } else {
            if ($fileType != "pdf" || $_FILES["pdfFile"]["size"] > 10000000) {
                $erro_cheque = "O arquivo deve ser no formato PDF e ter menos de 10MB.";
            } else {
                if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $targetFile)) {
                    $filename = $_FILES["pdfFile"]["name"];
                    $folder_path = $targetDir;
                    $time_stamp = date('Y-m-d H:i:s');
                    try {
                        include 'db_principal.php';
                        $sql = "INSERT INTO contracheque_pdf (filename, folder_path, time_stamp, id_funcionario) 
                        VALUES (?, ?, ?, ?)";
                        $stmt = $conexao->prepare($sql);
                        $stmt->bind_param("sssi", $filename, $folder_path, $time_stamp, $func_id_pdf);
                        $stmt->execute();
                        move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile);
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } catch (Exception $e) {
                        $erro_cheque = $e->getMessage();
                    }
                }
            }
        }
    } else if ($_POST['form_type'] == 'delete_cheque_pdf') {
        $cheque_pdf_id = $_POST['id_cheque_pdf'];

        try {
            include 'db_principal.php';

            // Pega o caminho do arquivo que sera deletado
            $sql = "SELECT folder_path, filename FROM contracheque_pdf WHERE id_contracheque_pdf = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("i", $cheque_pdf_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $file_path = $row['folder_path'] . $row['filename'];

            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Deleta o funcionário no banco de dados 
            $sql = "DELETE FROM contracheque_pdf WHERE id_contracheque_pdf = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("i", $cheque_pdf_id);
            $stmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if ($_POST['form_type'] == 'update_password'){
            $func_email = null;
            try {
                include 'db_principal.php';
                $func_email = $_POST['email_func'];
                $senha = $_POST['password'];
                $senha_digitada = $senha;

                $query = $conexao->prepare("UPDATE funcionario SET senha = ? WHERE email = ?");
                $query->bind_param("ss", $senha_digitada, $func_email);
                $query->execute();
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
            try {
                include 'db_principal.php';
                $sql = "DELETE FROM contato_admin WHERE email = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("s", $func_email);
                $stmt->execute();
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (Exception $e) {
                $erro = $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Adminstrativo</title>
</head>

<body>
    <?php include 'navbars/navbar_inicio.php'; ?>

    <div class="itens-menu">
        <a href="#cadastro-funcionario">
            <div onclick="openCadastroFuncionario()" id="#cadastro-funcionario">
                <h4>Cadastro de Funcionários</h4>
            </div>
        </a>
        <a href="#funcionarios-data">
            <div onclick="openConsultaFuncionario()" id="#funcionarios-data">
                <h4>Funcionários</h4>
            </div>
        </a>
        <a href="#cadastro-administradores">
            <div onclick="openCadastrarAdministradores()" id="#cadastro-administradores">
                <h4>Cadastrar adminis</h4>
            </div>
        </a>
        <a href="#contracheques">
            <div onclick="openContracheques()" id="#contracheques">
                <h4>Cadastrar Contracheques</h4>
            </div>
        </a>
        <a href="#contracheques_table">
            <div onclick="openContrachequesTable()" id="#contracheques_table">
                <h4>Contracheques</h4>
            </div>
        </a>
    </div>

    <div id="cadastro-funcionario">

        <h1 style="text-align: center; margin-top: 3rem;">Cadastro de funcionário</h1>

        <?php
        if (isset($erro_funcionario)) {
            echo "<p style='color:red; text-align: center;'>$erro_funcionario</p>";
        }
        ?>

        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <label for="cpf">CPF:</label>
            <input type="number" name="cpf" id="cpf" required>

            <label for="admissao">Data de Admissão:</label>
            <input type="date" name="admissao" id="admissao" required>

            <label for="departamento">Departamento:</label>
            <input type="text" name="departamento" id="departamento" required>

            <label for="cargo">Cargo:</label>
            <input type="text" name="cargo" id="cargo" required>

            <label for="salario">Salário Base R$:</label>
            <input type="number" name="salario" id="salario" required>

            <input type="hidden" name="id_func" value="" id="id_func">
            <input type="hidden" name="form_type" value="funcionario" id="form_type_func">
            <input type="submit" name="submit" value="Cadastrar" id="cadastrar_func">
        </form>
    </div>

    <div id="funcionarios-data" style="display: block;">
        <?php include 'funcionario_table.php'; ?>
        <h1 style='text-align: center;'>Requisições de mudança de senha</h1>
        <section class="table_component">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Requisitor
                        </th>
                        <th>
                            Nova senha
                        </th>
                        <th>
                            Enviar
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    ?>
                    <?php
                    include 'db_principal.php';
                    $query = $conexao->prepare("SELECT email FROM contato_admin");
                    $query->execute();
                    $emails = $query->get_result()->fetch_assoc();

                    $count = 1;
                    if (isset($emails)) {
                        foreach ($emails as $email) {
                            echo "<tr>";
                            echo "<td>" . $email . "</td>";
                            echo "
                                <form method='POST'>
                                <td>
                                <input type='password' name='password' id='password'>
                                </td>
                                <td>
                                <button type='submit'>Mudar</button>
                                </td>
                                <input type='hidden' name='form_type' value='update_password' id='update_password'>
                                <input type='hidden' name='email_func' value=" . $email . " id='email_func'>
                                </form>";
                            echo "</tr>";
                            $count++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <div id="cadastro-administradores">

        <h1 style="text-align: center; margin-top: 3rem;">Cadastro de administradores</h1>

        <?php
        if (isset($erro_admin)) {
            echo "<p style='color:red; text-align: center;'>$erro_admin</p>";
        }
        ?>

        <form method="POST">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <input type="hidden" name="form_type" value="admin">
            <input type="submit" name="submit" value="Cadastrar">
        </form>

        <?php include 'admin_table.php'; ?>
    </div>

    <div id="contracheques">

        <h1 style="text-align: center; margin-top: 3rem;">Cadastro de Contracheques</h1>

        <?php
        if (isset($erro_cheque)) {
            echo "<p style='color:red; text-align: center;'>$erro_cheque</p>";
        }
        ?>

        <form method="POST">
            <label for="mes">Mês de Referência:</label>
            <input type="text" name="mes" id="mes" required>

            <label for="geracao">Data da geração:</label>
            <input type="date" name="geracao" id="geracao" required>

            <label for="salario">Salário Base:</label>
            <input type="number" name="salario" id="salario" required>

            <label for="vencimentos">Total de Vencimentos:</label>
            <input type="number" name="vencimentos" id="vencimentos" required>

            <label for="desconto">Total de Descontos:</label>
            <input type="number" name="desconto" id="desconto" required>

            <label for="liquido">Salário Líquido:</label>
            <input type="number" name="liquido" id="liquido" required>

            <label for="funcionario">ID Do funcionário:</label>
            <input type="number" name="funcionario" id="funcionario" required>

            <input type="hidden" name="id_cheque" value="" id="id_cheque">
            <input type="hidden" name="form_type" value="contracheque" id="form_type_cheque">
            <input type="submit" name="submit" value="Cadastrar" id="cadastrar_cheque">
        </form>
        <form method="POST" enctype="multipart/form-data">
            <h4 style="text-align: center; margin-bottom: 1rem;">Arquivo PDF:</h4>
            <input type="file" name="pdfFile" id="pdfFile">

            <label for="funcionario">ID Do funcionário:</label>
            <input type="number" name="funcionario_id_pdf" id="funcionario_id_pdf" required>

            <input type="hidden" name="form_type" value="contracheque_pdf" id="form_type_cheque_pdf">
            <input type="submit" name="submit" value="Enviar">
        </form>
    </div>

    <div id="contracheques_table">
        <?php include 'contracheque_table.php'; ?>
        <div>
            <?php
            include 'db_principal.php';
            $query = $conexao->prepare("SELECT id_contracheque_pdf, id_funcionario, filename, 
            time_stamp FROM contracheque_pdf");
            $query->execute();
            $cheques_pdf = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            $table_pdf = json_encode($cheques_pdf);
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
                            <th>
                                Excluir
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
                                echo "
                                <form method='POST'>
                                <td>
                                <button type='submit' class='delete_cheque_pdf'>Excluir</button>
                                </td>
                                <input type='hidden' name='form_type' value='delete_cheque_pdf' id='delete_cheque_pdf'>
                                <input type='hidden' name='id_cheque_pdf' value=" . $cheque_pdf['id_contracheque_pdf'] . " id='id_cheque_pdf'>
                                </form>";
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

    <!-- Hidden forms, servem para deletar itens das tabelas -->
    <form method="POST" id="delete_func_form" style="display: none;"></form>
    <input type="hidden" name="value_to_delete" id="value_to_delete">
    <input type="hidden" name="form_type" value="delete_func" id="delete_func">
    <form method="POST" id="delete_cheque_form" style="display: none;"></form>
    <input type="hidden" name="value_to_delete_cheque" id="value_to_delete_cheque">
    <input type="hidden" name="form_type" value="delete_cheque" id="delete_cheque">
    <form method="POST" id="delete_admin_form" style="display: none;"></form>
    <input type="hidden" name="value_to_delete_admin" id="value_to_delete_admin">
    <input type="hidden" name="form_type" value="delete_admin" id="delete_admin">

    <script src="itens_menu.js"></script>
</body>

</html>