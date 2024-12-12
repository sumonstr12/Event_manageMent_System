module.exports = {
  darkMode: 'class',
  content: [
    "./*.php",
    "./partials/**/*.php",
  ],

  theme: {
    extend: {
        colors: {
            blue: {
                light: '#3b82f6',
                DEFAULT: '#2563eb',
                dark: '#1e3a8a',
            },
        },
    },
  },
  plugins: [
    require('daisyui'),
  ],
};
