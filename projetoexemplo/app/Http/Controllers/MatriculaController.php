<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Matricula;
use App\Models\Plano;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | index() → Lista todas as matrículas
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $status = $request->get('status', 'ativo'); // 'ativo' por padrão

        $matriculas = Matricula::with(['aluno', 'plano'])
            ->when($status !== 'todos', function ($q) use ($status) {
                // when($condicao, $callback) → aplica o filtro só se a condição for verdadeira
                // Evita if/else para adicionar filtros opcionais à query
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $matriculas->appends(['status' => $status]);

        return view('matriculas.index', compact('matriculas', 'status'));
    }

    /*
    |--------------------------------------------------------------------------
    | create() → Formulário de nova matrícula
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        // Pega todos os alunos para o select do formulário
        $alunos = Aluno::where('ativo', true)->orderBy('nome')->get();

        // Pega só os planos ativos
        $planos = Plano::where('ativo', true)->orderBy('nome')->get();

        // Se vier ?aluno_id=X na URL (vindo do perfil do aluno), pré-seleciona
        $alunoSelecionado = $request->get('aluno_id');

        return view('matriculas.create', compact('alunos', 'planos', 'alunoSelecionado'));
    }

    /*
    |--------------------------------------------------------------------------
    | store() → Salva nova matrícula
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'aluno_id'    => 'required|exists:alunos,id',
            // exists:planos,id → verifica se o plano_id existe na tabela planos
            'plano_id'    => 'required|exists:planos,id',
            'data_inicio' => 'required|date',
            'observacoes' => 'nullable|string',
        ]);

        // Busca o plano para calcular a data de fim automaticamente
        $plano = Plano::findOrFail($dados['plano_id']);

        // Carbon::parse() transforma uma string de data em objeto Carbon
        // addDays() adiciona dias → calcula data_fim baseado na duração do plano
        $dados['data_fim'] = Carbon::parse($dados['data_inicio'])
            ->addDays($plano->duracao_dias)
            ->toDateString();

        $dados['status'] = 'ativo';

        Matricula::create($dados);

        return redirect()->route('alunos.show', $dados['aluno_id'])
            ->with('success', 'Matrícula realizada com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | edit() → Formulário de edição de matrícula
    |--------------------------------------------------------------------------
    */
    public function edit(Matricula $matricula)
    {
        $alunos = Aluno::where('ativo', true)->orderBy('nome')->get();
        $planos = Plano::where('ativo', true)->orderBy('nome')->get();

        return view('matriculas.edit', compact('matricula', 'alunos', 'planos'));
    }

    /*
    |--------------------------------------------------------------------------
    | update() → Atualiza matrícula
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Matricula $matricula)
    {
        $dados = $request->validate([
            'aluno_id'    => 'required|exists:alunos,id',
            'plano_id'    => 'required|exists:planos,id',
            'data_inicio' => 'required|date',
            'status'      => 'required|in:ativo,expirado,cancelado',
            'observacoes' => 'nullable|string',
        ]);

        $plano = Plano::findOrFail($dados['plano_id']);
        $dados['data_fim'] = Carbon::parse($dados['data_inicio'])
            ->addDays($plano->duracao_dias)
            ->toDateString();

        $matricula->update($dados);

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula atualizada!');
    }

    /*
    |--------------------------------------------------------------------------
    | destroy() → Cancela/exclui matrícula
    |--------------------------------------------------------------------------
    */
    public function destroy(Matricula $matricula)
    {
        $alunoId = $matricula->aluno_id;
        $matricula->delete();

        return redirect()->route('alunos.show', $alunoId)
            ->with('success', 'Matrícula cancelada.');
    }

    /*
    |--------------------------------------------------------------------------
    | show() → Detalhes da matrícula
    |--------------------------------------------------------------------------
    */
    public function show(Matricula $matricula)
    {
        $matricula->load(['aluno', 'plano']);
        return view('matriculas.show', compact('matricula'));
    }
}
