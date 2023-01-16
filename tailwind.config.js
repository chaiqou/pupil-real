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
                    50: '#F9EBFF',
                    100: '#F1D6FF',
                    200: '#E0A9FE',
                    300: '#CA72FD',
                    400: '#AF3CFB',
                    500: '#9A15F9',
                    600: '#820CE9',
                    700: '#660CC0',
                    800: '#52129B',
                    900: '#44127D',
                    DEFAULT: '#6900C7'
                  },
                  blue: {
                    50: '#D3E5FF',
                    100: '#BFD9FF',
                    200: '#96C0FF',
                    300: '#6DA8FF',
                    400: '#458FFF',
                    500: '#1C77FF',
                    600: '#0061F2',
                    700: '#004BBA',
                    800: '#003482',
                    900: '#001E4A',
                    DEFAULT:'#0061F2'
                  },
            },
        },
    },
    corePlugins: {
        aspectRatio: false,
    },
};
