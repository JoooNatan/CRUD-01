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
    <h1>Lista de usuarios</h1>

    <a href="cadastrar.php" id="link_cadastrar">Cadastrar Novo Usuario</a>

    <table id="tbl_usuarios">
        <thead>
            <th>Id</th>
            <th>Nome</th>
            <th>E-mail</th>
        </thead>

        <tbody>
            <?php 
                $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER BY id ASC";
                $result_usuarios = $conexao->prepare($query_usuarios);
                $result_usuarios->execute();
        
                while ($usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                    extract($usuario);
                    echo    "<tr>
                                <td>$id</td>
                                <td>$nome</td>
                                <td>$email</td>
                            </tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>