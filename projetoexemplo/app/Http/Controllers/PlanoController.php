<?php

/*
|--------------------------------------------------------------------------
| CONTROLLER: PlanoController (Resource Controller)
|--------------------------------------------------------------------------
|
| Resource Controller - O que é?
| --------------------------------
| Um Resource Controller segue o padrão REST e tem 7 métodos padrão:
|
| Método     | URL              | HTTP   | O que faz
| -----------|------------------|--------|-------------------------
| index()    | /planos          | GET    | Lista todos os planos
| create()   | /planos/create   | GET    | Exibe form de criação
| store()    | /planos          | POST   | Salva novo plano
| show()     | /planos/{id}     | GET    | Exibe um plano específico
| edit()     | /planos/{id}/edit| GET    | Exibe form de edição
| update()   | /planos/{id}     | PUT    | Atualiza um plano
| destroy()  | /planos/{id}     | DELETE | Exclui um plano
|
| Com UMA linha nas rotas (Route::resource), você registra todas as 7!
|
*/

namespace App\Http\Controllers;

use App\Models\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | index() → GET /planos
    |--------------------------------------------------------------------------
    | Lista todos os planos cadastrados
    */
    public function index()
    {
        // latest() → ordena por created_at DESC (mais novo primeiro)
        // paginate(10) → divide em páginas de 10 itens
        // Melhor que get() em listas grandes → não carrega tudo na memória
        $planos = Plano::latest()->paginate(10);

        // Passa a variável $planos para a view planos/index.blade.php
        return view('planos.index', compact('planos'));
    }

    /*
    |--------------------------------------------------------------------------
    | create() → GET /planos/create
    |--------------------------------------------------------------------------
    | Exibe o formulário de criação de um novo plano
    */
    public function create()
    {
        // Apenas retorna a view com o formulário vazio
        return view('planos.create');
    }

    /*
    |--------------------------------------------------------------------------
    | store() → POST /planos
    |--------------------------------------------------------------------------
    | Recebe os dados do formulário, valida e salva no banco
    */
    public function store(Request $request)
    {
        /*
        | VALIDAÇÃO - O que é e por que é importante?
        | --------------------------------------------
        | Antes de salvar qualquer coisa no banco, SEMPRE valide os dados.
        | Usuários podem enviar dados inválidos ou mal-intencionados.
        |
        | validate() verifica as regras e, se falhar:
        | → Redireciona de volta ao formulário
        | → Exibe as mensagens de erro
        | → Preserva os dados que o usuário digitou (old())
        |
        | Regras comuns:
        | - required   → obrigatório
        | - string     → deve ser texto
        | - max:255    → máximo 255 caracteres
        | - numeric    → deve ser número
        | - min:0      → valor mínimo
        | - boolean    → verdadeiro ou falso
        | - nullable   → pode ser vazio
        */
        $dados = $request->validate([
            'nome'         => 'required|string|max:255',
            'descricao'    => 'nullable|string',
            'preco'        => 'required|numeric|min:0',
            'duracao_dias' => 'required|integer|min:1',
            'ativo'        => 'boolean',
        ]);

        // Se 'ativo' não foi enviado (checkbox desmarcado), define como false
        $dados['ativo'] = $request->has('ativo');

        // Plano::create($dados) → INSERT INTO planos (...) VALUES (...)
        // O Eloquent preenche apenas os campos que estão em $fillable
        Plano::create($dados);

        // redirect() → redireciona o usuário para outra página
        // route('planos.index') → gera a URL da rota chamada 'planos.index'
        // ->with('success', '...') → envia uma mensagem flash (aparece uma vez)
        return redirect()->route('planos.index')
            ->with('success', 'Plano criado com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | show() → GET /planos/{plano}
    |--------------------------------------------------------------------------
    | Exibe os detalhes de um plano específico
    |
    | Route Model Binding:
    | --------------------
    | Ao digitar "Plano $plano" como parâmetro, o Laravel automaticamente
    | busca o plano pelo ID na URL. Se não encontrar, retorna 404.
    | Você não precisa escrever: Plano::findOrFail($id)
    */
    public function show(Plano $plano)
    {
        // Carrega os alunos matriculados neste plano (com dados do aluno)
        $plano->load('matriculas.aluno');

        return view('planos.show', compact('plano'));
    }

    /*
    |--------------------------------------------------------------------------
    | edit() → GET /planos/{plano}/edit
    |--------------------------------------------------------------------------
    | Exibe o formulário pré-preenchido para editar um plano
    */
    public function edit(Plano $plano)
    {
        // Passa o plano para a view preencher o formulário automaticamente
        return view('planos.edit', compact('plano'));
    }

    /*
    |--------------------------------------------------------------------------
    | update() → PUT /planos/{plano}
    |--------------------------------------------------------------------------
    | Recebe os dados do formulário de edição e atualiza o banco
    */
    public function update(Request $request, Plano $plano)
    {
        $dados = $request->validate([
            'nome'         => 'required|string|max:255',
            'descricao'    => 'nullable|string',
            'preco'        => 'required|numeric|min:0',
            'duracao_dias' => 'required|integer|min:1',
            'ativo'        => 'boolean',
        ]);

        $dados['ativo'] = $request->has('ativo');

        // update() → UPDATE planos SET ... WHERE id = {$plano->id}
        $plano->update($dados);

        return redirect()->route('planos.index')
            ->with('success', 'Plano atualizado com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | destroy() → DELETE /planos/{plano}
    |--------------------------------------------------------------------------
    | Exclui um plano do banco de dados
    */
    public function destroy(Plano $plano)
    {
        // delete() → DELETE FROM planos WHERE id = {$plano->id}
        $plano->delete();

        return redirect()->route('planos.index')
            ->with('success', 'Plano excluído com sucesso!');
    }
}
