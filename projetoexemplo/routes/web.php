<?php

/*
|--------------------------------------------------------------------------
| ROTAS DA APLICAÇÃO (routes/web.php)
|--------------------------------------------------------------------------
|
| O que são rotas?
| ----------------
| Rotas definem quais URLs existem na sua aplicação e o que acontece
| quando o usuário acessa cada uma delas.
|
| Ex: o usuário acessa /alunos → o Laravel procura a rota que corresponde
| a essa URL → chama o método index() do AlunoController.
|
| Estrutura básica de uma rota:
| Route::METHOD('url', ação)->name('nome.rota');
|
| Métodos HTTP:
| - GET    → buscar/exibir dados
| - POST   → criar novos dados
| - PUT    → atualizar dados completamente
| - PATCH  → atualizar dados parcialmente
| - DELETE → excluir dados
|
| Middleware 'auth':
| -----------------
| Middleware é código que executa ANTES do controller.
| O middleware 'auth' verifica se o usuário está logado.
| Se não estiver, redireciona para a página de login.
|
*/

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================================
// ROTA PÚBLICA: Página inicial redireciona para o login
// ============================================================
Route::get('/', function () {
    // Se já está logado, vai direto para o dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ============================================================
// ROTAS PROTEGIDAS (exigem login)
// ============================================================

// Route::middleware(['auth'])->group(function () { ... })
// Agrupa rotas que compartilham o mesmo middleware.
// Todas as rotas dentro do grupo exigem que o usuário esteja logado.
Route::middleware(['auth', 'verified'])->group(function () {

    // ----------------------------------------------------------
    // DASHBOARD
    // ----------------------------------------------------------
    // Route::get('url', [Controller::class, 'método'])->name('apelido')
    // O ->name() cria um "apelido" para a rota.
    // Em vez de escrever a URL no código, você usa: route('dashboard')
    // Se a URL mudar, só precisa alterar aqui, não em todo o projeto.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ----------------------------------------------------------
    // ALUNOS - Route::resource() cria as 7 rotas REST de uma vez:
    // ----------------------------------------------------------
    // GET    /alunos              → index()   → lista alunos
    // GET    /alunos/create       → create()  → formulário novo
    // POST   /alunos              → store()   → salva novo aluno
    // GET    /alunos/{aluno}      → show()    → perfil do aluno
    // GET    /alunos/{aluno}/edit → edit()    → formulário edição
    // PUT    /alunos/{aluno}      → update()  → salva edição
    // DELETE /alunos/{aluno}      → destroy() → exclui aluno
    Route::resource('alunos', AlunoController::class);

    // ----------------------------------------------------------
    // PLANOS
    // ----------------------------------------------------------
    Route::resource('planos', PlanoController::class);

    // ----------------------------------------------------------
    // MATRÍCULAS
    // ----------------------------------------------------------
    Route::resource('matriculas', MatriculaController::class);

    // ----------------------------------------------------------
    // CHECK-INS
    // ----------------------------------------------------------
    // Rota para listar e criar check-ins
    Route::get('/checkins', [CheckinController::class, 'index'])->name('checkins.index');
    Route::post('/checkins', [CheckinController::class, 'store'])->name('checkins.store');

    // Rota customizada para registrar saída
    // {checkin} → o Laravel busca automaticamente o Checkin pelo ID
    Route::patch('/checkins/{checkin}/saida', [CheckinController::class, 'registrarSaida'])
        ->name('checkins.saida');

    // ----------------------------------------------------------
    // PERFIL DO USUÁRIO (vem com o Breeze)
    // ----------------------------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// ROTAS DE AUTENTICAÇÃO (login, registro, senha)
// ============================================================
// Este arquivo é gerado pelo Breeze e contém todas as rotas de auth:
// GET  /login       → formulário de login
// POST /login       → processa o login
// POST /logout      → faz logout
// GET  /register    → formulário de cadastro
// POST /register    → processa o cadastro
// GET  /forgot-password → recuperação de senha
require __DIR__.'/auth.php';
