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
    <form action="" method="POST" id="form_cad">
        <div class="campo_cad">
            <label for="nome_usuario">Nome:</label>
            <input type="text" name="nome_usuario" id="nome_usuario">            
        </div>

        <div class="campo_cad">
            <label for="email_usuario">E-mail:</label>
            <input type="text" name="email_usuario" id="email_usuario">
        </div>

        <div class="campo_cad">
            <label for="senha_usuario">Senha:</label>
            <input type="password" name="senha_usuario" id="senha_usuario">
        </div>

        <div class="campo_cad">
            <label for="sit_usuario">Situação:</label>
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
            <label for="nivel_acesso_usuario">Nivel de Acesso:</label>
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

        <div id="btn_cadastrar">
            <input type="submit" value="Cadastrar" name="sendCadUsuario">
        </div>
    </form>

    <?php
        if (!empty($dados['sendCadUsuario'])) {

            try {
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                
                $query_cad = "INSERT INTO usuarios (nome, email, senha, sit_usuario_id, nivel_acesso_id, created) VALUES (:nome, :email, :senha, :sit_usuario, :nivel_acesso, NOW())";
        
                $cad_usuario = $conexao->prepare($query_cad);
        
                $cad_usuario->bindParam(':nome', $dados['nome']);
                $cad_usuario->bindParam(':email', $dados['email']);
                $cad_usuario->bindParam(':senha', $dados['senha']);
                $cad_usuario->bindParam(':sit_usuario_id', $dados['sit_usuario_id']);
                $cad_usuario->bindParam(':nivel_acesso_id', $dados['nivel_acesso_id']);
        
                $cad_usuario->execute();
                
                if ($cad_usuario->rowCount()) {
                    unset($dados);//destroi a variavel $dados
                    //header("Location: index.php");
                } else {
                    "ERRO! Usuario nao cadastrado";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    ?>
</body>
</html>