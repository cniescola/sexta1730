{{-- VIEW: alunos/show.blade.php - Perfil completo do aluno --}}

<x-app-layout>
    @section('title', $aluno->nome)
    @section('subtitle', 'Perfil do aluno')

    <div class="space-y-5">

        {{-- ================================================================
             CABEÇALHO DO PERFIL
             ================================================================ --}}
        <div class="card">
            <div class="flex flex-col sm:flex-row items-start gap-5">

                {{-- Avatar grande --}}
                <div class="w-20 h-20 bg-orange-500 rounded-2xl flex items-center justify-center text-white font-bold text-3xl flex-shrink-0">
                    {{ strtoupper(substr($aluno->nome, 0, 1)) }}
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $aluno->nome }}</h2>
                            <p class="text-gray-400">{{ $aluno->email }}</p>
                            @if($aluno->telefone)
                                <p class="text-gray-400 text-sm">{{ $aluno->telefone }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if($aluno->ativo)
                                <span class="badge-success">Ativo</span>
                            @else
                                <span class="badge-danger">Inativo</span>
                            @endif
                        </div>
                    </div>

                    {{-- Info rápida em linha --}}
                    <div class="flex flex-wrap gap-4 mt-3">
                        @if($aluno->cpf)
                            <div class="text-sm">
                                <span class="text-gray-500">CPF:</span>
                                <span class="text-gray-300">{{ $aluno->cpf }}</span>
                            </div>
                        @endif
                        @if($aluno->idade)
                            <div class="text-sm">
                                <span class="text-gray-500">Idade:</span>
                                <span class="text-gray-300">{{ $aluno->idade }} anos</span>
                            </div>
                        @endif
                        @if($aluno->sexo)
                            <div class="text-sm">
                                <span class="text-gray-500">Sexo:</span>
                                <span class="text-gray-300">{{ $aluno->sexo == 'M' ? 'Masculino' : ($aluno->sexo == 'F' ? 'Feminino' : 'Outro') }}</span>
                            </div>
                        @endif
                        <div class="text-sm">
                            <span class="text-gray-500">Cadastrado em:</span>
                            {{-- format() → método Carbon para formatar datas --}}
                            <span class="text-gray-300">{{ $aluno->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ações do perfil --}}
            <div class="flex flex-wrap gap-3 mt-5 pt-5 border-t border-gray-800">
                <a href="{{ route('alunos.edit', $aluno) }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                {{-- Link para criar matrícula já com o aluno pré-selecionado --}}
                <a href="{{ route('matriculas.create', ['aluno_id' => $aluno->id]) }}" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nova Matrícula
                </a>

                {{-- Formulário de exclusão - precisa ser um form POST com method DELETE --}}
                <form method="POST" action="{{ route('alunos.destroy', $aluno) }}"
                      onsubmit="return confirm('Tem certeza? Isso excluirá o aluno e todos seus dados.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Excluir Aluno
                    </button>
                </form>
            </div>
        </div>

        {{-- Grid: Matrículas + Check-ins --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- MATRÍCULAS DO ALUNO --}}
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Matrículas</h3>
                    <a href="{{ route('matriculas.create', ['aluno_id' => $aluno->id]) }}"
                       class="text-orange-400 text-sm hover:underline">+ Nova</a>
                </div>

                @forelse($aluno->matriculas as $matricula)
                    <div class="border border-gray-800 rounded-lg p-3 mb-2">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-white text-sm font-medium">{{ $matricula->plano->nome }}</p>
                            @if($matricula->status == 'ativo' && $matricula->data_fim >= now())
                                <span class="badge-success">Ativo</span>
                            @elseif($matricula->status == 'cancelado')
                                <span class="badge-danger">Cancelado</span>
                            @else
                                <span class="badge-warning">Expirado</span>
                            @endif
                        </div>
                        <p class="text-gray-400 text-xs">
                            {{ $matricula->data_inicio->format('d/m/Y') }} →
                            {{ $matricula->data_fim->format('d/m/Y') }}
                        </p>
                        <p class="text-gray-500 text-xs mt-1">{{ $matricula->plano->preco_formatado }}/mês</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-6">Nenhuma matrícula ainda</p>
                @endforelse
            </div>

            {{-- HISTÓRICO DE CHECK-INS --}}
            <div class="card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Últimos Check-ins</h3>
                    <span class="text-gray-500 text-xs">10 mais recentes</span>
                </div>

                @forelse($aluno->checkins as $checkin)
                    <div class="flex items-center gap-3 py-2 border-b border-gray-800 last:border-0">
                        <div class="w-2 h-2 bg-green-400 rounded-full flex-shrink-0"></div>
                        <div class="flex-1">
                            <p class="text-gray-300 text-xs">
                                {{ $checkin->entrada->format('d/m/Y') }} às {{ $checkin->entrada->format('H:i') }}
                            </p>
                            @if($checkin->observacao)
                                <p class="text-gray-500 text-xs">{{ $checkin->observacao }}</p>
                            @endif
                        </div>
                        <span class="text-gray-500 text-xs">{{ $checkin->duracao }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-6">Nenhum check-in registrado</p>
                @endforelse
            </div>
        </div>

        {{-- Observações (se houver) --}}
        @if($aluno->observacoes)
            <div class="card">
                <h3 class="text-white font-semibold mb-2">Observações</h3>
                <p class="text-gray-400 text-sm">{{ $aluno->observacoes }}</p>
            </div>
        @endif

        {{-- Botão voltar --}}
        <div>
            <a href="{{ route('alunos.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar para lista
            </a>
        </div>
    </div>
</x-app-layout>
