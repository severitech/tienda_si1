/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        // Ejemplo: agrega un color personalizado
        'severitech': '#0f172a',
      },
    },
  },
  plugins: [],
}
