import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            textColor: {
                primary: 'var(--text-primary)',
                secondary: 'var(--text-secondary)',
                accent: 'var(--accent)',
            },
            backgroundColor: {
                primary: 'var(--bg-primary)',
                secondary: 'var(--bg-secondary)',
                accent: 'var(--accent)',
            },
            borderColor: {
                DEFAULT: 'var(--border)',
                glass: 'var(--glass-border)',
            },
            colors: {
                // Zachowujemy accent jako ogólny kolor, jeśli potrzebny
                accent: 'var(--accent)',
            },
            backdropBlur: {
                'liquid': '24px',
            },
            borderRadius: {
                'liquid': '16px',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'glow': 'glow 2s ease-in-out infinite alternate',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                glow: {
                    '0%': { boxShadow: '0 0 5px rgba(138, 180, 248, 0.2)' },
                    '100%': { boxShadow: '0 0 20px rgba(138, 180, 248, 0.4)' },
                },
            },
        },
    },
    plugins: [],
};
