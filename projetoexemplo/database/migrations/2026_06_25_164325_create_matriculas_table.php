<?php

/*
|--------------------------------------------------------------------------
| MIGRATION: create_matriculas_table
|--------------------------------------------------------------------------
|
| Esta migration cria a tabela "matriculas" que conecta Alunos a Planos.
|
| Conceito de CHAVE ESTRANGEIRA (Foreign Key):
| ---------------------------------------------
| Uma chave estrangeira é uma coluna que referencia o ID de outra tabela.
| Ex: matricula.aluno_id = 5 → significa que pertence ao aluno de ID 5.
|
| Isso é o que o Laravel chama de "Relacionamento" (Relationship).
| Neste caso temos um relacionamento "muitos para muitos" indireto:
| - Um aluno pode ter várias matrículas
| - Um plano pode ter vários alunos matriculados
|
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {

            $table->id();

            // foreignId() → cria uma coluna INTEGER para guardar o ID
            // constrained() → diz qual tabela essa coluna referencia
            // cascadeOnDelete() → se o aluno for deletado, suas matrículas
            //                     são deletadas automaticamente também
            $table->foreignId('aluno_id')->constrained('alunos')->cascadeOnDelete();

            // Referência ao plano escolhido pelo aluno
            $table->foreignId('plano_id')->constrained('planos')->cascadeOnDelete();

            // Data em que a matrícula começa a valer
            $table->date('data_inicio');

            // Data em que a matrícula expira (calculada pelo sistema)
            $table->date('data_fim');

            // Status atual da matrícula
            // ativo: pagou e está dentro do prazo
            // expirado: prazo venceu
            // cancelado: cancelou antes do prazo
            $table->enum('status', ['ativo', 'expirado', 'cancelado'])->default('ativo');

            // Observações sobre o pagamento ou a matrícula
            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
