<?php

/*
|--------------------------------------------------------------------------
| MODEL: Checkin
|--------------------------------------------------------------------------
|
| Representa uma entrada (check-in) de um aluno na academia.
| Cada linha desta tabela é uma visita de um aluno.
|
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'aluno_id',
        'entrada',
        'saida',
        'observacao',
    ];

    protected $casts = [
        'entrada' => 'datetime', // datetime → objeto Carbon com data E hora
        'saida'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamento: Este check-in PERTENCE a um Aluno
    |--------------------------------------------------------------------------
    */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: Tempo de permanência na academia
    |--------------------------------------------------------------------------
    */
    public function getDuracaoAttribute(): ?string
    {
        if (!$this->saida) {
            return 'Em andamento';
        }
        // diffInMinutes() → diferença em minutos
        $minutos = $this->entrada->diffInMinutes($this->saida);
        $horas = intdiv($minutos, 60);
        $min = $minutos % 60;

        return "{$horas}h {$min}min";
    }
}
