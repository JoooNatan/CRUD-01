<?php 
    include_once "conexaoBd.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body>
    <main>
        <h1>Lista de usuarios</h1>
        <a href="cadastrar.php" id="link_cadastrar">Cadastrar Novo Usuario</a>
        <table id="tbl_usuarios">
            <thead>
                <th>Id</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Situação</th>
                <th>Nivel de acesso</th>
                <th>Ações</th>
            </thead>
            <tbody>
                <?php
                    /*-------------------------------------------- Lista os usuarios ---------------------------------------------*/
                    $query_usuarios = 
                    "SELECT usuarios.id AS id_usu, usuarios.nome AS nome_usu, usuarios.email AS email_usu, sits_usuarios.nome AS nome_sit, niveis_acessos.nome AS nome_nivel
                    FROM usuarios
                    INNER JOIN sits_usuarios ON usuarios.sit_usuario_id = sits_usuarios.id
                    INNER JOIN niveis_acessos ON usuarios.nivel_acesso_id = niveis_acessos.id
                    ORDER BY usuarios.id ASC";
                    
                    $result_usuarios = $conexao->prepare($query_usuarios);
                    $result_usuarios->execute();
        
                    while ($usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                        extract($usuario);

                        echo    "<tr>
                                    <td>$id_usu</td>
                                    <td>$nome_usu</td>
                                    <td>$email_usu</td>
                                    <td>$nome_sit</td>
                                    <td>$nome_nivel</td>
                                    <td> 
                                        <a href='deletar.php?id_usuario=$id_usu' id='link_apagar' onclick='return confirmacao()'>Apagar</a>
                                        <a href='editar.php?id_usuario=$id_usu' id='link_editar'>Editar</a>
                                    </td>
                                </tr>";
                    }
                    /*------------------------------------------------------------------------------------------------------------*/
                ?>
                <script>
                    function confirmacao() {
                        return confirm("Tem certeza de que deseja excluir este usuário?");
                    }
                </script>
        </table>
    </main>
</body>
</html>