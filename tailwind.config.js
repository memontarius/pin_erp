/** @type {import('tailwindcss').Config} */
export default {
    mode: 'jit',
    content: [
        "./resources/**/*.js",
        "./resources/**/*.blade.php",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {
            colors: {
                'dark-gray': '#374050',
                'ultra-sky': {
                   400: '#0FC5FF',
                   500: '#08b2e8',
                },
            },
            fontFamily: {
                sans: ['Roboto', 'sans-serif']
            },
            fontSize: {
                sm: '11px'
            }
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
}

