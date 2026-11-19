import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                amber: {
                    400: '#FED83A',
                    500: '#FED83A',
                },
                unerd: {
                    black: '#09090B',
                    'black-active': '#27272A',
                    ink: '#09090B',
                    body: '#3F3F46',
                    'body-strong': '#18181B',
                    muted: '#71717A',
                    'muted-soft': '#A1A1AA',
                    hairline: '#E4E4E7',
                    'hairline-soft': '#F4F4F5',
                    canvas: '#FFFFFF',
                    'surface-soft': '#F8F8FA',
                    'surface-card': '#F4F4F5',
                    'surface-strong': '#E4E4E7',
                    'surface-dark': '#09090B',
                    'surface-dark-elevated': '#18181B',
                    volt: '#FED83A',
                    'volt-soft': '#FFFBEA',
                    'volt-dark': '#B45309',
                    yellow: '#FED83A',
                    blaze: '#FF5500',
                    'blaze-soft': '#FFF7ED',
                    cobalt: '#2563EB',
                    'cobalt-soft': '#EFF6FF',
                    gum: '#C8A98E',
                    'gum-soft': '#FAF7F2',
                    concrete: '#E4E4E7',
                },
            },
            fontFamily: {
                display: ['"Plus Jakarta Sans"', 'Space Grotesk', 'Inter', ...defaultTheme.fontFamily.sans],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                xs: '4px',
                sm: '6px',
                md: '8px',
                lg: '12px',
                xl: '16px',
                pill: '9999px',
            },
        },
    },

    plugins: [forms],
};
