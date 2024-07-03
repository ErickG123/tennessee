<?php 
  include_once("database.php");

  $codigoproduto = isset($_POST["codigoproduto"]) ? $_POST["codigoproduto"] : null;
  $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : null;
  $descricao_longa = isset($_POST["descricao_longa"]) ? $_POST["descricao_longa"] : null;
  $valorvendavista = isset($_POST["valorvendavista"]) ? $_POST["valorvendavista"] : null;
  $codigodogrupo = isset($_POST["grupo"]) ? $_POST["grupo"] : null;
  $fg_esgotado = isset($_POST["fg_esgotado"]) ? $_POST["fg_esgotado"] : null;
  $imagem = isset($_FILES["imagem"]) ? $_FILES["imagem"] : "";

  $base64Image = null;
  if ($imagem && $imagem["tmp_name"]) {
    $imgContent = file_get_contents($imagem["tmp_name"]);
    $base64Image = base64_encode($imgContent);
  }

  try {
    $sql_verificar = "SELECT fg_esgotado, img
                      FROM estoque 
                      WHERE codigoproduto = :codigoproduto";
    $stmt_verificar = $conn->prepare($sql_verificar);
    $stmt_verificar->bindParam(":codigoproduto", $codigoproduto);
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

    $sql = "UPDATE estoque SET
            descricao = :descricao,
            descricao_longa = :descricao_longa,
            codigodogrupo = :codigodogrupo,
            valorvendavista = :valorvendavista,
            fg_esgotado = :fg_esgotado,
            img = :img
            WHERE codigoproduto = :codigoproduto";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":descricao", $descricao);
    $stmt->bindParam(":descricao_longa", $descricao_longa);
    $stmt->bindParam(":codigodogrupo", $codigodogrupo);
    $stmt->bindParam(":valorvendavista", $valorvendavista);
    $stmt->bindParam(":fg_esgotado", $fg_esgotado);
    $stmt->bindParam(":img", $base64Image);
    $stmt->bindParam(":codigoproduto", $codigoproduto);
    $stmt->execute();

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
  } catch (PDOException $e) {
    echo "Erro ao atualizar o estoque: " . $e->getMessage();
  }
?>
