<?php
    $servername = "localhost";
    $dbname = "tennessee_dlv";
    $username = "root";
    $password = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $_SESSION["alert_title"] = "Erro ao se Conectar ao Banco de Dados Geral";
        $_SESSION["alert_msg"] = "A Conexão Falhou: " . $e->getMessage();
        $_SESSION["alert_color"] = "red";

        header("Location: index.php");
        exit;
    }
?>
