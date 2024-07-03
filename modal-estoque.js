var modal = document.getElementById("modalEstoque");
var btnsEstoque = document.querySelectorAll(".btnModalEstoque");
var btnFecharModalEstoque = document.getElementById("btnFecharModalEstoque");

function abrirModalEstoque() {
    modal.style.display = "block";
}

function fecharModalEstoque() {
    modal.style.display = "none";
}

btnsEstoque.forEach((btnEstoque) => {
    btnEstoque.addEventListener("click", function () {
        var codigoProduto = this.getAttribute("data-id");

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "api/obter-estoque.php?codigoproduto=" + codigoProduto, true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);

                document.querySelector(`input[name="codigoproduto"]`).value = data.codigoproduto;
                document.querySelector(`input[name="descricao"]`).value = data.descricao;
                document.querySelector(`input[name="descricao_longa"]`).value = data.descricao_longa;
                document.querySelector(`input[name="valorvendavista"]`).value = data.valorvendavista;

                var selectGrupo = document.querySelector(`select[name="grupo"]`);
                selectGrupo.value = data.codigo;

                var labelEstoque = document.getElementById("labelEstoque");
                if (data.fg_esgotado == 1) {
                    labelEstoque.innerText = "Desabilitar";
                } else {
                    labelEstoque.innerText = "Ativar";
                }

                abrirModalEstoque();
            } else {
                console.error("Erro ao obter os detalhes do estoque.");
            }
        };
        xhr.send();
    });
});

btnFecharModalEstoque.addEventListener("click", () => {
    fecharModalEstoque();
});

window.onclick = function (event) {
    if (event.target == modal) {
        fecharModalEstoque();
    }
}

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
