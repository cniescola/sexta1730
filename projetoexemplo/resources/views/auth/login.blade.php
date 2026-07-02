{{--
|--------------------------------------------------------------------------
| VIEW: auth/login.blade.php - Página de Login
|--------------------------------------------------------------------------
|
| Esta view foi gerada pelo Breeze e é usada para autenticação.
| O Breeze cuida de toda a lógica de validação e autenticação.
|
| Componentes usados:
| - <x-guest-layout>      → layout sem sidebar (layouts/guest.blade.php)
| - <x-auth-session-status> → exibe status da sessão (ex: "Link enviado!")
|
--}}

<x-guest-layout>

    {{-- Título do formulário --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Entrar</h2>
        <p class="text-gray-400 text-sm mt-1">Acesse o painel da academia</p>
    </div>

    {{-- Mensagem de status da sessão (ex: após redefinir senha) --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- E-mail --}}
        <div>
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="form-input @error('email') border-red-500 @enderror"
                   placeholder="seu@email.com">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Senha --}}
        <div>
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="form-input @error('password') border-red-500 @enderror"
                   placeholder="••••••••">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lembrar-me + Esqueci a senha --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded text-orange-500 bg-gray-800 border-gray-600 focus:ring-orange-500">
                <span class="text-gray-400 text-sm">Lembrar-me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-orange-400 text-sm hover:text-orange-300 transition-colors">
                    Esqueci a senha
                </a>
            @endif
        </div>

        {{-- Botão de login --}}
        <button type="submit" class="btn-primary w-full justify-center py-3 mt-2">
            Entrar no Sistema
        </button>

        {{-- Link para registro --}}
        <p class="text-center text-gray-400 text-sm">
            Não tem conta?
            <a href="{{ route('register') }}" class="text-orange-400 hover:text-orange-300 transition-colors">
                Cadastrar-se
            </a>
        </p>
    </form>
</x-guest-layout>
