<?php

/*
|--------------------------------------------------------------------------
| MIGRATION: create_alunos_table
|--------------------------------------------------------------------------
|
| Esta migration cria a tabela "alunos" que armazena todos os membros
| cadastrados na academia. Cada aluno é uma pessoa física com dados
| pessoais e de contato.
|
| Relacionamento:
| Um aluno pode ter VÁRIAS matrículas (um para muitos).
| Um aluno pode ter VÁRIOS check-ins (um para muitos).
|
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {

            $table->id();

            // Nome completo do aluno
            $table->string('nome');

            // E-mail único - unique() garante que não existam dois alunos
            // com o mesmo e-mail no banco de dados
            $table->string('email')->unique();

            // Telefone é opcional (nullable)
            $table->string('telefone')->nullable();

            // date() → apenas data (sem hora) - formato: AAAA-MM-DD
            $table->date('data_nascimento')->nullable();

            // Endereço completo como texto livre
            $table->string('endereco')->nullable();

            // CPF com unique para não cadastrar duplicado
            $table->string('cpf', 14)->unique()->nullable(); // Ex: "123.456.789-00"

            // enum() → lista de valores permitidos. O banco rejeita qualquer
            // valor fora desta lista. Perfeito para status fixos.
            $table->enum('sexo', ['M', 'F', 'Outro'])->nullable();

            // Observações médicas ou outras notas sobre o aluno
            $table->text('observacoes')->nullable();

            // boolean indica se o aluno está ativo na academia
            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
