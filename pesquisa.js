function filterItems() {
    var input, filter, tabcontent, cards, card, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    tabcontent = document.getElementsByClassName("tabcontent");

    for (var j = 0; j < tabcontent.length; j++) {
        cards = tabcontent[j].getElementsByClassName("card");

        for (i = 0; i < cards.length; i++) {
            card = cards[i];
            txtValue = card.textContent || card.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        }
    }
}
