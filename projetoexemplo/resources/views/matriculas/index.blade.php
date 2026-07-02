{{-- VIEW: matriculas/index.blade.php --}}

<x-app-layout>
    @section('title', 'Matrículas')
    @section('subtitle', 'Controle de matrículas dos alunos')

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">

            {{-- Filtros de status --}}
            <div class="flex gap-2">
                @foreach(['ativo' => 'Ativas', 'expirado' => 'Expiradas', 'cancelado' => 'Canceladas', 'todos' => 'Todas'] as $valor => $label)
                    <a href="{{ route('matriculas.index', ['status' => $valor]) }}"
                       class="px-3 py-1.5 rounded-lg text-sm transition-colors
                              {{ $status == $valor ? 'bg-orange-500 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('matriculas.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Matrícula
            </a>
        </div>

        {{-- Tabela de matrículas --}}
        <div class="card p-0 overflow-hidden">
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Plano</th>
                        <th>Início</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($matriculas as $matricula)
                        <tr>
                            <td>
                                <a href="{{ route('alunos.show', $matricula->aluno) }}"
                                   class="text-white hover:text-orange-400 transition-colors font-medium">
                                    {{ $matricula->aluno->nome }}
                                </a>
                            </td>
                            <td>{{ $matricula->plano->nome }}</td>
                            <td>{{ $matricula->data_inicio->format('d/m/Y') }}</td>
                            <td>
                                {{ $matricula->data_fim->format('d/m/Y') }}
                                @if($matricula->status == 'ativo' && $matricula->dias_restantes <= 7)
                                    <span class="badge-warning ml-1">{{ $matricula->dias_restantes }}d</span>
                                @endif
                            </td>
                            <td>
                                @if($matricula->status == 'ativo' && $matricula->data_fim >= now())
                                    <span class="badge-success">Ativo</span>
                                @elseif($matricula->status == 'cancelado')
                                    <span class="badge-danger">Cancelado</span>
                                @else
                                    <span class="badge-warning">Expirado</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('matriculas.edit', $matricula) }}"
                                       class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-2 py-1 rounded transition-colors">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('matriculas.destroy', $matricula) }}"
                                          onsubmit="return confirm('Excluir matrícula?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs bg-red-500 bg-opacity-20 hover:bg-opacity-30 text-red-400 px-2 py-1 rounded transition-colors">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Nenhuma matrícula encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $matriculas->links() }}
    </div>
</x-app-layout>
