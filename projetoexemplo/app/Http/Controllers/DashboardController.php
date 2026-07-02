<?php

/*
|--------------------------------------------------------------------------
| CONTROLLER: DashboardController
|--------------------------------------------------------------------------
|
| O que é um Controller (Controlador)?
| -------------------------------------
| O Controller é o "gerente" da requisição. Quando o usuário acessa uma URL,
| o Laravel chama o método correspondente no Controller.
|
| O Controller:
| 1. Recebe a requisição ($request)
| 2. Conversa com os Models para buscar/salvar dados
| 3. Passa os dados para a View (HTML)
| 4. Retorna a resposta ao usuário
|
| No padrão MVC:
| - M (Model)      → dados e regras de negócio
| - V (View)       → interface visual (HTML/Blade)
| - C (Controller) → o intermediário entre M e V
|
*/

namespace App\Http\Controllers;

// "use" importa classes de outros arquivos/namespaces
// Sem o "use", você precisaria escrever o caminho completo:
// \App\Models\Aluno::count() em vez de Aluno::count()
use App\Models\Aluno;
use App\Models\Matricula;
use App\Models\Checkin;
use App\Models\Plano;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Método index() - Página inicial do dashboard
    |--------------------------------------------------------------------------
    |
    | Este método monta todos os dados estatísticos para exibir no painel.
    |
    | Para acessar este método, o usuário vai em: /dashboard
    | (configurado nas rotas em routes/web.php)
    |
    */
    public function index()
    {
        // ====================================================================
        // ESTATÍSTICAS RÁPIDAS
        // ====================================================================

        // count() → conta quantos registros existem na tabela
        $totalAlunos = Aluno::count();

        // where() → filtra registros. Equivale ao WHERE do SQL
        $alunosAtivos = Aluno::where('ativo', true)->count();

        // Matrículas ativas: status = 'ativo' E data_fim não venceu ainda
        $matriculasAtivas = Matricula::where('status', 'ativo')
            ->where('data_fim', '>=', now()->toDateString())
            ->count();

        // today() → hoje. Busca check-ins com entrada de hoje
        $checkinHoje = Checkin::whereDate('entrada', today())->count();

        // ====================================================================
        // CHECK-INS RECENTES (últimos 10)
        // ====================================================================

        // with() → "Eager Loading" - carrega os dados relacionados de uma vez
        // Sem with(): para cada check-in, faz 1 query no banco para o aluno
        // Com with(): faz apenas 2 queries no total (muito mais eficiente)
        $checkinRecentes = Checkin::with('aluno')
            ->latest()   // ordena por created_at decrescente (mais recente primeiro)
            ->take(10)   // limita a 10 resultados
            ->get();     // executa a query e retorna uma Collection

        // ====================================================================
        // MATRÍCULAS PRÓXIMAS DO VENCIMENTO (próximos 7 dias)
        // ====================================================================
        $matriculasVencendo = Matricula::with(['aluno', 'plano'])
            ->where('status', 'ativo')
            ->whereBetween('data_fim', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->get();

        // ====================================================================
        // RETORNAR A VIEW COM OS DADOS
        // ====================================================================

        // view('nome.da.view', ['variavel' => valor])
        // O Laravel procura o arquivo em: resources/views/nome/da/view.blade.php
        // As variáveis do array ficam disponíveis na view
        return view('dashboard', compact(
            'totalAlunos',
            'alunosAtivos',
            'matriculasAtivas',
            'checkinHoje',
            'checkinRecentes',
            'matriculasVencendo'
        ));

        // compact() é um atalho para:
        // ['totalAlunos' => $totalAlunos, 'alunosAtivos' => $alunosAtivos, ...]
    }
}
