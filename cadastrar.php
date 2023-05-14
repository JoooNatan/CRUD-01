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
    <link rel="stylesheet" href="styles/cadastrar.css">
</head>
<body>
    <?php
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($dados['SendCadUsuario'])) {
            
            try {
                $query_usuario = 
                "INSERT INTO usuarios (nome, email, senha, sit_usuario_id, nivel_acesso_id, created)
                VALUES (:nome, :email, :senha, :sits_usuario_id, :nivel_acesso_id, NOW())";
                $cad_usuario = $conexao->prepare($query_usuario);
                $cad_usuario->bindParam(':nome', $dados['nome_usuario'], PDO::PARAM_STR);
                $cad_usuario->bindParam(':email', $dados['email_usuario'], PDO::PARAM_STR);
    
                $senha_cripto = password_hash($dados['senha_usuario'], PASSWORD_DEFAULT);
    
                $cad_usuario->bindParam(':senha', $senha_cripto, PDO::PARAM_STR);
                $cad_usuario->bindParam(':sits_usuario_id', $dados['sit_usuario'], PDO::PARAM_INT);
                $cad_usuario->bindParam(':nivel_acesso_id', $dados['nivel_acesso_usuario'], PDO::PARAM_INT);
    
                $cad_usuario->execute();
    
                if ($cad_usuario->rowCount()) {
                    echo "<p>Usuario cadastrado</p>";
                    unset($dados);//destroi a variavel $dados
                } else {
                    "ERRO! Usuario nao cadastrado";
                }

            } catch (PDOException $erro) {
                echo "ERRO! Usuario não cadastrado. <br> ERRO: " . $erro->getMessage() . "<br>";
            }

        }
    ?>
    <form action="" method="POST" id="form_cad">
        <div class="campo_cad">
            <label for="nome_usuario" required>Nome:</label>
            <input type="text" name="nome_usuario" id="nome_usuario">            
        </div>

        <div class="campo_cad">
            <label for="email_usuario" required>E-mail:</label>
            <input type="text" name="email_usuario" id="email_usuario">
        </div>

        <div class="campo_cad">
            <label for="senha_usuario" required>Senha:</label>
            <input type="password" name="senha_usuario" id="senha_usuario">
        </div>

        <div class="campo_cad">
            <label for="sit_usuario" required>Situação:</label>
            <select name="sit_usuario" id="sit_usuario">
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
            <label for="nivel_acesso_usuario" required>Nivel de Acesso:</label>
            <select name="nivel_acesso_usuario" id="nivel_acesso_usuario">
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

        <input type="submit" value="Cadastrar" name="SendCadUsuario" id="btn_cadastrar">
        <a href="index.php">Voltar</a>
    </form>
</body>
</html>