/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'violet': '#6100fc',
                'violet-500': 'rgba(97, 0, 252, 0.5)',
            },

        },
    },
    plugins: [],
}

