/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    variants: {
        extend: {
            visibility: ['group-hover'],
        }
    },
    theme: {
        extend: {},
    },
    plugins: [],
}

