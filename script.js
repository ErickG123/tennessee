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

var modal = document.getElementById("modalEstoque");
var btnsEstoque = document.querySelectorAll(".btnModalEstoque");
var span = document.getElementsByClassName("close")[0];

function abrirModalEstoque() {
    modal.style.display = "block";
}

function fecharModalEstoque() {
    modal.style.display = "none";
}

btnsEstoque.forEach((btnEstoque) => {
    btnEstoque.addEventListener("click", () => {
        console.log("Oi")
        abrirModalEstoque();
    });
});

window.onclick = function (event) {
    if (event.target == modal) {
        fecharModalEstoque();
    }
}
