<?php

/*
|--------------------------------------------------------------------------
| MODEL: Matricula
|--------------------------------------------------------------------------
|
| Representa uma matrícula de um aluno em um plano.
| Esta é a tabela de ligação entre Aluno e Plano.
|
| Relacionamentos deste model:
| - Pertence a UM Aluno (belongsTo)
| - Pertence a UM Plano (belongsTo)
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = [
        'aluno_id',
        'plano_id',
        'data_inicio',
        'data_fim',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamento: Esta matrícula PERTENCE a um Aluno (belongsTo)
    |--------------------------------------------------------------------------
    |
    | belongsTo() é o inverso de hasMany().
    | Se Aluno hasMany Matriculas → Matricula belongsTo Aluno
    |
    | Ao chamar $matricula->aluno, o Eloquent faz:
    | SELECT * FROM alunos WHERE id = {$this->aluno_id}
    |
    */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relacionamento: Esta matrícula PERTENCE a um Plano (belongsTo)
    |--------------------------------------------------------------------------
    */
    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: Verifica se a matrícula está vencida
    |--------------------------------------------------------------------------
    */
    public function getVencidaAttribute(): bool
    {
        return $this->data_fim->isPast() && $this->status === 'ativo';
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: Quantos dias restam
    |--------------------------------------------------------------------------
    */
    public function getDiasRestantesAttribute(): int
    {
        if ($this->status !== 'ativo') {
            return 0;
        }
        // diffInDays() do Carbon calcula diferença em dias
        return max(0, now()->diffInDays($this->data_fim, false));
    }
}
