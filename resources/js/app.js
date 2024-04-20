import "./bootstrap";
import "flowbite";
import Datepicker from "flowbite-datepicker/Datepicker";

import { Modal } from "flowbite";

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

import TomSelect from "tom-select/dist/esm/tom-select";
import TomSelect_remove_button from "tom-select/dist/esm/plugins/remove_button/plugin";
import TomSelect_caret_position from "tom-select/dist/esm/plugins/caret_position/plugin";
import "tom-select/dist/css/tom-select.css";
import "../css/app.css";

// import 'tinymce/tinymce';
// import 'tinymce/skins/ui/oxide/skin.min.css';
// import 'tinymce/skins/content/default/content.min.css';
// import 'tinymce/skins/content/default/content.css';
// import 'tinymce/icons/default/icons';
// import 'tinymce/themes/silver/theme';
// import 'tinymce/models/dom/model';

document.querySelectorAll(".datepicker").forEach((el) => {
    new Datepicker(el, {
        //
    });
});

import Chart from "chart.js/auto";
window.Chart = Chart;

TomSelect.define("remove_button", TomSelect_remove_button);
TomSelect.define("caret_position", TomSelect_caret_position);

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.start();

// make table row clickable
const tableRows = document.querySelectorAll(".table-clickable tbody tr");
for (const tableRow of tableRows) {
    tableRow.addEventListener("click", function () {
        window.location.href = this.dataset.href;
    });
}

// prevent button inside table row clickable
const tableRowsButtons = document.querySelectorAll(
    "table tbody tr .table-row-button"
);
for (const tableRowsButton of tableRowsButtons) {
    tableRowsButton.onclick = function (event) {
        // do stuff
        event.stopPropagation();
    };
}

document.querySelectorAll(".tom-select").forEach((el) => {
    if (el.hasAttribute("multiple")) {
        new TomSelect(el, {
            plugins: ["remove_button", "caret_position"],
            create: false,
            sortField: {
                field: "text",
                direction: "asc",
            },
        });
    } else {
        new TomSelect(el, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc",
            },
        });
    }
});
