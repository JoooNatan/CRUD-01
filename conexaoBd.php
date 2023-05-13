<?php //Conexao com DB usando PDO

    //Dados de acesso ao DB
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "crud";
    $port = 3306;

    try {
        //Conexão com a porta
        $conexao = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $password);
        
        // echo "<h1>CONEXAO COM DB DEU BOM!</h1>";
    } catch(PDOException) {
        // echo "<h1>CONEXAO COM DB DEU RUIM!</h1>";
    }
?>