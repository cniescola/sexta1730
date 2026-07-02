{{-- VIEW: matriculas/create.blade.php --}}

<x-app-layout>
    @section('title', 'Nova Matrícula')
    @section('subtitle', 'Matricular aluno em um plano')

    <div class="max-w-lg">
        <div class="card">
            <form method="POST" action="{{ route('matriculas.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="aluno_id" class="form-label">Aluno *</label>
                    <select id="aluno_id" name="aluno_id"
                            class="form-input @error('aluno_id') border-red-500 @enderror">
                        <option value="">Selecione o aluno...</option>
                        @foreach($alunos as $aluno)
                            {{-- $alunoSelecionado vem da URL (?aluno_id=X) --}}
                            <option value="{{ $aluno->id }}"
                                {{ (old('aluno_id', $alunoSelecionado) == $aluno->id) ? 'selected' : '' }}>
                                {{ $aluno->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('aluno_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="plano_id" class="form-label">Plano *</label>
                    <select id="plano_id" name="plano_id"
                            class="form-input @error('plano_id') border-red-500 @enderror">
                        <option value="">Selecione o plano...</option>
                        @foreach($planos as $plano)
                            <option value="{{ $plano->id }}"
                                {{ old('plano_id') == $plano->id ? 'selected' : '' }}>
                                {{ $plano->nome }} - {{ $plano->preco_formatado }} ({{ $plano->duracao_dias }} dias)
                            </option>
                        @endforeach
                    </select>
                    @error('plano_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="data_inicio" class="form-label">Data de Início *</label>
                    <input type="date" id="data_inicio" name="data_inicio"
                           value="{{ old('data_inicio', today()->format('Y-m-d')) }}"
                           class="form-input @error('data_inicio') border-red-500 @enderror">
                    @error('data_inicio')<p class="form-error">{{ $message }}</p>@enderror
                    <p class="text-gray-500 text-xs mt-1">A data de fim é calculada automaticamente</p>
                </div>

                <div>
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea id="observacoes" name="observacoes" rows="3"
                              class="form-input resize-none"
                              placeholder="Pagamento, desconto, observações...">{{ old('observacoes') }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Matricular
                    </button>
                    <a href="{{ route('matriculas.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
