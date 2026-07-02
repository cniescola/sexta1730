{{-- VIEW: alunos/create.blade.php - Formulário de cadastro de aluno --}}

<x-app-layout>
    @section('title', 'Novo Aluno')
    @section('subtitle', 'Cadastrar novo membro na academia')

    <div class="max-w-2xl">
        <div class="card">

            {{-- CONCEITO: Formulário com method POST
                 - method="POST" → envia os dados de forma segura (não aparece na URL)
                 - action → para onde os dados vão (route store)
                 - enctype → necessário se tiver upload de arquivo
            --}}
            <form method="POST" action="{{ route('alunos.store') }}" class="space-y-5">

                {{-- @csrf → OBRIGATÓRIO em todo formulário POST/PUT/DELETE!
                     Gera um campo hidden: <input type="hidden" name="_token" value="...">
                     O Laravel verifica esse token para garantir que o form veio do seu site. --}}
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Campo: Nome --}}
                    <div class="sm:col-span-2">
                        <label for="nome" class="form-label">Nome completo *</label>
                        {{-- old('nome') → recupera o valor digitado quando há erro de validação
                             Sem isso, o usuário perderia tudo que digitou --}}
                        <input type="text" id="nome" name="nome"
                               value="{{ old('nome') }}"
                               class="form-input @error('nome') border-red-500 @enderror"
                               placeholder="João Silva">
                        {{-- @error → exibe a mensagem de erro da validação para o campo --}}
                        @error('nome')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo: Email --}}
                    <div>
                        <label for="email" class="form-label">E-mail *</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="form-input @error('email') border-red-500 @enderror"
                               placeholder="joao@email.com">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo: Telefone --}}
                    <div>
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" id="telefone" name="telefone"
                               value="{{ old('telefone') }}"
                               class="form-input"
                               placeholder="(34) 99999-9999">
                    </div>

                    {{-- Campo: CPF --}}
                    <div>
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" id="cpf" name="cpf"
                               value="{{ old('cpf') }}"
                               class="form-input @error('cpf') border-red-500 @enderror"
                               placeholder="000.000.000-00">
                        @error('cpf')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo: Data de Nascimento --}}
                    <div>
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" id="data_nascimento" name="data_nascimento"
                               value="{{ old('data_nascimento') }}"
                               class="form-input">
                    </div>

                    {{-- Campo: Sexo (Select) --}}
                    <div>
                        <label for="sexo" class="form-label">Sexo</label>
                        {{-- select com @selected para marcar o valor atual --}}
                        <select id="sexo" name="sexo" class="form-input">
                            <option value="">Selecione...</option>
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                            <option value="Outro" {{ old('sexo') == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    {{-- Campo: Endereço --}}
                    <div class="sm:col-span-2">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" id="endereco" name="endereco"
                               value="{{ old('endereco') }}"
                               class="form-input"
                               placeholder="Rua, número, bairro, cidade">
                    </div>

                    {{-- Campo: Observações --}}
                    <div class="sm:col-span-2">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" rows="3"
                                  class="form-input resize-none"
                                  placeholder="Informações adicionais, restrições médicas, etc.">{{ old('observacoes') }}</textarea>
                    </div>
                </div>

                {{-- Botões de ação --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Cadastrar Aluno
                    </button>
                    <a href="{{ route('alunos.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
