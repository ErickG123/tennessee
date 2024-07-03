var modalAdicionais = document.getElementById("modalAdicionais");
var btnsAdicionais = document.querySelectorAll(".btnModalAdicionais");
var btnFecharModalAdicionais = document.getElementById("btnFecharModalAdicionais");

function abrirModalAdicional() {
  modalAdicionais.style.display = "block";
}

function fecharModalAdicional() {
  modalAdicionais.style.display = "none";
}

btnsAdicionais.forEach((btnAdicional) => {
  btnAdicional.addEventListener("click", function () {
    var codigoAdicional = this.getAttribute("data-id");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/obter-adicional.php?codigodoadicional=" + codigoAdicional, true);
    xhr.onload = function () {
      if (xhr.status == 200) {
        var data = JSON.parse(xhr.responseText);

        document.querySelector(`input[name="codigodoadicional"]`).value = data.codigodoadicional;
        document.querySelector(`input[name="descricaoadicional"]`).value = data.descricaoadicional;
        document.querySelector(`input[name="valorunitario"]`).value = data.valorunitario;

        var selectGrupo = document.querySelector(`select[name="grupo"]`);
        selectGrupo.value = data.codigo;

        var labelAdicionais = document.getElementById("labelAdicionais");
        if (data.fg_esgotado == 1) {
          labelAdicionais.innerText = "Desabilitar";
        } else {
          labelAdicionais.innerText = "Ativar";
        }

        abrirModalAdicional();
      } else {
        console.error("Erro ao obter os detalhes do estoque de adicionais.");
      }
    };
    xhr.send();
  });
});

btnFecharModalAdicionais.addEventListener("click", () => {
  fecharModalAdicional();
});

window.onclick = function (event) {
  if (event.target == modalAdicionais) {
    fecharModalAdicional();
  }
}
