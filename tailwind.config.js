/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './app/Filament/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    primary: 'var(--color-primary)',
                    secondary: 'var(--color-secondary)',
                    accent: 'var(--color-accent)',
                },
            },
            fontFamily: {
                heading: ['var(--font-heading)'],
                body: ['var(--font-body)'],
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'fade-up': 'fade-up 700ms ease both',
            },
        },
    },
    plugins: [],
};
