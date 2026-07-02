{{-- VIEW: planos/index.blade.php - Lista de planos --}}

<x-app-layout>
    @section('title', 'Planos')
    @section('subtitle', 'Gerencie os planos da academia')

    <div class="space-y-4">
        <div class="flex justify-end">
            <a href="{{ route('planos.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Novo Plano
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($planos as $plano)
                <div class="card group hover:border-orange-500 hover:border-opacity-50 transition-all duration-200">

                    {{-- Topo do card com status --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 bg-orange-500 bg-opacity-20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        @if($plano->ativo)
                            <span class="badge-success">Ativo</span>
                        @else
                            <span class="badge-danger">Inativo</span>
                        @endif
                    </div>

                    <h3 class="text-white font-bold text-lg mb-1">{{ $plano->nome }}</h3>

                    @if($plano->descricao)
                        <p class="text-gray-400 text-sm mb-3">{{ $plano->descricao }}</p>
                    @endif

                    {{-- Preço em destaque --}}
                    <div class="my-4">
                        <p class="text-3xl font-bold text-orange-400">{{ $plano->preco_formatado }}</p>
                        <p class="text-gray-500 text-xs">{{ $plano->duracao_dias }} dias de acesso</p>
                    </div>

                    {{-- Quantidade de matrículas neste plano --}}
                    <div class="bg-gray-800 rounded-lg px-3 py-2 mb-4">
                        <p class="text-gray-400 text-xs">
                            <span class="text-white font-medium">{{ $plano->matriculas->count() }}</span>
                            matrícula(s) neste plano
                        </p>
                    </div>

                    {{-- Ações --}}
                    <div class="flex gap-2">
                        <a href="{{ route('planos.edit', $plano) }}"
                           class="flex-1 text-center text-xs bg-gray-700 hover:bg-gray-600 text-white py-2 rounded-lg transition-colors">
                            Editar
                        </a>
                        <form method="POST" action="{{ route('planos.destroy', $plano) }}"
                              onsubmit="return confirm('Excluir este plano?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs bg-red-500 bg-opacity-20 hover:bg-opacity-30 text-red-400 px-3 py-2 rounded-lg transition-colors">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="sm:col-span-2 lg:col-span-3 card text-center py-12">
                    <p class="text-gray-400 mb-3">Nenhum plano cadastrado</p>
                    <a href="{{ route('planos.create') }}" class="btn-primary">Criar primeiro plano</a>
                </div>
            @endforelse
        </div>

        {{ $planos->links() }}
    </div>
</x-app-layout>
