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
        'lily-pink': '#f9c3cd',
        'lily-pink-dark': '#e99aad',
        'lily-brown': '#6d4c41',
        "lily-footer-bg": "#D6929F",
      },
      fontFamily: {
        'poppins': ['Poppins', 'sans-serif'],
      }
    },
  },
  plugins: [],
}