import typography from '@tailwindcss/typography'

export default {
  content: [
    './resources/**/*.antlers.html',
    './resources/**/*.blade.php',
    './content/**/*.md'
  ],
  theme: {
    extend: {
        colors: {
            'black': '#12151E',
            'hot-pink': '#fd2d78'
        },
        fontFamily: {
            display: "var(--font-display)",
            body: "var(--font-body)",
        }
    },
  },
  plugins: [
    typography,
  ],
  important: true
}
