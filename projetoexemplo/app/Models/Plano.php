<?php

/*
|--------------------------------------------------------------------------
| MODEL: Plano
|--------------------------------------------------------------------------
|
| O que é um Model (Modelo)?
| --------------------------
| O Model é a camada que representa e se comunica com o banco de dados.
| No padrão MVC (Model-View-Controller), o Model é responsável pelos dados.
|
| O Laravel usa o "Eloquent ORM" - um sistema que transforma linhas do banco
| em objetos PHP. Em vez de escrever SQL, você escreve PHP:
|
|   SQL:    SELECT * FROM planos WHERE ativo = 1
|   Eloquent: Plano::where('ativo', true)->get()
|
| Convenção do Eloquent:
| - Classe "Plano" → tabela "planos" (pluralizado automaticamente)
| - Classe "Aluno" → tabela "alunos"
| - Você pode sobrescrever isso com: protected $table = 'outra_tabela';
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    /*
    |--------------------------------------------------------------------------
    | $fillable - Proteção contra Mass Assignment
    |--------------------------------------------------------------------------
    |
    | "Mass Assignment" é quando você tenta criar/atualizar um registro
    | passando um array com todos os dados de uma vez:
    |   Plano::create($request->all())
    |
    | Por segurança, o Eloquent BLOQUEIA isso por padrão.
    | Você precisa listar quais campos são PERMITIDOS no $fillable.
    |
    | Isso protege contra usuários mal-intencionados que tentam
    | enviar campos extras (como "id" ou "admin") no formulário.
    |
    */
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'duracao_dias',
        'ativo',
    ];

    /*
    |--------------------------------------------------------------------------
    | $casts - Conversão automática de tipos
    |--------------------------------------------------------------------------
    |
    | O banco de dados armazena tudo como texto ou número.
    | O $casts diz ao Eloquent para converter automaticamente os valores
    | para o tipo PHP correto ao buscar do banco.
    |
    | Sem cast: $plano->ativo == "1" (string)
    | Com cast:  $plano->ativo == true (boolean)
    |
    */
    protected $casts = [
        'preco'        => 'decimal:2', // Sempre 2 casas decimais
        'ativo'        => 'boolean',   // 0/1 vira false/true
        'duracao_dias' => 'integer',   // Garante que é número inteiro
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos (Relationships)
    |--------------------------------------------------------------------------
    |
    | Relacionamentos descrevem como os models se conectam entre si.
    |
    | hasMany() = "tem muitos" = UM Plano tem MUITAS Matrículas
    |
    | Ao chamar $plano->matriculas, o Eloquent automaticamente faz:
    | SELECT * FROM matriculas WHERE plano_id = {$this->id}
    |
    */
    public function matriculas()
    {
        // Um plano pode ter muitos alunos matriculados nele
        return $this->hasMany(Matricula::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (Getters customizados)
    |--------------------------------------------------------------------------
    |
    | Accessor é um método que transforma um valor ao ACESSAR o atributo.
    | Ao acessar $plano->preco_formatado, este método é chamado.
    |
    */
    public function getPrecoFormatadoAttribute(): string
    {
        // number_format(numero, decimais, separador_decimal, separador_milhar)
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }
}
