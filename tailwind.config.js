import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                hearth: {
                    50:  '#FAF6F1',
                    100: '#F0E6D8',
                    200: '#E5DDD3',
                    300: '#C4AA8B',
                    400: '#8B7355',
                    500: '#B85C38',
                    600: '#5C3D2E',
                    700: '#4A3125',
                    800: '#2C1810',
                    900: '#1A0F0A',
                },
                accent: '#E8C07D',
                star: '#E8A84C',
            },
        },
    },

    plugins: [forms],
};
