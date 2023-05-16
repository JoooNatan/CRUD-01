<?php
    include_once "conexaoBd.php";

    $id_usu = $_GET['id_usuario'];// Pega o id do usuario enviado pela URL
    
    try {
        $query_delet_usu = "DELETE FROM usuarios WHERE id = :id";
        $result_delet = $conexao->prepare($query_delet_usu);
        $result_delet->bindParam(":id", $id_usu, PDO::PARAM_INT);
    
        $result_delet->execute();
        header("Location: index.php");
        
    } catch (PDOException $e) {
        echo "ERRO: " . $e->getMessage();
    }
?>