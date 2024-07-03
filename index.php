<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Estoque</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        include_once("api/database.php");

        $sql_estoque = "SELECT e.codigoproduto, e.descricao, e.descricao_longa, e.valorvendavista, e.img, g.grupo
                        FROM estoque e
                        INNER JOIN grupo g ON e.codigodogrupo = g.codigo";
        $stmt_estoque = $conn->prepare($sql_estoque);
        $stmt_estoque->execute();

        $sql_adicionais = "SELECT e.codigodoadicional, e.descricaoadicional, e.valorunitario, e.img, g.grupo
                           FROM estoque_adicionais e
                           INNER JOIN grupo g ON e.grupo = g.codigo";
        $stmt_adicionais = $conn->prepare($sql_adicionais);
        $stmt_adicionais->execute();
    ?>

    <div class="tab">
        <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'ESTOQUE')">Estoque</button>
        <button class="tablinks" onclick="openCity(event, 'ESTOQUE_ADICIONAIS')">Estoque Adicionais</button>
    </div>

    <input class="inputPesquisa" type="text" id="searchInput" onkeyup="filterItems()" placeholder="Pesquisar...">

    <div id="ESTOQUE" class="tabcontent">
        <?php 
            while ($data_estoque = $stmt_estoque->fetchObject()) {
                $codigoproduto = $data_estoque->codigoproduto;
                $descricao = $data_estoque->descricao;
                $descricao_longa = $data_estoque->descricao_longa;
                $valorvendavista = $data_estoque->valorvendavista;
                $img = $data_estoque->img;
                $grupo = $data_estoque->grupo;
        ?>
            <div class="card">
                <div class="card-cabecalho">
                    <p class="card-titulo"><?= $descricao; ?></p>
                    <button class="btnModalEstoque" data-id="<?= $codigoproduto; ?>">Editar</button>
                </div>
                <?php if ($img): ?>
                    <img src="data:image/jpeg;base64,<?= $img; ?>" alt="<?= "imagem_$descricao" ?>">
                <?php else: ?>
                    <img src="imagem_not_available.jpg" alt="Imagem Indisponível">
                <?php endif; ?>
                <p><span>Descrição Longa:</span> <?= $descricao_longa; ?></p>
                <div class="card-infos">
                    <p><span>Valor:</span> <?= "R$ " . number_format($valorvendavista, 2, ",", "."); ?></p>
                    <p><span>Grupo:</span> <?= $grupo; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div id="ESTOQUE_ADICIONAIS" class="tabcontent">
        <?php 
            while ($data_adicionais = $stmt_adicionais->fetchObject()) {
                $codigodoadicional = $data_adicionais->codigodoadicional;
                $descricaoadicional = $data_adicionais->descricaoadicional;
                $valorunitario = $data_adicionais->valorunitario;
                $img = $data_adicionais->img;
                $grupo = $data_adicionais->grupo;
        ?>
            <div class="card">
                <div class="card-cabecalho">
                    <p class="card-titulo"><?= $descricaoadicional; ?></p>
                    <button class="btnModalAdicionais" data-id="<?= $codigodoadicional; ?>">Editar</button>
                </div>
                <?php if ($img): ?>
                    <img src="data:image/jpeg;base64,<?= $img; ?>" alt="<?= "imagem_$descricao" ?>">
                <?php else: ?>
                    <img src="imagem_not_available.jpg" alt="Imagem Indisponível">
                <?php endif; ?>
                <div class="card-infos">
                    <p><span>Valor:</span> <?= "R$ " . number_format($valorunitario, 2, ",", "."); ?></p>
                    <p><span>Grupo:</span> <?= $grupo; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div id="modalEstoque" class="modal-estoque">
        <div class="modal-content">
            <span id="btnFecharModalEstoque">X</span>

            <form action="api/atualizar-estoque.php" method="post" enctype="multipart/form-data">
                <label for="descricao">
                    Descrição:
                    <input type="text" name="descricao">
                </label>

                <label for="descricao_longa">
                    Descrição Longa:
                    <input type="text" name="descricao_longa">
                </label>

                <label for="valorvendavista">
                    Valor:
                    <input type="number" step="0.01" name="valorvendavista">
                </label>

                <label for="grupo">
                    Grupo:
                    <select name="grupo" id="grupo">
                        <?php 
                            $sql_grupo = "SELECT codigo, grupo
                                          FROM grupo";
                            $stmt_grupo = $conn->query($sql_grupo);
                            $grupos = $stmt_grupo->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($grupos as $grupo) {  
                        ?>
                            <option value="<?= $grupo["codigo"]; ?>"><?= $grupo["grupo"]; ?></option>
                        <?php } ?>
                    </select>
                </label>

                <label for="imagem">
                    Imagem:
                    <input type="file" name="imagem" id="imagem">
                </label>
                
                <div class="divFgEsgotado">
                    <input type="checkbox" name="fg_esgotado" id="fg_esgotado">
                    <label id="labelEstoque" for="fg_esgotado"></label>
                </div>

                <input type="hidden" name="codigoproduto">

                <button type="submit">Atualizar</button>
            </form>
        </div>
    </div>

    <div id="modalAdicionais" class="modal-estoque">
        <div class="modal-content">
            <span id="btnFecharModalAdicionais">X</span>

            <form action="api/atualizar-adicionais.php" method="post" enctype="multipart/form-data">
                <label for="descricaoadicional">
                    Descrição:
                    <input type="text" name="descricaoadicional">
                </label>

                <label for="valorunitario">
                    Valor:
                    <input type="number" step="0.01" name="valorunitario">
                </label>

                <label for="grupo">
                    Grupo:
                    <select name="grupo" id="grupo">
                        <?php 
                            $sql_grupo = "SELECT codigo, grupo
                                          FROM grupo";
                            $stmt_grupo = $conn->query($sql_grupo);
                            $grupos = $stmt_grupo->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($grupos as $grupo) {  
                        ?>
                            <option value="<?= $grupo["codigo"]; ?>"><?= $grupo["grupo"]; ?></option>
                        <?php } ?>
                    </select>
                </label>

                <label for="imagem">
                    Imagem:
                    <input type="file" name="imagem" id="imagem">
                </label>

                <div class="divFgEsgotado">
                    <input type="checkbox" name="fg_esgotado_adicionais" id="fg_esgotado_adicionais">
                    <label id="labelAdicionais" for="fg_esgotado_adicionais"></label>
                </div>

                <input type="hidden" name="codigodoadicional">

                <button type="submit">Atualizar</button>
            </form>
        </div>
    </div>

    <script><?php include("modal-estoque.js"); ?></script>
    <script><?php include("modal-adicionais.js"); ?></script>
    <script><?php include_once("pesquisa.js"); ?></script>
</body>
</html>
