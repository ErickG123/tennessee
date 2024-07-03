<?php 
  include_once("database.php");

  $codigoproduto = isset($_POST["codigoproduto"]) ? $_POST["codigoproduto"] : null;
  $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : null;
  $descricao_longa = isset($_POST["descricao_longa"]) ? $_POST["descricao_longa"] : null;
  $valorvendavista = isset($_POST["valorvendavista"]) ? $_POST["valorvendavista"] : null;
  $codigodogrupo = isset($_POST["grupo"]) ? $_POST["grupo"] : null;

  try {
    $sql_verificar = "SELECT fg_esgotado 
                      FROM estoque 
                      WHERE codigoproduto = :codigoproduto";
    $stmt_verificar = $conn->prepare($sql_verificar);
    $stmt_verificar->bindParam(":codigoproduto", $codigoproduto);
    $stmt_verificar->execute();
    $fg_banco = $stmt_verificar->fetchColumn();

    if ($_POST["fg_esgotado"]) {
      $fg_esgotado = $fg_banco == 1 ? 0 : 1;
    } else {
      $fg_esgotado = $fg_banco;
    }

    $sql = "UPDATE estoque SET
            descricao = :descricao,
            descricao_longa = :descricao_longa,
            codigodogrupo = :codigodogrupo,
            valorvendavista = :valorvendavista,
            fg_esgotado = :fg_esgotado
            WHERE codigoproduto = :codigoproduto";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":descricao", $descricao);
    $stmt->bindParam(":descricao_longa", $descricao_longa);
    $stmt->bindParam(":codigodogrupo", $codigodogrupo);
    $stmt->bindParam(":valorvendavista", $valorvendavista);
    $stmt->bindParam(":fg_esgotado", $fg_esgotado);
    $stmt->bindParam(":codigoproduto", $codigoproduto);
    $stmt->execute();

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
  } catch (PDOException $e) {
    echo "Erro ao atualizar o estoque: " . $e->getMessage();
  }
?>
