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
            colors: {
                // Główne kolory dla Tailwind
                'primary': '#e8eaed',
                'secondary': '#bdc1c6',
                'accent': '#8ab4f8',
                'glass-border': 'rgba(255, 255, 255, 0.1)',
                'glass-hover': 'rgba(255, 255, 255, 0.1)',
                
                // Motyw ciemny (domyślny)
                dark: {
                    bg: {
                        primary: '#131314',
                        secondary: '#1f2023',
                    },
                    accent: '#8ab4f8',
                    text: {
                        primary: '#e8eaed',
                        secondary: '#bdc1c6',
                    },
                    border: 'rgba(255, 255, 255, 0.1)',
                    glass: {
                        bg: 'rgba(42, 45, 50, 0.6)',
                        border: 'rgba(255, 255, 255, 0.1)',
                    },
                },
                // Motyw jasny
                light: {
                    bg: {
                        primary: '#f8f9fa',
                        secondary: '#ffffff',
                    },
                    accent: '#1a73e8',
                    text: {
                        primary: '#202124',
                        secondary: '#5f6368',
                    },
                    border: 'rgba(0, 0, 0, 0.1)',
                    glass: {
                        bg: 'rgba(255, 255, 255, 0.6)',
                        border: 'rgba(0, 0, 0, 0.1)',
                    },
                },
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
