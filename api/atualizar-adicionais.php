<?php 
  include_once("database.php");

  $codigodoadicional = isset($_POST["codigodoadicional"]) ? $_POST["codigodoadicional"] : null;
  $descricaoadicional = isset($_POST["descricaoadicional"]) ? $_POST["descricaoadicional"] : null;
  $valorunitario = isset($_POST["valorunitario"]) ? $_POST["valorunitario"] : null;
  $codigodogrupo = isset($_POST["grupo"]) ? $_POST["grupo"] : null;
  $fg_esgotado = isset($_POST["fg_esgotado_adicionais"]) ? $_POST["fg_esgotado_adicionais"] : null;
  $imagem = isset($_FILES["imagem"]) ? $_FILES["imagem"] : "";

  $base64Image = null;
  if ($imagem && $imagem["tmp_name"]) {
    $imgContent = file_get_contents($imagem["tmp_name"]);
    $base64Image = base64_encode($imgContent);
  }

  try {
    $sql_verificar = "SELECT fg_esgotado, img
                      FROM estoque_adicionais
                      WHERE codigodoadicional = :codigodoadicional";
    $stmt_verificar = $conn->prepare($sql_verificar);
    $stmt_verificar->bindParam(":codigodoadicional", $codigodoadicional);
    $stmt_verificar->execute();
    $result_verificar = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

    $fg_banco = $result_verificar["fg_esgotado"];
    $img_banco = $result_verificar["img"];

    if ($fg_esgotado) {
      $fg_esgotado = $fg_banco == 1 ? 0 : 1;
    } else {
      $fg_esgotado = $fg_banco;
    }

    if (is_null($base64Image)) {
      $base64Image = $img_banco;
    }

    $sql = "UPDATE estoque_adicionais SET
            descricaoadicional = :descricaoadicional,
            valorunitario = :valorunitario,
            grupo = :grupo,
            fg_esgotado = :fg_esgotado,
            img = :img
            WHERE codigodoadicional = :codigodoadicional";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":descricaoadicional", $descricaoadicional);
    $stmt->bindParam(":valorunitario", $valorunitario);
    $stmt->bindParam(":grupo", $codigodogrupo);
    $stmt->bindParam(":fg_esgotado", $fg_esgotado);
    $stmt->bindParam(":img", $base64Image);
    $stmt->bindParam(":codigodoadicional", $codigodoadicional);
    $stmt->execute();

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
  } catch (PDOException $e) {
    echo "Erro ao atualizar o estoque de adicionais: " . $e->getMessage();
  }
?>
