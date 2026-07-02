{{-- VIEW: alunos/edit.blade.php - Formulário de edição de aluno --}}

<x-app-layout>
    @section('title', 'Editar Aluno')
    @section('subtitle', $aluno->nome)

    <div class="max-w-2xl">
        <div class="card">

            {{-- CONCEITO: Formulário de EDIÇÃO usa method POST + @method('PUT')
                 Navegadores só suportam GET e POST em formulários HTML.
                 Para simular PUT/PATCH/DELETE, o Laravel usa um campo hidden
                 chamado "_method". A diretiva @method('PUT') gera isso.
            --}}
            <form method="POST" action="{{ route('alunos.update', $aluno) }}" class="space-y-5">
                @csrf
                @method('PUT') {{-- Gera: <input type="hidden" name="_method" value="PUT"> --}}

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div class="sm:col-span-2">
                        <label for="nome" class="form-label">Nome completo *</label>
                        {{-- No formulário de edição, $aluno->nome preenche o campo.
                             old('nome', $aluno->nome) → usa o valor digitado se houve erro,
                             senão usa o valor atual do banco --}}
                        <input type="text" id="nome" name="nome"
                               value="{{ old('nome', $aluno->nome) }}"
                               class="form-input @error('nome') border-red-500 @enderror">
                        @error('nome')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="form-label">E-mail *</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $aluno->email) }}"
                               class="form-input @error('email') border-red-500 @enderror">
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" id="telefone" name="telefone"
                               value="{{ old('telefone', $aluno->telefone) }}"
                               class="form-input">
                    </div>

                    <div>
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" id="cpf" name="cpf"
                               value="{{ old('cpf', $aluno->cpf) }}"
                               class="form-input @error('cpf') border-red-500 @enderror">
                        @error('cpf')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        {{-- Para campos date, precisa formatar para o padrão Y-m-d --}}
                        <input type="date" id="data_nascimento" name="data_nascimento"
                               value="{{ old('data_nascimento', $aluno->data_nascimento?->format('Y-m-d')) }}"
                               class="form-input">
                    </div>

                    <div>
                        <label for="sexo" class="form-label">Sexo</label>
                        <select id="sexo" name="sexo" class="form-input">
                            <option value="">Selecione...</option>
                            <option value="M" {{ old('sexo', $aluno->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo', $aluno->sexo) == 'F' ? 'selected' : '' }}>Feminino</option>
                            <option value="Outro" {{ old('sexo', $aluno->sexo) == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" id="endereco" name="endereco"
                               value="{{ old('endereco', $aluno->endereco) }}"
                               class="form-input">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" rows="3"
                                  class="form-input resize-none">{{ old('observacoes', $aluno->observacoes) }}</textarea>
                    </div>

                    {{-- Checkbox de status ativo --}}
                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="ativo" value="1"
                                   {{ old('ativo', $aluno->ativo) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-orange-500 bg-gray-800 border-gray-600
                                          focus:ring-orange-500">
                            <span class="text-gray-300 text-sm">Aluno ativo</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Salvar Alterações
                    </button>
                    <a href="{{ route('alunos.show', $aluno) }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
