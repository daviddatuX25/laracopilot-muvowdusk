/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // Enable class-based dark mode
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './app/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        // Custom theme colors using CSS variables
        primary: 'var(--color-primary)',
        'primary-hover': 'var(--color-primary-hover)',
        secondary: 'var(--color-secondary)',
        'secondary-hover': 'var(--color-secondary-hover)',
        accent: 'var(--color-accent)',
        'accent-hover': 'var(--color-accent-hover)',
        background: 'var(--color-background)',
        'background-secondary': 'var(--color-background-secondary)',
        surface: 'var(--color-surface)',
        'surface-hover': 'var(--color-surface-hover)',
        text: 'var(--color-text)',
        'text-secondary': 'var(--color-text-secondary)',
        border: 'var(--color-border)',
        'border-light': 'var(--color-border-light)',
      },
    },
  },
}
