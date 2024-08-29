/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    light: "#1A56DB",
                    dark: "#A4CAFE",
                },
                alert: {
                    success: "73CA5C",
                    warning: "#F9CC00",
                    danger: "#FF0000",
                    "danger-hover": "#df0000",
                    "danger-dark": "#b20000",
                    "danger-hover-dark": "#a00000",
                },
            },
        },
    },
    plugins: [
        require("flowbite/plugin")({
            charts: true,
        }),
    ],
};
