{{--
|--------------------------------------------------------------------------
| LAYOUT PRINCIPAL: layouts/app.blade.php
|--------------------------------------------------------------------------
|
| O que é um Layout Blade?
| ------------------------
| Em vez de repetir o HTML do cabeçalho, menu e rodapé em cada página,
| criamos um layout "pai" que todas as páginas herdam.
|
| O $slot é onde o conteúdo específico de cada página vai aparecer.
|
| Como usar este layout em outra view:
|   <x-app-layout>
|       <x-slot name="header">Título da Página</x-slot>
|       Conteúdo da página aqui
|   </x-app-layout>
|
| Componentes Blade (x-...):
| A tag <x-app-layout> busca o arquivo: views/layouts/app.blade.php
| As tags <x-slot> definem variáveis disponíveis no layout pai.
|
--}}
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- csrf-token: Proteção contra CSRF (Cross-Site Request Forgery)
             Ataques onde sites maliciosos enviam requisições em nome do usuário.
             O Laravel verifica este token em todo POST/PUT/DELETE. --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- config('app.name') lê APP_NAME do arquivo .env --}}
        <title>{{ config('app.name', 'FitManager') }} - @yield('title', 'Painel')</title>

        <!-- Google Fonts - Fonte moderna para academias -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        {{-- @vite → processa os assets (CSS/JS) pelo Vite (bundler moderno)
             Equivale a incluir os arquivos compilados em produção --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- @stack permite que views filhas injetem CSS adicional aqui --}}
        @stack('styles')
    </head>

    <body class="font-sans antialiased bg-gym-dark text-white">

        {{-- ================================================================
             SIDEBAR - Menu lateral fixo
             ================================================================ --}}
        <div class="flex h-screen overflow-hidden">

            {{-- SIDEBAR --}}
            <aside class="sidebar w-64 bg-gym-sidebar flex flex-col flex-shrink-0 shadow-2xl">

                {{-- Logo / Nome da Academia --}}
                <div class="sidebar-logo p-6 border-b border-gray-700">
                    <div class="flex items-center gap-3">
                        {{-- Ícone de haltere em SVG --}}
                        <div class="w-10 h-10 bg-gym-accent rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-lg leading-tight">FitManager</h1>
                            <p class="text-gray-400 text-xs">Pro Academia</p>
                        </div>
                    </div>
                </div>

                {{-- Menu de Navegação --}}
                <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

                    {{-- Seção: Geral --}}
                    <div class="mb-4">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider px-3 mb-2">Geral</p>

                        {{-- Item de menu: Dashboard
                             request()->routeIs('dashboard') → verifica se a rota atual é 'dashboard'
                             Usado para destacar o item ativo no menu --}}
                        <a href="{{ route('dashboard') }}"
                           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>

                    {{-- Seção: Gestão --}}
                    <div class="mb-4">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider px-3 mb-2">Gestão</p>

                        <a href="{{ route('alunos.index') }}"
                           class="nav-item {{ request()->routeIs('alunos.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Alunos</span>
                        </a>

                        <a href="{{ route('planos.index') }}"
                           class="nav-item {{ request()->routeIs('planos.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Planos</span>
                        </a>

                        <a href="{{ route('matriculas.index') }}"
                           class="nav-item {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Matrículas</span>
                        </a>

                        <a href="{{ route('checkins.index') }}"
                           class="nav-item {{ request()->routeIs('checkins.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span>Check-ins</span>
                        </a>
                    </div>
                </nav>

                {{-- Rodapé da Sidebar: Info do usuário logado --}}
                <div class="p-4 border-t border-gray-700">
                    <div class="flex items-center gap-3">
                        {{-- Avatar com inicial do nome --}}
                        <div class="w-9 h-9 bg-gym-accent rounded-full flex items-center justify-center font-bold text-sm">
                            {{-- auth()->user() → retorna o objeto do usuário logado
                                 substr(str, inicio, qtd) → pega a 1ª letra do nome --}}
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">Administrador</p>
                        </div>
                        {{-- Botão de logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf {{-- Diretiva que gera o campo hidden com o CSRF token --}}
                            <button type="submit" class="text-gray-400 hover:text-white transition-colors" title="Sair">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- ================================================================
                 CONTEÚDO PRINCIPAL
                 ================================================================ --}}
            <div class="flex-1 flex flex-col overflow-hidden">

                {{-- Barra superior --}}
                <header class="bg-gym-card border-b border-gray-700 px-6 py-4 flex items-center justify-between flex-shrink-0">
                    <div>
                        {{-- @yield('title') → slot para o título vindo das views filhas --}}
                        <h2 class="text-xl font-bold text-white">@yield('title', 'Dashboard')</h2>
                        <p class="text-gray-400 text-sm">@yield('subtitle', '')</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-400 text-sm">{{ now()->format('d/m/Y') }}</span>
                    </div>
                </header>

                {{-- Área de conteúdo com scroll --}}
                <main class="flex-1 overflow-y-auto p-6">

                    {{-- MENSAGENS FLASH (sucesso/erro)
                         session('success') → mensagem passada via ->with('success', '...')
                         Aparece apenas uma vez e depois some --}}
                    @if(session('success'))
                        <div class="alert-success mb-4 flex items-center gap-2 bg-green-500 bg-opacity-20 border border-green-500 text-green-400 px-4 py-3 rounded-lg">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 flex items-center gap-2 bg-red-500 bg-opacity-20 border border-red-500 text-red-400 px-4 py-3 rounded-lg">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- $slot → aqui vai o conteúdo específico de cada página --}}
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
