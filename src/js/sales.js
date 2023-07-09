$(document).ready(function () {
    sortTable();
});

function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("salesHistory");
    switching = true;
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("th")[0];
            y = rows[i + 1].getElementsByTagName("th")[0];
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
