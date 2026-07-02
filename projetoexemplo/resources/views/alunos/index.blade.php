{{-- VIEW: alunos/index.blade.php - Lista de alunos com busca e paginação --}}

<x-app-layout>
    @section('title', 'Alunos')
    @section('subtitle', 'Gerencie os membros da academia')

    <div class="space-y-4">

        {{-- Barra de ações: busca + botão novo --}}
        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">

            {{-- Formulário de busca
                 method="GET" → envia como parâmetro na URL (?busca=texto)
                 action → para onde o form é enviado (a própria página)
            --}}
            <form method="GET" action="{{ route('alunos.index') }}" class="flex gap-2 w-full sm:w-auto">
                <input
                    type="text"
                    name="busca"
                    value="{{ $busca }}"
                    placeholder="Buscar por nome, email ou CPF..."
                    class="form-input w-full sm:w-80"
                >
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                @if($busca)
                    {{-- Link para limpar a busca --}}
                    <a href="{{ route('alunos.index') }}" class="btn-secondary">Limpar</a>
                @endif
            </form>

            {{-- Botão Novo Aluno --}}
            <a href="{{ route('alunos.create') }}" class="btn-primary flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Aluno
            </a>
        </div>

        {{-- Informação de busca ativa --}}
        @if($busca)
            <p class="text-gray-400 text-sm">
                Mostrando resultados para: <span class="text-white font-medium">"{{ $busca }}"</span>
                ({{ $alunos->total() }} encontrado(s))
            </p>
        @endif

        {{-- Grid de cards dos alunos --}}
        @if($alunos->isEmpty())
            {{-- Estado vazio --}}
            <div class="card text-center py-12">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <p class="text-gray-400 mb-3">Nenhum aluno encontrado</p>
                <a href="{{ route('alunos.create') }}" class="btn-primary">Cadastrar primeiro aluno</a>
            </div>
        @else
            {{-- Grid responsivo de cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($alunos as $aluno)
                    <div class="card hover:border-orange-500 hover:border-opacity-50 transition-all duration-200 group">

                        {{-- Topo do card: avatar + status --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($aluno->nome, 0, 1)) }}
                            </div>
                            {{-- Status ativo/inativo --}}
                            @if($aluno->ativo)
                                <span class="badge-success">Ativo</span>
                            @else
                                <span class="badge-danger">Inativo</span>
                            @endif
                        </div>

                        {{-- Dados do aluno --}}
                        <h3 class="text-white font-semibold text-sm mb-1 truncate">{{ $aluno->nome }}</h3>
                        <p class="text-gray-400 text-xs truncate mb-2">{{ $aluno->email }}</p>

                        @if($aluno->telefone)
                            <p class="text-gray-500 text-xs mb-3">{{ $aluno->telefone }}</p>
                        @endif

                        {{-- Matrícula ativa
                             $aluno->matriculas já veio carregado via Eager Loading no controller.
                             ->first() pega a primeira (mais recente, pois carregamos com ->latest())
                             Isso evita o problema N+1 e também o bug de escopo do @php no Blade. --}}
                        @if($aluno->matriculas->first())
                            <div class="bg-green-500 bg-opacity-10 border border-green-500 border-opacity-20 rounded-lg px-3 py-1.5 mb-3">
                                <p class="text-green-400 text-xs font-medium">{{ $aluno->matriculas->first()->plano->nome }}</p>
                                <p class="text-gray-500 text-xs">Vence {{ $aluno->matriculas->first()->data_fim->format('d/m/Y') }}</p>
                            </div>
                        @else
                            <div class="bg-gray-800 rounded-lg px-3 py-1.5 mb-3">
                                <p class="text-gray-500 text-xs">Sem matrícula ativa</p>
                            </div>
                        @endif

                        {{-- Ações do card --}}
                        <div class="flex gap-2">
                            {{-- route('alunos.show', $aluno) → gera /alunos/{id} --}}
                            <a href="{{ route('alunos.show', $aluno) }}"
                               class="flex-1 text-center text-xs bg-gray-700 hover:bg-gray-600 text-white py-1.5 rounded-lg transition-colors">
                                Ver perfil
                            </a>
                            <a href="{{ route('alunos.edit', $aluno) }}"
                               class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg transition-colors">
                                ✏️
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- PAGINAÇÃO
                 $alunos->links() → renderiza os botões de página automaticamente
                 O Breeze já configura o estilo --}}
            <div class="mt-6">
                {{ $alunos->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
