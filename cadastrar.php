<?php 
    include_once "conexaoBd.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuario</title>
    <link rel="stylesheet" href="styles/form_.css">
</head>
<body>
    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);// Pega as informações digitadas no formulario e armazena em '$dados'
        
        if (!empty($dados['SendCadUsuario'])) { // Verifica se o botão para cadastrar foi clicado, verificando se existe algo na variavel $dados['SendCadUsuario']
            // var_dump($dados);
            try {
                $query_usuario = 
                "INSERT INTO usuarios (nome, email, senha, sit_usuario_id, nivel_acesso_id, created)
                VALUES (:nome, :email, :senha, :sits_usuario_id, :nivel_acesso_id, NOW())";

                $cad_usuario = $conexao->prepare($query_usuario);

                // Substitui os links pelos valores da array '$dados' em seus respectivos campos
                $cad_usuario->bindParam(':nome', $dados['nome_usuario'], PDO::PARAM_STR);
                $cad_usuario->bindParam(':email', $dados['email_usuario'], PDO::PARAM_STR);

                // Criptografa a senha
                $senha_cripto = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);

                $cad_usuario->bindParam(':senha', $senha_cripto, PDO::PARAM_STR);
                $cad_usuario->bindParam(':sits_usuario_id', $dados['sit_usuario'], PDO::PARAM_INT);
                $cad_usuario->bindParam(':nivel_acesso_id', $dados['nivel_acesso_usuario'], PDO::PARAM_INT);
    
                $cad_usuario->execute();
    
                if ($cad_usuario->rowCount()) {
                    echo '<script>alert("' . "Usuario cadastrado com sucesso." . '");</script>';
                    unset($dados);//destroi a variavel $dados para poder cadastrar um novo usuario
                } else {
                    echo '<script>alert("' . "ERRO! Usuario nao cadastrado" . '");</script>';
                }

            } catch (PDOException $erro) {
                echo '<script>alert("' . "ERRO:" . $erro->getMessage() .  '");</script>';
            }

        }
    ?>

    <form action="" method="POST" class="form_">
        <h2>Cadastrar novo usuario</h2>
        <div class="campo_cad">
            <label for="nome_usuario">Nome:</label>
            <input type="text" name="nome_usuario" id="nome_usuario" required>            
        </div>

        <div class="campo_cad">
            <label for="email_usuario">E-mail:</label>
            <input type="text" name="email_usuario" id="email_usuario" required>
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
                        echo "<option value='$id'>$nome</option>";
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
                        echo "<option value='$id'>$nome</option>";
                    }
                ?>
            </select>
        </div>

        <div id="btns">
            <input type="submit" value="Cadastrar" name="SendCadUsuario" class="btns_" id="btn_cadastrar">
            <a href="index.php" class="btns_">Voltar</a>
        </div>
    </form>
</body>
</html>