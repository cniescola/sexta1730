{{-- VIEW: planos/create.blade.php --}}

<x-app-layout>
    @section('title', 'Novo Plano')
    @section('subtitle', 'Criar novo plano de academia')

    <div class="max-w-lg">
        <div class="card">
            <form method="POST" action="{{ route('planos.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nome" class="form-label">Nome do Plano *</label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}"
                           class="form-input @error('nome') border-red-500 @enderror"
                           placeholder="Ex: Mensal, Trimestral, Anual">
                    @error('nome')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3"
                              class="form-input resize-none"
                              placeholder="Descreva o que está incluso no plano...">{{ old('descricao') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="preco" class="form-label">Preço (R$) *</label>
                        <input type="number" id="preco" name="preco"
                               value="{{ old('preco') }}" step="0.01" min="0"
                               class="form-input @error('preco') border-red-500 @enderror"
                               placeholder="99.90">
                        @error('preco')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="duracao_dias" class="form-label">Duração (dias) *</label>
                        <input type="number" id="duracao_dias" name="duracao_dias"
                               value="{{ old('duracao_dias') }}" min="1"
                               class="form-input @error('duracao_dias') border-red-500 @enderror"
                               placeholder="30">
                        @error('duracao_dias')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Dicas de durações comuns --}}
                <div class="flex gap-2">
                    <button type="button" onclick="document.getElementById('duracao_dias').value=30"
                            class="text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 px-3 py-1 rounded-lg transition-colors">
                        30 dias
                    </button>
                    <button type="button" onclick="document.getElementById('duracao_dias').value=90"
                            class="text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 px-3 py-1 rounded-lg transition-colors">
                        90 dias
                    </button>
                    <button type="button" onclick="document.getElementById('duracao_dias').value=180"
                            class="text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 px-3 py-1 rounded-lg transition-colors">
                        180 dias
                    </button>
                    <button type="button" onclick="document.getElementById('duracao_dias').value=365"
                            class="text-xs bg-gray-700 hover:bg-gray-600 text-gray-300 px-3 py-1 rounded-lg transition-colors">
                        365 dias
                    </button>
                </div>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="ativo" value="1"
                           {{ old('ativo', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-orange-500 bg-gray-800 border-gray-600 focus:ring-orange-500">
                    <span class="text-gray-300 text-sm">Plano disponível para novas matrículas</span>
                </label>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Criar Plano
                    </button>
                    <a href="{{ route('planos.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
