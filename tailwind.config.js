/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './app/Views/**/*.php',
    './public/assets/js/**/*.js',
    './resources/css/app.css',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          DEFAULT: '#0084ff',
          light:   '#38bdf8',
          dark:    '#0059ff',
          glow:    '#00c3ff',
          50:      '#f0f8ff',
          900:     '#0a2240',
        },
        navy: {
          DEFAULT: '#0f172a',
          800:     '#1e293b',
          600:     '#475569',
          400:     '#94a3b8',
          200:     '#e2e8f0',
        },
      },
      fontFamily: {
        sans: ['Montserrat', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif'],
      },
      borderRadius: {
        pill:   '999px',
        card:   '20px',
        subtle: '12px',
      },
      boxShadow: {
        '3d':        '0 20px 40px -15px rgba(0,0,0,0.18), 0 0 0 1px rgba(0,0,0,0.05)',
        'glow-sm':   '0 0 10px #0084ff',
        'glow-md':   '0 0 20px rgba(0,132,255,0.5)',
        'card-hover':'0 12px 30px rgba(14,165,233,0.12)',
        'glass':     '0 8px 32px rgba(0,0,0,0.12)',
      },
      backdropBlur: {
        xs: '3px',
      },
      keyframes: {
        slide: {
          'from': { transform: 'translateX(-100%)' },
          'to':   { transform: 'translateX(300%)' },
        },
        bob: {
          '0%,100%': { transform: 'translate(-50%, 0)' },
          '50%':     { transform: 'translate(-50%, 6px)' },
        },
        'wheel-bounce': {
          '0%':   { transform: 'translateY(0)',   opacity: '1' },
          '60%':  { transform: 'translateY(8px)', opacity: '0.2' },
          '100%': { transform: 'translateY(0)',   opacity: '1' },
        },
      },
      animation: {
        slide:          'slide 1.1s ease-in-out infinite',
        bob:            'bob 2.2s ease-in-out infinite',
        'wheel-bounce': 'wheel-bounce 1.5s ease-in-out infinite',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
