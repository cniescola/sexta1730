{{--
|--------------------------------------------------------------------------
| LAYOUT GUEST: layouts/guest.blade.php
|--------------------------------------------------------------------------
|
| Este layout é usado pelas páginas de autenticação (login, registro, etc.)
| É chamado de "guest" pois é para usuários não autenticados (visitantes).
|
| Diferença entre layouts:
| - app.blade.php   → layout com sidebar, para usuários logados
| - guest.blade.php → layout minimalista, para login/registro
|
--}}
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'FitManager Pro') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gym-dark">

        {{-- Layout dividido em 2 colunas no desktop: ilustração + formulário --}}
        <div class="min-h-screen flex">

            {{-- COLUNA ESQUERDA: Decorativa (oculta no mobile) --}}
            <div class="hidden lg:flex lg:w-1/2 bg-gym-sidebar relative overflow-hidden items-center justify-center">

                {{-- Fundo decorativo com gradiente e padrão --}}
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600 via-orange-500 to-red-600 opacity-10"></div>

                {{-- Círculos decorativos de fundo --}}
                <div class="absolute top-20 left-20 w-64 h-64 bg-orange-500 rounded-full opacity-5 blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-orange-400 rounded-full opacity-5 blur-3xl"></div>

                {{-- Conteúdo central da coluna --}}
                <div class="relative z-10 text-center px-12">

                    {{-- Ícone / Logo --}}
                    <div class="w-24 h-24 bg-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-orange-500/30">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>

                    <h1 class="text-4xl font-black text-white mb-3">FitManager Pro</h1>
                    <p class="text-gray-400 text-lg mb-8">Sistema completo de gestão de academia</p>

                    {{-- Features da plataforma --}}
                    <div class="space-y-3 text-left">
                        @foreach([
                            'Gestão completa de alunos',
                            'Controle de planos e matrículas',
                            'Registro de frequência (check-in)',
                            'Dashboard com estatísticas em tempo real',
                        ] as $feature)
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-sm">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- COLUNA DIREITA: Formulário de autenticação --}}
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="w-full max-w-md">

                    {{-- Logo no mobile (aparece só quando a col. esquerda é oculta) --}}
                    <div class="lg:hidden text-center mb-8">
                        <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">FitManager Pro</h1>
                    </div>

                    {{-- Card do formulário --}}
                    <div class="auth-card">
                        {{-- $slot → conteúdo vindo dos arquivos auth/login.blade.php, etc. --}}
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
