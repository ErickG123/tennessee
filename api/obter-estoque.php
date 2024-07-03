<?php 
  include_once("database.php");

  $codigoproduto = $_GET["codigoproduto"];

  $sql = "SELECT e.codigoproduto, e.descricao, e.descricao_longa, e.valorvendavista, e.fg_esgotado, e.img, g.codigo, g.grupo
          FROM estoque e
          INNER JOIN grupo g ON e.codigodogrupo = g.codigo
          WHERE e.codigoproduto = :codigoproduto";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":codigoproduto", $codigoproduto);
  $stmt->execute();

  $produto = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($produto) {
    echo json_encode($produto);
  } else {
    echo json_encode(array("error" => "Produto não encontrado"));
  }
?>
