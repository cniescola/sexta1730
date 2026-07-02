<?php

/*
|--------------------------------------------------------------------------
| SEEDER: GimnasioSeeder
|--------------------------------------------------------------------------
|
| O que é um Seeder?
| ------------------
| Seeders populam o banco de dados com dados iniciais ou de teste.
| São muito úteis durante o desenvolvimento para ter dados para trabalhar.
|
| Comando para executar:
| php artisan db:seed --class=GimnasioSeeder
|
| Ou para resetar tudo e popular do zero:
| php artisan migrate:fresh --seed
|
*/

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Checkin;
use App\Models\Matricula;
use App\Models\Plano;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GimnasioSeeder extends Seeder
{
    public function run(): void
    {
        // ====================================================================
        // PLANOS DE EXEMPLO
        // ====================================================================

        // Plano Mensal
        $planomensal = Plano::create([
            'nome'         => 'Plano Mensal',
            'descricao'    => 'Acesso completo à academia por 30 dias. Musculação, cardio e aulas coletivas.',
            'preco'        => 89.90,
            'duracao_dias' => 30,
            'ativo'        => true,
        ]);

        // Plano Trimestral
        $planoTrimestral = Plano::create([
            'nome'         => 'Plano Trimestral',
            'descricao'    => 'Acesso completo por 90 dias com 10% de desconto.',
            'preco'        => 239.90,
            'duracao_dias' => 90,
            'ativo'        => true,
        ]);

        // Plano Semestral
        $planoSemestral = Plano::create([
            'nome'         => 'Plano Semestral',
            'descricao'    => 'Acesso completo por 180 dias com 20% de desconto.',
            'preco'        => 429.90,
            'duracao_dias' => 180,
            'ativo'        => true,
        ]);

        // Plano Anual
        $planoAnual = Plano::create([
            'nome'         => 'Plano Anual',
            'descricao'    => 'Acesso completo por 365 dias com 30% de desconto. Melhor custo-benefício!',
            'preco'        => 749.90,
            'duracao_dias' => 365,
            'ativo'        => true,
        ]);

        // ====================================================================
        // ALUNOS DE EXEMPLO
        // ====================================================================

        $alunos = [
            ['nome' => 'Carlos Eduardo Silva',    'email' => 'carlos@email.com',    'sexo' => 'M', 'telefone' => '(34) 99876-5432'],
            ['nome' => 'Mariana Costa Souza',     'email' => 'mariana@email.com',   'sexo' => 'F', 'telefone' => '(34) 98765-4321'],
            ['nome' => 'Rafael Oliveira Santos',  'email' => 'rafael@email.com',    'sexo' => 'M', 'telefone' => '(34) 97654-3210'],
            ['nome' => 'Fernanda Lima Pereira',   'email' => 'fernanda@email.com',  'sexo' => 'F', 'telefone' => '(34) 96543-2109'],
            ['nome' => 'Lucas Mendes Almeida',    'email' => 'lucas@email.com',     'sexo' => 'M', 'telefone' => '(34) 95432-1098'],
            ['nome' => 'Juliana Rodrigues Cruz',  'email' => 'juliana@email.com',   'sexo' => 'F', 'telefone' => '(34) 94321-0987'],
            ['nome' => 'Pedro Henrique Castro',   'email' => 'pedro@email.com',     'sexo' => 'M', 'telefone' => '(34) 93210-9876'],
            ['nome' => 'Ana Paula Ferreira',      'email' => 'ana@email.com',       'sexo' => 'F', 'telefone' => '(34) 92109-8765'],
        ];

        $alunosCriados = [];
        foreach ($alunos as $dados) {
            $alunosCriados[] = Aluno::create(array_merge($dados, [
                'data_nascimento' => Carbon::now()->subYears(rand(18, 45))->subDays(rand(0, 365)),
                'ativo'           => true,
            ]));
        }

        // ====================================================================
        // MATRÍCULAS E CHECK-INS
        // ====================================================================

        $planos = [$planomensal, $planoTrimestral, $planoSemestral, $planoAnual];

        foreach ($alunosCriados as $index => $aluno) {
            // Cada aluno recebe um plano aleatório
            $plano = $planos[$index % count($planos)];

            $inicio = Carbon::now()->subDays(rand(1, 60));
            $fim = $inicio->copy()->addDays($plano->duracao_dias);

            Matricula::create([
                'aluno_id'    => $aluno->id,
                'plano_id'    => $plano->id,
                'data_inicio' => $inicio->toDateString(),
                'data_fim'    => $fim->toDateString(),
                'status'      => 'ativo',
            ]);

            // Simula check-ins dos últimos 7 dias para este aluno
            for ($dia = 6; $dia >= 0; $dia--) {
                // Nem todo dia vai (70% de chance)
                if (rand(0, 10) > 3) {
                    $entrada = Carbon::today()->subDays($dia)->setHour(rand(6, 20))->setMinute(rand(0, 59));
                    $saida = $entrada->copy()->addMinutes(rand(30, 120));

                    Checkin::create([
                        'aluno_id'  => $aluno->id,
                        'entrada'   => $entrada,
                        'saida'     => $saida,
                        'observacao' => null,
                    ]);
                }
            }
        }

        $this->command->info('✅ Dados de demonstração criados com sucesso!');
        $this->command->info('   - ' . count($planos) . ' planos criados');
        $this->command->info('   - ' . count($alunosCriados) . ' alunos criados');
        $this->command->info('   - Matrículas e check-ins gerados');
    }
}
