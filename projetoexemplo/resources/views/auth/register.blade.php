{{-- VIEW: auth/register.blade.php - Página de Registro --}}

<x-guest-layout>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Criar conta</h2>
        <p class="text-gray-400 text-sm mt-1">Cadastre um administrador do sistema</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="form-label">Nome completo</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   class="form-input @error('name') border-red-500 @enderror"
                   placeholder="Seu nome">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   required autocomplete="username"
                   class="form-input @error('email') border-red-500 @enderror"
                   placeholder="seu@email.com">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   class="form-input @error('password') border-red-500 @enderror"
                   placeholder="Mínimo 8 caracteres">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   class="form-input"
                   placeholder="Repita a senha">
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3 mt-2">
            Criar Conta
        </button>

        <p class="text-center text-gray-400 text-sm">
            Já tem conta?
            <a href="{{ route('login') }}" class="text-orange-400 hover:text-orange-300 transition-colors">
                Entrar
            </a>
        </p>
    </form>
</x-guest-layout>
