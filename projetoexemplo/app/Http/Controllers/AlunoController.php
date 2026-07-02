<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | index() → Lista todos os alunos com busca
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // $request->get('busca') → pega o parâmetro "busca" da URL
        // Ex: /alunos?busca=João → $busca = "João"
        $busca = $request->get('busca');

        // Inicia a query (ainda não executa no banco)
        $query = Aluno::query();

        // Se existe um termo de busca, adiciona filtros
        if ($busca) {
            // where com função anônima → agrupa condições com parênteses no SQL
            // Resultado: WHERE (nome LIKE '%João%' OR email LIKE '%João%' OR cpf LIKE '%João%')
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', "%{$busca}%")
                  ->orWhere('email', 'like', "%{$busca}%")
                  ->orWhere('cpf', 'like', "%{$busca}%");
            });
        }

        // with() → Eager Loading: carrega matrículas e planos de uma vez
        // Sem isso, o Blade faria 1 query extra por aluno (problema N+1)
        // Carrega apenas matrículas ativas e não vencidas
        $alunos = $query->with(['matriculas' => function ($q) {
            $q->where('status', 'ativo')
              ->where('data_fim', '>=', now()->toDateString())
              ->with('plano')
              ->latest();
        }])->latest()->paginate(12);

        // appends() → garante que o parâmetro "busca" seja mantido
        // nas URLs de paginação: /alunos?busca=João&page=2
        $alunos->appends(['busca' => $busca]);

        return view('alunos.index', compact('alunos', 'busca'));
    }

    /*
    |--------------------------------------------------------------------------
    | create() → Formulário de novo aluno
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('alunos.create');
    }

    /*
    |--------------------------------------------------------------------------
    | store() → Salva novo aluno
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome'            => 'required|string|max:255',
            // unique:alunos,email → verifica unicidade na tabela alunos, coluna email
            'email'           => 'required|email|unique:alunos,email',
            'telefone'        => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'endereco'        => 'nullable|string|max:500',
            // unique:alunos,cpf → CPF único na tabela
            'cpf'             => 'nullable|string|max:14|unique:alunos,cpf',
            'sexo'            => 'nullable|in:M,F,Outro',
            'observacoes'     => 'nullable|string',
        ]);

        $dados['ativo'] = true; // Novo aluno começa ativo

        Aluno::create($dados);

        return redirect()->route('alunos.index')
            ->with('success', 'Aluno cadastrado com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | show() → Perfil completo do aluno
    |--------------------------------------------------------------------------
    */
    public function show(Aluno $aluno)
    {
        // Carrega relacionamentos de uma vez (Eager Loading)
        // 'matriculas.plano' → carrega matrículas E o plano de cada matrícula
        $aluno->load(['matriculas.plano', 'checkins' => function ($query) {
            // Dentro do eager loading, podemos adicionar ordenação
            $query->latest()->take(10);
        }]);

        return view('alunos.show', compact('aluno'));
    }

    /*
    |--------------------------------------------------------------------------
    | edit() → Formulário de edição
    |--------------------------------------------------------------------------
    */
    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', compact('aluno'));
    }

    /*
    |--------------------------------------------------------------------------
    | update() → Salva as alterações do aluno
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Aluno $aluno)
    {
        $dados = $request->validate([
            'nome'            => 'required|string|max:255',
            // unique:alunos,email,{$aluno->id} → ignora o próprio registro
            // sem isso, ao salvar sem alterar o email, daria erro "já existe"
            'email'           => "required|email|unique:alunos,email,{$aluno->id}",
            'telefone'        => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'endereco'        => 'nullable|string|max:500',
            'cpf'             => "nullable|string|max:14|unique:alunos,cpf,{$aluno->id}",
            'sexo'            => 'nullable|in:M,F,Outro',
            'observacoes'     => 'nullable|string',
        ]);

        $dados['ativo'] = $request->has('ativo');

        $aluno->update($dados);

        return redirect()->route('alunos.show', $aluno)
            ->with('success', 'Aluno atualizado com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | destroy() → Exclui o aluno
    |--------------------------------------------------------------------------
    */
    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()->route('alunos.index')
            ->with('success', 'Aluno removido com sucesso!');
    }
}
