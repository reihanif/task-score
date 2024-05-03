import "./bootstrap";
import "flowbite";
import Datepicker from "flowbite-datepicker/Datepicker";

import * as FilePond from "filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";
import FilePondPluginFileEncode from "filepond-plugin-file-encode";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";

import { Modal } from "flowbite";

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

import TomSelect from "tom-select/dist/esm/tom-select";
import TomSelect_remove_button from "tom-select/dist/esm/plugins/remove_button/plugin";
import TomSelect_caret_position from "tom-select/dist/esm/plugins/caret_position/plugin";
import "tom-select/dist/css/tom-select.css";
import "../css/app.css";

import Chart from "chart.js/auto";
window.Chart = Chart;

import { Editor } from "@tiptap/core";
import Document from "@tiptap/extension-document";
import Paragraph from "@tiptap/extension-paragraph";
import Text from "@tiptap/extension-text";
import Bold from "@tiptap/extension-bold";
import Italic from "@tiptap/extension-italic";
import Underline from "@tiptap/extension-underline";
import Strike from "@tiptap/extension-strike";
import ListItem from "@tiptap/extension-list-item";
import OrderedList from "@tiptap/extension-ordered-list";
import BulletList from "@tiptap/extension-bullet-list";
import History from "@tiptap/extension-history";
import Placeholder from "@tiptap/extension-placeholder";

document.addEventListener("alpine:init", () => {
    Alpine.data("editor", (initialContent) => {
        let editor; // Alpine's reactive engine automatically wraps component properties in proxy objects. Attempting to use a proxied editor instance to apply a transaction will cause a "Range Error: Applying a mismatched transaction", so be sure to unwrap it using Alpine.raw(), or simply avoid storing your editor as a component property, as shown in this example.

        return {
            content: initialContent,
            updatedAt: Date.now(), // force Alpine to rerender on selection change
            isLoaded() {
                return editor;
            },
            isActive(type, opts = {}) {
                return editor.isActive(type, opts);
            },
            toggleUnderline() {
                editor.chain().focus().toggleUnderline().run();
            },
            toggleBold() {
                editor.chain().focus().toggleBold().run();
            },
            toggleItalic() {
                editor.chain().focus().toggleItalic().run();
            },
            toggleStrike() {
                editor.chain().focus().toggleStrike().run();
            },
            toggleOrderedList() {
                editor.chain().focus().toggleOrderedList().run();
            },
            toggleBulletList() {
                editor.chain().focus().toggleBulletList().run();
            },
            undo() {
                editor.chain().focus().undo().run();
            },
            redo() {
                editor.chain().focus().redo().run();
            },
            init() {
                const _this = this;

                editor = new Editor({
                    element: this.$refs.element,
                    extensions: [
                        Document,
                        Paragraph,
                        Text,
                        Strike,
                        Italic,
                        Bold.configure({
                            HTMLAttributes: {
                                class: "font-semibold",
                            },
                        }),
                        Underline,
                        BulletList.configure({
                            HTMLAttributes: {
                                class: "ps-4 list-outside list-disc *:pl-2",
                            },
                        }),
                        OrderedList.configure({
                            HTMLAttributes: {
                                class: "ps-4 list-outside list-decimal *:pl-2",
                            },
                        }),
                        ListItem,
                        History,
                        Placeholder.configure({
                            placeholder:
                                this.$refs.element.getAttribute("placeholder"),
                        }),
                    ],
                    content: initialContent,
                    onCreate({ editor }) {
                        _this.updatedAt = Date.now();
                    },
                    onUpdate({ editor }) {
                        _this.updatedAt = Date.now();
                        _this.content = editor.getHTML(); // Update Alpine.js content
                    },
                    onSelectionUpdate({ editor }) {
                        _this.updatedAt = Date.now();
                    },
                });
            },
        };
    });
});

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.start();

/*
Flowbite Datepicker
*/
document.querySelectorAll("input[datepicker]").forEach((datepickerEl) => {
    var title = datepickerEl.hasAttribute("datepicker-title");
    var minDate = datepickerEl.hasAttribute("datepicker-min-date");
    var maxDate = datepickerEl.hasAttribute("datepicker-max-date");
    var orientation = datepickerEl.hasAttribute("datepicker-orientation");
    var options = {
        todayBtn: true,
        clearBtn: true,
        autohide: true,
        todayBtnMode: 1,
        format: "dd-mm-yy",
    };
    if (title) {
        options.title = datepickerEl.getAttribute("datepicker-title");
    }
    if (minDate) {
        options.minDate = datepickerEl.getAttribute("datepicker-min-date");
    }
    if (maxDate) {
        options.maxDate = datepickerEl.getAttribute("datepicker-max-date");
    }
    if (orientation) {
        options.orientation = datepickerEl.getAttribute(
            "datepicker-orientation"
        );
    }

    new Datepicker(datepickerEl, options);
});

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

/*
Tom Select Js
*/
TomSelect.define("remove_button", TomSelect_remove_button);
TomSelect.define("caret_position", TomSelect_caret_position);

document.querySelectorAll("select").forEach((el) => {
    if (el.hasAttribute("multiple")) {
        if (el.hasAttribute("readonly")) {
            new TomSelect(el, {}).lock();
        } else {
            new TomSelect(el, {
                plugins: ["remove_button", "caret_position"],
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc",
                },
            });
        }
    } else {
        if (el.hasAttribute("readonly")) {
            new TomSelect(el, {}).lock();
        } else {
            new TomSelect(el, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc",
                },
            });
        }
    }
});

/*
Filepond
*/
FilePond.registerPlugin(
    // encodes the file as base64 data
    FilePondPluginFileEncode,

    // validates the size of the file
    FilePondPluginFileValidateSize,

    // corrects mobile image orientation
    FilePondPluginImageExifOrientation,

    // previews dropped images
    FilePondPluginImagePreview,

    // validates the type of the file
    FilePondPluginFileValidateType
);

// Select the file input and use create() to turn it into a pond
document.querySelectorAll("input[type='file']").forEach((filepondEl) => {
    FilePond.create(filepondEl, {
        labelIdle: `<div class="flex flex-col cursor-pointer items-center justify-center pt-5 pb-6">
        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
        </svg>
        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
        <p class="text-xs text-gray-500 dark:text-gray-400">pdf, docx, xlsx, pptx, png, jpg, zip (max. 25 MB)</p>
        </div>`,
        credits: false,
    }).setOptions({
        storeAsFile: true,
        maxFiles: filepondEl.getAttribute("max-files"),
        maxFileSize: "25MB",
        // use mime type
        acceptedFileTypes: [
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-excel",
            "text/csv",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-powerpoint",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "image/png",
            "image/jpeg",
            "application/zip",
            "application/x-zip-compressed",
            "application/x-compressed",
        ],
        // validation label to replace mime
        fileValidateTypeLabelExpectedTypesMap: {
            "application/pdf": ".pdf",
            "application/msword": ".docx",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                ".docx",
            "application/vnd.ms-excel": ".xlsx",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                ".xlsx",
            "text/csv": ".csv",
            "application/vnd.ms-powerpoint": ".pptx",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation":
                ".pptx",
            "image/png": ".png",
            "image/jpeg": ".jpg",
            "application/zip": ".zip",
            "application/x-zip-compressed": ".zip",
            "application/x-compressed": ".zip",
        },
    });
});

// Style the dark mode
const backgrounds = document.querySelectorAll(".filepond--panel-root");
backgrounds.forEach((background) => {
    background.classList.add("dark:text-gray-400");
    background.classList.add("dark:bg-gray-700");
});

const labels = document.querySelectorAll(".filepond--drop-label");
labels.forEach((label) => {
    label.classList.add("dark:text-gray-400");
    label.classList.add("dark:hover:bg-gray-600");
    label.classList.add("hover:rounded-lg");
    label.classList.add("hover:bg-gray-100");
});
