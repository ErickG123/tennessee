<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Estoque</title>

    <link rel="stylesheet" href="<?= 'style.css'; ?>">
</head>
<body>
    <?php 
        include_once("includes/database.php");

        $sql_estoque = "SELECT e.codigoproduto, e.descricao, e.descricao_longa, e.valorvendavista, e.fg_esgotado, e.img, g.grupo
                        FROM estoque e
                        INNER JOIN grupo g ON e.codigodogrupo = g.codigo";
        $stmt_estoque = $conn->prepare($sql_estoque);
        $stmt_estoque->execute();

        $sql_adicionais = "SELECT e.codigodoadicional, e.descricaoadicional, e.valorunitario, e.fg_esgotado, g.grupo
                           FROM estoque_adicionais e
                           INNER JOIN grupo g ON e.grupo = g.codigo";
        $stmt_adicionais = $conn->prepare($sql_adicionais);
        $stmt_adicionais->execute();
    ?>

    <div class="tab">
        <button id="defaultOpen" class="tablinks" onclick="openCity(event, 'ESTOQUE')">Estoque</button>
        <button class="tablinks" onclick="openCity(event, 'ESTOQUE_ADICIONAIS')">Estoque Adicionais</button>
    </div>

    <div id="ESTOQUE" class="tabcontent">
        <?php 
            while ($data = $stmt_estoque->fetchObject()) {
                $codigoproduto = $data->codigoproduto;
                $descricao = $data->descricao;
                $descricao_longa = $data->descricao_longa;
                $valorvendavista = $data->valorvendavista;
                $img = $data->img;
                $grupo = $data->grupo;
                $fg_esgotado = $data->fg_esgotado;
        ?>
            <div class="modal">
                <div class="modal-cabecalho">
                    <p class="modal-titulo"><?= $descricao; ?></p>
                    <button class="btnModalEstoque">Editar</button>
                </div>
                <img src="imagem_not_available.jpg" alt="Imagem Produto">
                <p><span>Descrição Longa:</span> <?= $descricao_longa; ?></p>
                <div class="modal-infos">
                    <p><span>Valor:</span> <?= $valorvendavista; ?></p>
                    <p><span>Grupo:</span> <?= $grupo; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div id="ESTOQUE_ADICIONAIS" class="tabcontent">
        <?php 
            while ($data = $stmt_adicionais->fetchObject()) {
                $codigodoadicional = $data->codigodoadicional;
                $descricaoadicional = $data->descricaoadicional;
                $valorunitario = $data->valorunitario;
                $grupo = $data->grupo;
                $fg_esgotado = $data->fg_esgotado;
        ?>
            <div class="modal">
                <div class="modal-cabecalho">
                    <p class="modal-titulo"><?= $descricao; ?></p>
                    <button>Editar</button>
                </div>
                <img src="imagem_not_available.jpg" alt="Imagem Produto">
                <p><span>Descrição Longa:</span> <?= $descricaoadicional; ?></p>
                <div class="modal-infos">
                    <p><span>Valor:</span> <?= $valorunitario; ?></p>
                    <p><span>Grupo:</span> <?= $grupo; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <div id="modalEstoque" class="modal-estoque">
        <div class="modal-content">
            <span class="close">&times;</span>

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
                <input type="text" name="valorvendavista">
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
            
            <div class="divFgEsgotado">
                <input type="checkbox" name="<?= $fg_esgotado == 0 ? 'desativar' : 'ativar'; ?>" id="input<?= $fg_esgotado == 0 ? 'Desativar' : 'Ativar'; ?>">
                <label for="<?= $fg_esgotado == 0 ? 'desativar' : 'ativar'; ?>"><?= $fg_esgotado == 0 ? 'Desativar' : 'Ativar'; ?></label>
            </div>
        </div>
    </div>

    <script><?php include("script.js"); ?></script>
</body>
</html>
