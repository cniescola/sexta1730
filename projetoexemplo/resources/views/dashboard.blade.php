{{--
|--------------------------------------------------------------------------
| VIEW: dashboard.blade.php
|--------------------------------------------------------------------------
|
| O que é uma View Blade?
| ----------------------
| Views são os arquivos HTML da aplicação. O Blade é o motor de templates
| do Laravel - é HTML com superpoderes PHP.
|
| Sintaxe Blade:
| - {{ $variavel }}      → exibe valor (com proteção XSS automática)
| - @if/@else/@endif     → condicionais
| - @foreach/@endforeach → loops
| - @forelse/@empty      → loop com fallback para lista vazia
| - @section/@endsection → define seções para o layout
|
| <x-app-layout> → usa o layout em layouts/app.blade.php
|
--}}

<x-app-layout>
    @section('title', 'Dashboard')
    @section('subtitle', 'Visão geral da academia')

    <div class="space-y-6">

        {{-- ================================================================
             CARDS DE ESTATÍSTICAS
             ================================================================
             grid-cols-1: 1 coluna no mobile
             sm:grid-cols-2: 2 colunas no tablet
             lg:grid-cols-4: 4 colunas no desktop
        --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Card: Total de Alunos --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-blue-500 bg-opacity-20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="badge-info">Total</span>
                </div>
                {{-- $totalAlunos vem do DashboardController --}}
                <p class="text-3xl font-bold text-white">{{ $totalAlunos }}</p>
                <p class="text-gray-400 text-sm mt-1">Alunos cadastrados</p>
            </div>

            {{-- Card: Alunos Ativos --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-green-500 bg-opacity-20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="badge-success">Ativos</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ $alunosAtivos }}</p>
                <p class="text-gray-400 text-sm mt-1">Alunos ativos</p>
            </div>

            {{-- Card: Matrículas Ativas --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-orange-500 bg-opacity-20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="badge bg-orange-500 bg-opacity-20 text-orange-400">Ativas</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ $matriculasAtivas }}</p>
                <p class="text-gray-400 text-sm mt-1">Matrículas vigentes</p>
            </div>

            {{-- Card: Check-ins Hoje --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-purple-500 bg-opacity-20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="badge bg-purple-500 bg-opacity-20 text-purple-400">Hoje</span>
                </div>
                <p class="text-3xl font-bold text-white">{{ $checkinHoje }}</p>
                <p class="text-gray-400 text-sm mt-1">Check-ins hoje</p>
            </div>
        </div>

        {{-- ================================================================
             GRID: Check-ins + Vencimentos
             ================================================================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Check-ins Recentes --}}
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Check-ins Recentes</h3>
                    <a href="{{ route('checkins.index') }}" class="text-orange-400 text-sm hover:underline">Ver todos</a>
                </div>

                {{-- @forelse → foreach com fallback quando lista vazia --}}
                @forelse($checkinRecentes as $checkin)
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-800 last:border-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                            {{ strtoupper(substr($checkin->aluno->nome, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $checkin->aluno->nome }}</p>
                            <p class="text-gray-500 text-xs">
                                {{-- format() formata datas com Carbon --}}
                                {{ $checkin->entrada->format('H:i') }} - {{ $checkin->entrada->format('d/m/Y') }}
                            </p>
                        </div>
                        @if($checkin->saida)
                            <span class="badge-info text-xs">Saiu {{ $checkin->saida->format('H:i') }}</span>
                        @else
                            <span class="badge-success text-xs">Presente</span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-6">Nenhum check-in registrado ainda</p>
                @endforelse
            </div>

            {{-- Matrículas Vencendo --}}
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Vencendo em 7 dias</h3>
                    <a href="{{ route('matriculas.index') }}" class="text-orange-400 text-sm hover:underline">Ver matrículas</a>
                </div>

                @forelse($matriculasVencendo as $matricula)
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-800 last:border-0">
                        <div class="w-8 h-8 bg-yellow-500 bg-opacity-20 rounded-full flex items-center justify-center text-xs font-bold text-yellow-400 flex-shrink-0">
                            {{ strtoupper(substr($matricula->aluno->nome, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $matricula->aluno->nome }}</p>
                            <p class="text-gray-500 text-xs">{{ $matricula->plano->nome }}</p>
                        </div>
                        <span class="badge-warning text-xs">{{ $matricula->dias_restantes }}d</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-6">Nenhuma matrícula vencendo nos próximos 7 dias</p>
                @endforelse
            </div>
        </div>

        {{-- Ações Rápidas --}}
        <div class="card">
            <h3 class="text-white font-semibold mb-4">Ações Rápidas</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('alunos.create') }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Aluno
                </a>
                <a href="{{ route('matriculas.create') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Matrícula
                </a>
                <a href="{{ route('planos.create') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Plano
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
