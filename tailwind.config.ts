import type { Config } from 'tailwindcss'

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './app/Livewire/**/*.php',
  ],
} satisfies Config
