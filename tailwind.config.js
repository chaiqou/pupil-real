module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                indigo: {
                    50: '#f5f0ff',
                    100: '#eee4ff',
                    200: '#decdff',
                    300: '#c7a5ff',
                    400: '#af72ff',
                    500: '#993aff',
                    600: '#9312ff',
                    700: '#7d00eb',
                    800: '#6900c7',
                    900: '#5e02b0',
                    DEFAULT: '#6900C7'
                },
                blue: {
                    50: '#ebf7ff',
                    100: '#d6efff',
                    200: '#b3e3ff',
                    300: '#85d6ff',
                    400: '#47bcff',
                    500: '#1f9aff',
                    600: '#057aff',
                    700: '#0060f0',
                    800: '#084dc4',
                    900: '#0d469c',
                    DEFAULT: '#0061F2'
                },
            },
        },
    },
    corePlugins: {
        aspectRatio: false,
    },
};
