/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          light: '#4da6ff',
          DEFAULT: '#2563eb',
          dark: '#1e40af',
        },
        secondary: {
          light: '#f87171',
          DEFAULT: '#ef4444',
          dark: '#b91c1c',
        },
        success: {
          light: '#4ade80',
          DEFAULT: '#22c55e',
          dark: '#15803d',
        },
        warning: {
          light: '#fcd34d',
          DEFAULT: '#f59e0b',
          dark: '#b45309',
        },
      },
    },
  },
  plugins: [],
}