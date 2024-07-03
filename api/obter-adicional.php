<?php 
  include_once("database.php");

  $codigodoadicional = $_GET["codigodoadicional"];

  $sql = "SELECT e.codigodoadicional, e.descricaoadicional, e.valorunitario, e.fg_esgotado, e.img, g.codigo, g.grupo
          FROM estoque_adicionais e
          INNER JOIN grupo g ON e.grupo = g.codigo
          WHERE e.codigodoadicional = :codigodoadicional";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":codigodoadicional", $codigodoadicional);
  $stmt->execute();

  $adicional = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($adicional) {
    echo json_encode($adicional);
  } else {
    echo json_encode(array("error" => "Adicional não encontrado"));
  }
?>
