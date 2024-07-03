<?php 
  include_once("database.php");
  include_once("../includes/formatacao.php");

  $codigodoadicional = isset($_POST["codigodoadicional"]) ? $_POST["codigodoadicional"] : null;
  $descricaoadicional = isset($_POST["descricaoadicional"]) ? $_POST["descricaoadicional"] : null;
  $valorunitario = isset($_POST["valorunitario"]) ? $_POST["valorunitario"] : null;
  $codigodogrupo = isset($_POST["grupo"]) ? $_POST["grupo"] : null;

  try {
    $sql_verificar = "SELECT fg_esgotado 
                      FROM estoque_adicionais
                      WHERE codigodoadicional = :codigodoadicional";
    $stmt_verificar = $conn->prepare($sql_verificar);
    $stmt_verificar->bindParam(":codigodoadicional", $codigodoadicional);
    $stmt_verificar->execute();
    $fg_banco = $stmt_verificar->fetchColumn();

    if ($_POST["fg_esgotado_adicionais"]) {
      $fg_esgotado = $fg_banco == 1 ? 0 : 1;
    } else {
      $fg_esgotado = $fg_banco;
    }

    $sql = "UPDATE estoque_adicionais SET
            descricaoadicional = :descricaoadicional,
            valorunitario = :valorunitario,
            grupo = :grupo,
            fg_esgotado = :fg_esgotado
            WHERE codigodoadicional = :codigodoadicional";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":descricaoadicional", $descricaoadicional);
    $stmt->bindParam(":valorunitario", $valorunitario);
    $stmt->bindParam(":grupo", $codigodogrupo);
    $stmt->bindParam(":fg_esgotado", $fg_esgotado);
    $stmt->bindParam(":codigodoadicional", $codigodoadicional);
    $stmt->execute();

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
  } catch (PDOException $e) {
    echo "Erro ao atualizar o estoque de adicionais: " . $e->getMessage();
  }
?>
