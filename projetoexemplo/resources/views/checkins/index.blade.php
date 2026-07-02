{{-- VIEW: checkins/index.blade.php - Controle de frequência --}}

<x-app-layout>
    @section('title', 'Check-ins')
    @section('subtitle', 'Controle de frequência da academia')

    <div class="space-y-5">

        {{-- Formulário de check-in --}}
        <div class="card">
            <h3 class="text-white font-semibold mb-4">Registrar Entrada</h3>
            <form method="POST" action="{{ route('checkins.store') }}" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <select name="aluno_id" required class="form-input flex-1">
                    <option value="">Selecione o aluno...</option>
                    @foreach(\App\Models\Aluno::where('ativo', true)->orderBy('nome')->get() as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                    @endforeach
                </select>
                <input type="text" name="observacao" class="form-input sm:w-48"
                       placeholder="Observação (opcional)">
                <button type="submit" class="btn-primary flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Check-in
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Quem está na academia agora --}}
            <div class="card">
                <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Na Academia Agora ({{ $checkinHoje->whereNull('saida')->count() }})
                </h3>

                @forelse($checkinHoje->whereNull('saida') as $checkin)
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-800 last:border-0">
                        <div class="w-9 h-9 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center text-xs font-bold text-green-400">
                            {{ strtoupper(substr($checkin->aluno->nome, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white text-sm font-medium truncate">{{ $checkin->aluno->nome }}</p>
                            <p class="text-gray-500 text-xs">Entrou às {{ $checkin->entrada->format('H:i') }}</p>
                        </div>
                        {{-- Botão de registrar saída --}}
                        <form method="POST" action="{{ route('checkins.saida', $checkin) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="text-xs bg-orange-500 bg-opacity-20 hover:bg-opacity-30 text-orange-400 px-3 py-1 rounded-lg transition-colors">
                                Registrar Saída
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Ninguém na academia no momento</p>
                @endforelse
            </div>

            {{-- Histórico de hoje --}}
            <div class="card">
                <h3 class="text-white font-semibold mb-4">
                    Movimentação de Hoje ({{ $checkinHoje->count() }})
                </h3>

                @forelse($checkinHoje as $checkin)
                    <div class="flex items-center gap-3 py-2 border-b border-gray-800 last:border-0">
                        <div class="w-7 h-7 bg-gray-700 rounded-full flex items-center justify-center text-xs font-bold text-gray-300 flex-shrink-0">
                            {{ strtoupper(substr($checkin->aluno->nome, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-gray-300 text-sm truncate">{{ $checkin->aluno->nome }}</p>
                            <p class="text-gray-600 text-xs">
                                Entrada: {{ $checkin->entrada->format('H:i') }}
                                @if($checkin->saida)
                                    · Saída: {{ $checkin->saida->format('H:i') }}
                                    · {{ $checkin->duracao }}
                                @endif
                            </p>
                        </div>
                        @if($checkin->saida)
                            <span class="badge-info text-xs">Saiu</span>
                        @else
                            <span class="badge-success text-xs">Presente</span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Nenhum check-in hoje</p>
                @endforelse
            </div>
        </div>

        {{-- Histórico geral paginado --}}
        <div class="card p-0 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-800">
                <h3 class="text-white font-semibold">Histórico Completo</h3>
            </div>
            <table class="table-dark">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historico as $checkin)
                        <tr>
                            <td class="font-medium text-white">{{ $checkin->aluno->nome }}</td>
                            <td>{{ $checkin->entrada->format('d/m/Y H:i') }}</td>
                            <td>{{ $checkin->saida ? $checkin->saida->format('H:i') : '-' }}</td>
                            <td>{{ $checkin->duracao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $historico->links() }}
    </div>
</x-app-layout>
