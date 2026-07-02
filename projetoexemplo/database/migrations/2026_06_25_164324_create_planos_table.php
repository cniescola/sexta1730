<?php

/*
|--------------------------------------------------------------------------
| MIGRATION: create_planos_table
|--------------------------------------------------------------------------
|
| O que é uma Migration?
| ----------------------
| Migration é como uma "receita" que diz ao Laravel como criar tabelas no
| banco de dados. Em vez de abrir o MySQL e escrever SQL manualmente, você
| escreve PHP aqui e o Laravel cuida do resto.
|
| Vantagens:
| 1. Todo o time usa a mesma estrutura de banco (versionado no git)
| 2. Você pode desfazer alterações com: php artisan migrate:rollback
|
| Comandos úteis:
| - php artisan migrate          → executa as migrations pendentes
| - php artisan migrate:fresh    → apaga tudo e recria do zero
| - php artisan migrate:rollback → desfaz a última migration
|
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Toda migration retorna uma classe anônima que estende Migration
return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Método UP - O que FAZER ao rodar a migration
    |--------------------------------------------------------------------------
    | Executado com: php artisan migrate
    */
    public function up(): void
    {
        // Schema::create('nome_tabela', funcao) → cria uma nova tabela no banco
        Schema::create('planos', function (Blueprint $table) {

            // id() → coluna "id" inteiro, auto-incremento, chave primária
            // Todo registro terá um ID único: 1, 2, 3, ...
            $table->id();

            // string() → campo VARCHAR(255) - texto curto
            $table->string('nome'); // Ex: "Mensal", "Trimestral", "Anual"

            // text() → campo de texto longo, sem limite prático
            // nullable() → pode ser vazio (NULL no banco)
            $table->text('descricao')->nullable();

            // decimal(coluna, total_digitos, casas_decimais) → dinheiro/preços
            // decimal é mais preciso que float para valores monetários
            $table->decimal('preco', 8, 2); // Ex: 99.90, 299.00, 1299.90

            // integer() → número inteiro
            $table->integer('duracao_dias'); // Quanto tempo o plano dura

            // boolean() → verdadeiro/falso (0 ou 1 no banco)
            // default(true) → se não informado, o padrão é ATIVO
            $table->boolean('ativo')->default(true);

            // timestamps() → cria DUAS colunas automaticamente:
            // - created_at: data/hora de criação do registro
            // - updated_at: data/hora da última atualização
            // O Laravel preenche essas colunas sozinho!
            $table->timestamps();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Método DOWN - O que DESFAZER (reverso do up)
    |--------------------------------------------------------------------------
    | Executado com: php artisan migrate:rollback
    */
    public function down(): void
    {
        // dropIfExists() apaga a tabela se ela existir
        Schema::dropIfExists('planos');
    }
};
