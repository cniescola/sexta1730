{{-- VIEW: matriculas/edit.blade.php --}}

<x-app-layout>
    @section('title', 'Editar Matrícula')
    @section('subtitle', $matricula->aluno->nome . ' - ' . $matricula->plano->nome)

    <div class="max-w-lg">
        <div class="card">
            <form method="POST" action="{{ route('matriculas.update', $matricula) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="aluno_id" class="form-label">Aluno *</label>
                    <select id="aluno_id" name="aluno_id" class="form-input">
                        @foreach($alunos as $aluno)
                            <option value="{{ $aluno->id }}"
                                {{ old('aluno_id', $matricula->aluno_id) == $aluno->id ? 'selected' : '' }}>
                                {{ $aluno->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="plano_id" class="form-label">Plano *</label>
                    <select id="plano_id" name="plano_id" class="form-input">
                        @foreach($planos as $plano)
                            <option value="{{ $plano->id }}"
                                {{ old('plano_id', $matricula->plano_id) == $plano->id ? 'selected' : '' }}>
                                {{ $plano->nome }} - {{ $plano->preco_formatado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="data_inicio" class="form-label">Data de Início *</label>
                    <input type="date" id="data_inicio" name="data_inicio"
                           value="{{ old('data_inicio', $matricula->data_inicio->format('Y-m-d')) }}"
                           class="form-input">
                </div>

                <div>
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-input">
                        <option value="ativo" {{ old('status', $matricula->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="expirado" {{ old('status', $matricula->status) == 'expirado' ? 'selected' : '' }}>Expirado</option>
                        <option value="cancelado" {{ old('status', $matricula->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div>
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea id="observacoes" name="observacoes" rows="3"
                              class="form-input resize-none">{{ old('observacoes', $matricula->observacoes) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                    <a href="{{ route('matriculas.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
