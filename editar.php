<?php 
    include_once "conexaoBd.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles/form_.css">
</head>
<body>
    <main>
        <?php
            /*-------------------------- Pega as informações do usuario selecionado para editar --------------------------*/
            $id_usu = $_GET['id_usuario'];// Pega o id do usuario enviado pela URL

            $query_usu_selecionado = 
            "SELECT usuarios.id AS id_usu, usuarios.nome AS nome_usu, usuarios.email AS email_usu, sits_usuarios.nome AS sit_usu, sits_usuarios.id AS id_sit, niveis_acessos.nome AS nivel_usu, niveis_acessos.id AS id_nivel
            FROM usuarios
            LEFT JOIN sits_usuarios ON usuarios.sit_usuario_id = sits_usuarios.id
            LEFT JOIN niveis_acessos ON usuarios.nivel_acesso_id = niveis_acessos.id
            WHERE usuarios.id = $id_usu";

            $result_selecionado = $conexao->prepare($query_usu_selecionado);
            $result_selecionado->execute();
            $usuario = $result_selecionado->fetch(PDO::FETCH_ASSOC);

            $id_usu = $usuario['id_usu'];
            $nome = $usuario['nome_usu'];
            $email = $usuario['email_usu'];
            $sit = $usuario['sit_usu'];
            $nivel = $usuario['nivel_usu'];
            $id_sit = $usuario['id_sit'];
            $id_nivel = $usuario['id_nivel'];
            /*------------------------------------------------------------------------------------------------------------*/

            /*------------------------------------------------------------------------------------------------------------*/
            $dados_up = filter_input_array(INPUT_POST, FILTER_DEFAULT);// Pega os dados enviados pelo formulario

            if (!empty($dados_up['UpUsuario'])) {
                try {
                    $query_up_usu = 
                    "UPDATE usuarios
                    SET usuarios.nome = :nome, usuarios.email = :email, usuarios.senha = :senha, usuarios.sit_usuario_id = :id_sit, usuarios.nivel_acesso_id = :id_nivel
                    WHERE usuarios.id = $id_usu";
        
                    $result_up = $conexao->prepare($query_up_usu);
                    $result_up->bindParam(":nome", $dados_up['nome_usuario'], PDO::PARAM_STR);
                    $result_up->bindParam(":email", $dados_up['email_usuario'], PDO::PARAM_STR);
    
                    $senha_cripto = password_hash($dados_up['senha_usuario'], PASSWORD_DEFAULT);
    
                    $result_up->bindParam(":senha", $senha_cripto, PDO::PARAM_STR);
                    $result_up->bindParam(":id_sit", $dados_up['sit_usuario'], PDO::PARAM_INT);
                    $result_up->bindParam(":id_nivel", $dados_up['nivel_acesso_usuario'], PDO::PARAM_INT);
    
    
                    if ($result_up->execute()) {
                        // echo '<script>alert("' . "Usuario editado com sucesso." . '");</script>';
                        header("Location: index.php");
                    }

                } catch (PDOException $e) {
                    echo '<script>alert("' . "ERRO: " . $e->getMessage() . '");</script>';
                }
            }
            /*------------------------------------------------------------------------------------------------------------*/
        ?>

        <form action="" method="POST" class="form_">
            <h2>Editar usuario</h2>
            <div class="campo_cad">
                <label for="nome_usuario">Nome:</label>
                <input type="text" value="<?= $nome ?>" name="nome_usuario" id="nome_usuario" required>
            </div>

            <div class="campo_cad">
                <label for="email_usuario">E-mail:</label>
                <input type="text" value="<?= $email ?>" name="email_usuario" id="email_usuario" required>
            </div>

            <div class="campo_cad">
                <label for="senha_usuario">Senha:</label>
                <input type="password" name="senha_usuario" id="senha_usuario" required>
            </div>

            <div class="campo_cad">
                <label for="sit_usuario">Situação:</label>
                <select name="sit_usuario" id="sit_usuario" required>
                    <option value="">Selecione</option>
                    <?php 
                        $query_sits = "SELECT id, nome FROM sits_usuarios ORDER BY nome ASC";
                        $result_sits = $conexao->prepare($query_sits);
                        $result_sits->execute();

                        while ($row_sit = $result_sits->fetch()) {
                            extract($row_sit);
                            $selected_sit = "";
                            if ($id == $id_sit) {
                                $selected_sit = "selected";
                            }
                            echo "<option value='$id' $selected_sit>$nome</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="campo_cad">
                <label for="nivel_acesso_usuario">Nivel de Acesso:</label>
                <select name="nivel_acesso_usuario" id="nivel_acesso_usuario" required>
                    <option value="">Selecione</option>
                    <?php 
                        $query_niveis = "SELECT id, nome FROM niveis_acessos ORDER BY nome ASC";
                        $result_niveis = $conexao->prepare($query_niveis);
                        $result_niveis->execute();

                        while ($row_nivel = $result_niveis->fetch()) {
                            extract($row_nivel);
                            $selected_nivel = "";
                            if ($id == $id_nivel) {
                                $selected_nivel = "selected";
                            }
                            echo "<option value='$id' $selected_nivel>$nome</option>";
                        }
                    ?>
                </select>
            </div>

            <div id="btns">
                <input type="submit" value="Editar" name="UpUsuario" class="btns_" id="btn_update">
                <a href="index.php" class="btns_">Voltar</a>
            </div>
        </form>
    </main>
</body>
</html>