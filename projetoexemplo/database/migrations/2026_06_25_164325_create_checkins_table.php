<?php

/*
|--------------------------------------------------------------------------
| MIGRATION: create_checkins_table
|--------------------------------------------------------------------------
|
| Esta migration cria a tabela "checkins" que registra cada entrada
| de um aluno na academia. Funciona como um diário de frequência.
|
| Cada vez que um aluno entra na academia, criamos um novo registro aqui.
| Isso permite gerar relatórios de frequência, ver alunos ativos, etc.
|
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {

            $table->id();

            // Qual aluno fez o check-in
            $table->foreignId('aluno_id')->constrained('alunos')->cascadeOnDelete();

            // dateTime() → data E hora juntas (AAAA-MM-DD HH:MM:SS)
            // useCurrent() → se não informar, usa a hora atual automaticamente
            $table->dateTime('entrada')->useCurrent();

            // Hora de saída é opcional (aluno pode não registrar saída)
            $table->dateTime('saida')->nullable();

            // Observação livre (ex: "Aula de spinning", "Musculação")
            $table->string('observacao')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
