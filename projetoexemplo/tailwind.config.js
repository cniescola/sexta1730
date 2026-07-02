/*
|--------------------------------------------------------------------------
| tailwind.config.js - Configuração do Tailwind CSS
|--------------------------------------------------------------------------
|
| O que é Tailwind CSS?
| ----------------------
| Tailwind é um framework CSS "utility-first". Em vez de classes prontas
| como "btn-primary", você combina classes pequenas:
|   class="bg-blue-500 text-white px-4 py-2 rounded"
|
| Isso dá muito mais controle sobre o design.
|
| theme.extend.colors → adiciona cores customizadas sem remover as padrão
| Depois você pode usar: bg-gym-dark, text-gym-accent, etc.
|
*/

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // content → quais arquivos o Tailwind vai escanear para gerar o CSS
    // Apenas as classes USADAS nesses arquivos vão para o CSS final
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // Fonte principal do sistema
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            // ============================================================
            // PALETA DE CORES DO TEMA ACADEMIA (Dark Mode)
            // ============================================================
            colors: {
                // Cores base do layout escuro
                'gym-dark':    '#0f0f0f',  // Fundo principal
                'gym-sidebar': '#1a1a1a',  // Sidebar
                'gym-card':    '#1e1e1e',  // Cards e header
                'gym-border':  '#2a2a2a',  // Bordas

                // Cor de destaque (laranja energético)
                'gym-accent':  '#f97316',  // orange-500

                // Variações do accent
                'gym-accent-dark':  '#ea6c0a',
                'gym-accent-light': '#fb923c',

                // Cor de texto secundário
                'gym-muted': '#6b7280',
            },
        },
    },

    plugins: [forms],
};
