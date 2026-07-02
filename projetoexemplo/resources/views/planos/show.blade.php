{{-- VIEW: planos/show.blade.php --}}

<x-app-layout>
    @section('title', $plano->nome)
    @section('subtitle', 'Detalhes do plano')

    <div class="max-w-2xl space-y-5">
        <div class="card">
            <div class="flex items-start justify-between mb-4">
                <h2 class="text-2xl font-bold text-white">{{ $plano->nome }}</h2>
                @if($plano->ativo)
                    <span class="badge-success">Ativo</span>
                @else
                    <span class="badge-danger">Inativo</span>
                @endif
            </div>

            @if($plano->descricao)
                <p class="text-gray-400 mb-4">{{ $plano->descricao }}</p>
            @endif

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-xs mb-1">Preço</p>
                    <p class="text-2xl font-bold text-orange-400">{{ $plano->preco_formatado }}</p>
                </div>
                <div class="bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-xs mb-1">Duração</p>
                    <p class="text-2xl font-bold text-white">{{ $plano->duracao_dias }} <span class="text-sm font-normal text-gray-400">dias</span></p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('planos.edit', $plano) }}" class="btn-secondary">Editar</a>
                <a href="{{ route('planos.index') }}" class="btn-secondary">Voltar</a>
            </div>
        </div>

        {{-- Alunos matriculados --}}
        @if($plano->matriculas->count() > 0)
            <div class="card">
                <h3 class="text-white font-semibold mb-4">Alunos neste plano ({{ $plano->matriculas->count() }})</h3>
                @foreach($plano->matriculas as $matricula)
                    <div class="flex items-center gap-3 py-2 border-b border-gray-800 last:border-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-xs font-bold text-white">
                            {{ strtoupper(substr($matricula->aluno->nome, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('alunos.show', $matricula->aluno) }}"
                               class="text-white text-sm hover:text-orange-400 transition-colors">
                                {{ $matricula->aluno->nome }}
                            </a>
                            <p class="text-gray-500 text-xs">Vence {{ $matricula->data_fim->format('d/m/Y') }}</p>
                        </div>
                        @if($matricula->status == 'ativo')
                            <span class="badge-success">Ativo</span>
                        @else
                            <span class="badge-warning">{{ ucfirst($matricula->status) }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
