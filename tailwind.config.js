/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    50:  '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                    950: '#450a0a',
                },
                fire: {
                    orange: '#ea580c',
                    amber:  '#d97706',
                    yellow: '#eab308',
                },
                surface: {
                    DEFAULT: '#ffffff',
                    alt:     '#f9fafb',
                    dark:    '#111827',
                },
            },
            fontFamily: {
                sans:    ['Inter', 'Segoe UI', 'system-ui', '-apple-system', 'sans-serif'],
                heading: ['Inter', 'Segoe UI', 'system-ui', '-apple-system', 'sans-serif'],
                mono:    ['JetBrains Mono', 'Fira Code', 'ui-monospace', 'monospace'],
            },
            borderRadius: {
                btn:   '0.5rem',
                card:  '0.75rem',
                modal: '1rem',
            },
            boxShadow: {
                card:       '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06)',
                'card-hover': '0 10px 25px rgba(0,0,0,0.1), 0 4px 10px rgba(0,0,0,0.05)',
                dropdown:   '0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05)',
            },
            animation: {
                'fade-in':    'fade-in 0.5s ease-out',
                'slide-up':   'slide-up 0.5s ease-out',
                'slide-down': 'slide-down 0.3s ease-out',
                'bounce-in':  'bounce-in 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55)',
            },
            keyframes: {
                'fade-in': {
                    from: { opacity: '0' },
                    to:   { opacity: '1' },
                },
                'slide-up': {
                    from: { opacity: '0', transform: 'translateY(20px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
                'slide-down': {
                    from: { opacity: '0', transform: 'translateY(-10px)' },
                    to:   { opacity: '1', transform: 'translateY(0)' },
                },
                'bounce-in': {
                    from:  { opacity: '0', transform: 'scale(0.3)' },
                    '50%': { transform: 'scale(1.05)' },
                    '70%': { transform: 'scale(0.9)' },
                    to:    { opacity: '1', transform: 'scale(1)' },
                },
            },
        },
    },
    plugins: [],
};
