{{-- VIEW: matriculas/show.blade.php --}}

<x-app-layout>
    @section('title', 'Detalhes da Matrícula')

    <div class="max-w-lg">
        <div class="card space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white">Matrícula #{{ $matricula->id }}</h2>
                @if($matricula->status == 'ativo')
                    <span class="badge-success">Ativo</span>
                @elseif($matricula->status == 'cancelado')
                    <span class="badge-danger">Cancelado</span>
                @else
                    <span class="badge-warning">Expirado</span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-xs">Aluno</p>
                    <a href="{{ route('alunos.show', $matricula->aluno) }}"
                       class="text-white hover:text-orange-400 font-medium transition-colors">
                        {{ $matricula->aluno->nome }}
                    </a>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Plano</p>
                    <p class="text-white font-medium">{{ $matricula->plano->nome }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Início</p>
                    <p class="text-white">{{ $matricula->data_inicio->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Vencimento</p>
                    <p class="text-white">{{ $matricula->data_fim->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Valor</p>
                    <p class="text-orange-400 font-bold">{{ $matricula->plano->preco_formatado }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Dias restantes</p>
                    <p class="text-white">{{ $matricula->dias_restantes }} dias</p>
                </div>
            </div>

            @if($matricula->observacoes)
                <div class="bg-gray-800 rounded-lg p-3">
                    <p class="text-gray-500 text-xs mb-1">Observações</p>
                    <p class="text-gray-300 text-sm">{{ $matricula->observacoes }}</p>
                </div>
            @endif

            <div class="flex gap-3">
                <a href="{{ route('matriculas.edit', $matricula) }}" class="btn-secondary">Editar</a>
                <a href="{{ route('matriculas.index') }}" class="btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</x-app-layout>
