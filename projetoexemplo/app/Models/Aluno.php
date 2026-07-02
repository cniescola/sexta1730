<?php

/*
|--------------------------------------------------------------------------
| MODEL: Aluno
|--------------------------------------------------------------------------
|
| Representa um membro/aluno cadastrado na academia.
| Este model conecta-se à tabela "alunos" no banco de dados.
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'endereco',
        'cpf',
        'sexo',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        // date → converte a string "2000-01-15" em objeto Carbon (data do PHP)
        // Carbon é uma biblioteca que facilita trabalhar com datas
        'data_nascimento' => 'date',
        'ativo'           => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamento: Um Aluno tem MUITAS Matrículas (hasMany)
    |--------------------------------------------------------------------------
    */
    public function matriculas()
    {
        // hasMany(ModelRelacionado, chave_estrangeira, chave_local)
        // O Eloquent assume automaticamente que a chave é "aluno_id"
        return $this->hasMany(Matricula::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamento: Um Aluno tem MUITOS Check-ins (hasMany)
    |--------------------------------------------------------------------------
    */
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: matrícula ativa atual
    |--------------------------------------------------------------------------
    | Retorna a matrícula mais recente que ainda está ativa
    */
    public function getMatriculaAtivaAttribute()
    {
        return $this->matriculas()
            ->where('status', 'ativo')
            ->where('data_fim', '>=', now()->toDateString())
            ->latest()
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: Idade calculada automaticamente
    |--------------------------------------------------------------------------
    */
    public function getIdadeAttribute(): ?int
    {
        // Se não tem data de nascimento, retorna null
        if (!$this->data_nascimento) {
            return null;
        }
        // diffInYears() → calcula diferença em anos (método do Carbon)
        return $this->data_nascimento->diffInYears(now());
    }
}
