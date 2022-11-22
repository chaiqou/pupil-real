module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                blue: {
                    100: "#d9f3ff",
                    200: "#b4e6ff",
                    300: "#8edaff",
                    400: "#69cdff",
                    500: "#43c1ff",
                    600: "#369acc",
                    700: "#287499",
                    800: "#1b4d66",
                    900: "#0d2733",
                },
            },
        },
    },
    corePlugins: {
        aspectRatio: false,
    },
};
