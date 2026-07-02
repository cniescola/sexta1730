<?php

/*
|--------------------------------------------------------------------------
| SEEDER PRINCIPAL: DatabaseSeeder
|--------------------------------------------------------------------------
|
| O DatabaseSeeder é o ponto de entrada de todos os seeders.
| Ao rodar "php artisan db:seed", este arquivo é executado.
| Ele pode chamar outros seeders em sequência.
|
*/

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cria o usuário administrador do sistema
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@fitmanager.com',
            // Hash::make() → criptografa a senha com bcrypt
            // NUNCA armazene senhas em texto puro!
            'password' => Hash::make('password'),
        ]);

        // Executa o seeder da academia (planos, alunos, etc.)
        $this->call(GimnasioSeeder::class);
    }
}
