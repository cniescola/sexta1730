# 🏋️ FitManager Pro — Guia Completo de Desenvolvimento Laravel

> **Sistema de Gerenciamento de Academia com Laravel + Breeze**
> Guia educativo passo a passo para ensinar Laravel do zero.

---

## 📋 O QUE CONSTRUÍMOS

Um sistema completo de gerenciamento de academia com:
- ✅ Login e Cadastro com **Laravel Breeze**
- ✅ Dashboard com estatísticas
- ✅ Cadastro e gerenciamento de **Alunos**
- ✅ Gerenciamento de **Planos** (Mensal, Trimestral, Anual...)
- ✅ Controle de **Matrículas** (com cálculo automático de vencimento)
- ✅ Sistema de **Check-in** (frequência dos alunos)
- ✅ Visual tema academia **dark mode** com laranja

**Para acessar o sistema:**
- URL: `http://localhost:8000`
- Email: `admin@fitmanager.com`
- Senha: `password`

---

## 🧩 CONCEITOS FUNDAMENTAIS DO LARAVEL

### O que é Laravel?
Laravel é um **framework PHP** — uma coleção de ferramentas e convenções que aceleram o desenvolvimento de aplicações web. Em vez de escrever tudo do zero, você usa o que o Laravel já oferece.

### O padrão MVC
Laravel usa o padrão **MVC (Model-View-Controller)**:

```
Usuário → URL → ROTA → CONTROLLER → MODEL (banco) → VIEW (HTML) → Usuário
```

| Parte | Onde fica | O que faz |
|-------|-----------|-----------|
| **Route** | `routes/web.php` | Define qual URL chama qual Controller |
| **Controller** | `app/Http/Controllers/` | Recebe a requisição, processa, retorna resposta |
| **Model** | `app/Models/` | Representa e conversa com a tabela do banco |
| **View** | `resources/views/` | HTML com Blade (o que o usuário vê) |

---

## 🔧 PASSO 1: CRIAR O PROJETO LARAVEL

Se for criar um projeto do zero:

```bash
# Instala o Laravel via Composer
composer create-project laravel/laravel nome-do-projeto

# Entra na pasta
cd nome-do-projeto
```

**O que o Composer faz?**
Composer é o gerenciador de pacotes do PHP. Ele baixa o Laravel e todas as suas dependências automaticamente.

---

## 🔑 PASSO 2: INSTALAR O BREEZE (Sistema de Login)

### O que é o Breeze?
O **Laravel Breeze** é um pacote oficial que instala tudo que você precisa para ter login, registro, recuperação de senha e perfil — já pronto, com código limpo e comentado.

### Instalar o Breeze:

```bash
# Passo 1: Baixar o pacote via Composer
composer require laravel/breeze --dev

# Passo 2: "Publicar" os arquivos do Breeze no projeto
# blade = usar templates Blade (HTML puro, sem JavaScript reativo)
php artisan breeze:install blade

# Passo 3: Instalar dependências JavaScript e compilar
npm install
npm run build
```

### O que o Breeze cria?
Após instalar, o Breeze cria automaticamente:

```
📁 app/Http/Controllers/Auth/
├── AuthenticatedSessionController.php  ← Lógica de login/logout
├── RegisteredUserController.php        ← Lógica de cadastro
├── PasswordResetLinkController.php     ← Esqueci minha senha
└── ...outros controllers de auth

📁 resources/views/auth/
├── login.blade.php                     ← Página de login
├── register.blade.php                  ← Página de cadastro
└── forgot-password.blade.php           ← Recuperação de senha

📁 routes/auth.php                      ← Todas as rotas de autenticação
```

### Rotas que o Breeze registra automaticamente:

| Método | URL | O que faz |
|--------|-----|-----------|
| GET | `/login` | Exibe o formulário de login |
| POST | `/login` | Processa o login |
| POST | `/logout` | Faz logout |
| GET | `/register` | Exibe o formulário de registro |
| POST | `/register` | Cria nova conta |
| GET | `/forgot-password` | Formulário de recuperação |
| POST | `/forgot-password` | Envia email de recuperação |

---

## 🗄️ PASSO 3: CONFIGURAR O BANCO DE DADOS

### O arquivo `.env`
O arquivo `.env` guarda as configurações do ambiente. **Nunca sobe para o git!**

```env
APP_NAME="FitManager Pro"    # Nome da aplicação
DB_CONNECTION=sqlite         # Tipo do banco (sqlite, mysql, pgsql)
```

### SQLite vs MySQL
No desenvolvimento, usamos **SQLite** — um banco de dados que fica em um único arquivo (`database/database.sqlite`). É simples e não precisa instalar nada extra.

Para produção, geralmente se usa **MySQL**.

---

## 🏗️ PASSO 4: MIGRATIONS (Estrutura do banco)

### O que é uma Migration?
Migration é uma "receita" em PHP que define como criar ou modificar tabelas do banco. Em vez de abrir o banco e escrever SQL manualmente, você escreve PHP.

**Vantagem:** O código fica no Git, então todo o time usa a mesma estrutura.

### Criar uma migration:

```bash
php artisan make:migration create_alunos_table
```

O arquivo é criado em `database/migrations/` com timestamp no nome.

### Estrutura de uma Migration:

```php
// O método up() define O QUE CRIAR
public function up(): void
{
    Schema::create('alunos', function (Blueprint $table) {
        $table->id();                    // id INTEGER AUTO_INCREMENT
        $table->string('nome');          // VARCHAR(255) NOT NULL
        $table->string('email')->unique(); // VARCHAR(255) UNIQUE
        $table->string('telefone')->nullable(); // pode ser NULL
        $table->date('data_nascimento')->nullable();
        $table->boolean('ativo')->default(true);
        $table->timestamps();            // created_at e updated_at
    });
}

// O método down() define COMO DESFAZER (rollback)
public function down(): void
{
    Schema::dropIfExists('alunos');
}
```

### Tipos de colunas mais comuns:

| Método | Tipo SQL | Uso |
|--------|----------|-----|
| `id()` | INT AUTO_INCREMENT | Chave primária |
| `string('col')` | VARCHAR(255) | Texto curto |
| `text('col')` | TEXT | Texto longo |
| `integer('col')` | INT | Número inteiro |
| `decimal('col', 8, 2)` | DECIMAL | Dinheiro/preços |
| `boolean('col')` | TINYINT(1) | Verdadeiro/falso |
| `date('col')` | DATE | Data (sem hora) |
| `dateTime('col')` | DATETIME | Data e hora |
| `timestamps()` | DATETIME x2 | created_at + updated_at |
| `foreignId('col')` | INT | Chave estrangeira |

### Chaves Estrangeiras (Relacionamentos):

```php
// Cria coluna aluno_id que referencia a tabela alunos
$table->foreignId('aluno_id')
      ->constrained('alunos')     // qual tabela referencia
      ->cascadeOnDelete();        // ao deletar aluno, deleta matrículas também
```

### Executar as migrations:

```bash
php artisan migrate          # Executa migrations pendentes
php artisan migrate:fresh    # Apaga tudo e recria (use em desenvolvimento)
php artisan migrate:rollback # Desfaz a última migration
```

---

## 📦 PASSO 5: MODELS (Comunicação com o banco)

### O que é um Model?
Model é a classe PHP que representa uma tabela do banco. Ele usa o **Eloquent ORM** — um sistema que transforma PHP em SQL.

```bash
php artisan make:model Aluno
```

Cria o arquivo em `app/Models/Aluno.php`.

### Convenção do Eloquent:
- Classe `Aluno` → tabela `alunos` (pluralizado e minúsculo)
- Classe `Plano` → tabela `planos`
- Classe `Matricula` → tabela `matriculas`

### Estrutura de um Model:

```php
class Aluno extends Model
{
    // $fillable: lista os campos permitidos para "Mass Assignment"
    // Proteção de segurança: evita que campos extras sejam salvos
    protected $fillable = ['nome', 'email', 'telefone', 'ativo'];

    // $casts: converte tipos automaticamente ao ler do banco
    protected $casts = [
        'data_nascimento' => 'date',    // string → Carbon (objeto de data)
        'ativo'           => 'boolean', // 1/0 → true/false
    ];

    // Relacionamentos: Um Aluno tem MUITAS matrículas
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
```

### Operações Eloquent mais comuns:

```php
// Buscar todos os alunos
Aluno::all()

// Buscar com filtro
Aluno::where('ativo', true)->get()

// Buscar paginado (10 por página)
Aluno::paginate(10)

// Buscar por ID (retorna 404 se não encontrar)
Aluno::findOrFail($id)

// Criar um novo registro
Aluno::create(['nome' => 'João', 'email' => 'joao@email.com'])

// Atualizar um registro
$aluno->update(['nome' => 'João Silva'])

// Excluir um registro
$aluno->delete()

// Contar registros
Aluno::count()
Aluno::where('ativo', true)->count()
```

### Tipos de Relacionamentos:

```php
// hasMany → "tem muitos" (um aluno tem muitas matrículas)
class Aluno {
    public function matriculas() {
        return $this->hasMany(Matricula::class);
    }
}

// belongsTo → "pertence a" (uma matrícula pertence a um aluno)
class Matricula {
    public function aluno() {
        return $this->belongsTo(Aluno::class);
    }
}

// Como usar:
$aluno->matriculas    // Collection de matrículas do aluno
$matricula->aluno     // O aluno daquela matrícula
```

---

## 🎮 PASSO 6: CONTROLLERS (A lógica da aplicação)

### O que é um Controller?
Controller é o "gerente" — recebe a requisição do usuário, processa os dados, e retorna uma resposta (view HTML).

```bash
# Cria um Resource Controller (com 7 métodos prontos)
php artisan make:controller AlunoController --resource
```

### Resource Controller — Os 7 métodos:

| Método | URL | HTTP | Ação |
|--------|-----|------|------|
| `index()` | `/alunos` | GET | Lista todos |
| `create()` | `/alunos/create` | GET | Exibe formulário de criação |
| `store()` | `/alunos` | POST | Salva novo registro |
| `show()` | `/alunos/{id}` | GET | Exibe um registro |
| `edit()` | `/alunos/{id}/edit` | GET | Exibe formulário de edição |
| `update()` | `/alunos/{id}` | PUT | Atualiza registro |
| `destroy()` | `/alunos/{id}` | DELETE | Exclui registro |

### Exemplo de método com validação:

```php
public function store(Request $request)
{
    // validate() → verifica as regras e redireciona com erros se falhar
    $dados = $request->validate([
        'nome'  => 'required|string|max:255',  // obrigatório, texto, máx 255
        'email' => 'required|email|unique:alunos,email', // único na tabela
        'ativo' => 'boolean',
    ]);

    // Cria o registro no banco
    Aluno::create($dados);

    // Redireciona com mensagem de sucesso
    return redirect()->route('alunos.index')
        ->with('success', 'Aluno criado com sucesso!');
}
```

### Route Model Binding:

```php
// Em vez de:
public function show($id) {
    $aluno = Aluno::findOrFail($id); // busca manualmente
    return view('alunos.show', compact('aluno'));
}

// Você pode fazer:
public function show(Aluno $aluno) {
    // Laravel busca automaticamente pelo {aluno} na URL!
    return view('alunos.show', compact('aluno'));
}
```

---

## 🗺️ PASSO 7: ROTAS (routes/web.php)

### O que são rotas?
Rotas mapeiam URLs para métodos de Controller.

### Sintaxe básica:

```php
// Rota simples
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resource Route (registra as 7 rotas de uma vez!)
Route::resource('alunos', AlunoController::class);

// Grupo com middleware (protege rotas)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('alunos', AlunoController::class);
});
```

### Middleware 'auth':
```php
// Se o usuário NÃO estiver logado → redireciona para /login
// Se estiver logado → deixa passar normalmente
->middleware('auth')
```

### Nomes de rotas e como usar:

```php
// Definir um nome para a rota
Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');

// Usar em PHP (no controller)
return redirect()->route('alunos.index');

// Usar no Blade (na view)
<a href="{{ route('alunos.index') }}">Lista de Alunos</a>
<a href="{{ route('alunos.show', $aluno) }}">Ver Aluno</a>
```

---

## 🎨 PASSO 8: VIEWS BLADE (O HTML)

### O que é Blade?
Blade é o motor de templates do Laravel. É HTML com "superpoderes" PHP.

### Arquivo: `resources/views/alunos/index.blade.php`

### Sintaxe Blade:

```blade
{{-- Comentário Blade (não aparece no HTML) --}}

{{-- Exibe variável COM proteção XSS --}}
{{ $aluno->nome }}

{{-- Exibe HTML SEM proteção (use com cuidado) --}}
{!! $texto_html !!}

{{-- Condicional --}}
@if($aluno->ativo)
    <span>Ativo</span>
@elseif($condicao)
    <span>Outra coisa</span>
@else
    <span>Inativo</span>
@endif

{{-- Loop com fallback para lista vazia --}}
@forelse($alunos as $aluno)
    <p>{{ $aluno->nome }}</p>
@empty
    <p>Nenhum aluno encontrado</p>
@endforelse

{{-- Seção de título para o layout --}}
@section('title', 'Lista de Alunos')

{{-- Bloco PHP no Blade (use com moderação) --}}
@php
    $total = $alunos->count();
@endphp
```

### Usar o layout:

```blade
{{-- Usa o layout app.blade.php --}}
<x-app-layout>
    @section('title', 'Alunos')

    {{-- Tudo aqui vai para {{ $slot }} do layout --}}
    <h1>Lista de Alunos</h1>
</x-app-layout>
```

### Formulários no Blade:

```blade
{{-- Formulário de CRIAÇÃO --}}
<form method="POST" action="{{ route('alunos.store') }}">
    @csrf  {{-- OBRIGATÓRIO! Token de segurança --}}

    <input name="nome" value="{{ old('nome') }}">  {{-- old() recupera valor após erro --}}

    @error('nome')  {{-- Exibe erro de validação deste campo --}}
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Salvar</button>
</form>

{{-- Formulário de EDIÇÃO --}}
<form method="POST" action="{{ route('alunos.update', $aluno) }}">
    @csrf
    @method('PUT')  {{-- Simula o método HTTP PUT --}}

    <input name="nome" value="{{ old('nome', $aluno->nome) }}">
</form>

{{-- Formulário de EXCLUSÃO --}}
<form method="POST" action="{{ route('alunos.destroy', $aluno) }}"
      onsubmit="return confirm('Tem certeza?')">
    @csrf
    @method('DELETE')
    <button type="submit">Excluir</button>
</form>
```

---

## 🎨 PASSO 9: ESTILIZAÇÃO COM TAILWIND CSS

### O que é Tailwind CSS?
Tailwind é um framework CSS "utility-first". Em vez de classes prontas como `.btn`, você combina classes pequenas:

```html
<!-- Botão laranja com borda arredondada, padding e hover -->
<button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors">
    Clique
</button>
```

### Como Tailwind funciona no Laravel?
1. Você escreve classes Tailwind nos arquivos Blade
2. O Vite compila e gera o `public/build/assets/app.css` com **apenas** as classes que você usou
3. Resultado: CSS mínimo e otimizado

### Cores customizadas (tailwind.config.js):

```js
colors: {
    'gym-dark':    '#0f0f0f',  // Cor de fundo principal
    'gym-sidebar': '#1a1a1a',  // Sidebar
    'gym-card':    '#1e1e1e',  // Cards
    'gym-accent':  '#f97316',  // Laranja (cor principal)
}
```

Depois você usa: `bg-gym-dark`, `text-gym-accent`, etc.

### Classes customizadas (app.css):

```css
/* Criamos classes próprias usando @layer components */
@layer components {
    .btn-primary {
        @apply bg-gym-accent text-white px-4 py-2 rounded-lg;
        /* @apply → aplica classes Tailwind dentro de uma classe CSS */
    }

    .card {
        @apply bg-gym-card border border-gym-border rounded-xl p-6;
    }

    .form-input {
        @apply w-full bg-gray-800 border border-gray-700 text-white
               rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-500;
    }
}
```

---

## 🌱 PASSO 10: SEEDERS (Dados de teste)

### O que é um Seeder?
Seeder popula o banco com dados de teste para desenvolvimento.

```bash
php artisan make:seeder GimnasioSeeder
```

### Executar os seeders:

```bash
# Rodar todos os seeders
php artisan db:seed

# Rodar um seeder específico
php artisan db:seed --class=GimnasioSeeder

# Apagar tudo e recriar com dados
php artisan migrate:fresh --seed
```

---

## ▶️ COMO RODAR O PROJETO

```bash
# 1. Entrar na pasta do projeto
cd Projeto1

# 2. Instalar dependências PHP (se não instalou ainda)
composer install

# 3. Instalar dependências JavaScript (se não instalou ainda)
npm install

# 4. Criar as tabelas e popular com dados de demo
php artisan migrate:fresh --seed

# 5. Compilar os assets CSS/JS
npm run build

# 6. Iniciar o servidor
php artisan serve
```

Acesse: **http://localhost:8000**
Login: `admin@fitmanager.com` / `password`

---

## 📁 ESTRUTURA DE ARQUIVOS DO PROJETO

```
Projeto1/
│
├── 📁 app/
│   ├── 📁 Http/
│   │   └── 📁 Controllers/           ← Lógica da aplicação
│   │       ├── DashboardController.php
│   │       ├── AlunoController.php
│   │       ├── PlanoController.php
│   │       ├── MatriculaController.php
│   │       ├── CheckinController.php
│   │       └── 📁 Auth/              ← Controllers do Breeze
│   └── 📁 Models/                    ← Comunicação com o banco
│       ├── User.php                  ← Model padrão do Laravel
│       ├── Aluno.php
│       ├── Plano.php
│       ├── Matricula.php
│       └── Checkin.php
│
├── 📁 database/
│   ├── 📁 migrations/                ← Estrutura das tabelas
│   │   ├── ...create_users_table.php
│   │   ├── ...create_alunos_table.php
│   │   ├── ...create_planos_table.php
│   │   ├── ...create_matriculas_table.php
│   │   └── ...create_checkins_table.php
│   └── 📁 seeders/                   ← Dados de teste
│       ├── DatabaseSeeder.php        ← Ponto de entrada
│       └── GimnasioSeeder.php        ← Dados da academia
│
├── 📁 resources/
│   ├── 📁 css/
│   │   └── app.css                   ← Estilos customizados
│   └── 📁 views/                     ← HTML (Blade templates)
│       ├── 📁 layouts/
│       │   ├── app.blade.php         ← Layout principal (sidebar)
│       │   └── guest.blade.php       ← Layout do login
│       ├── 📁 auth/                  ← Páginas do Breeze
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── dashboard.blade.php       ← Página inicial
│       ├── 📁 alunos/
│       │   ├── index.blade.php       ← Lista de alunos
│       │   ├── create.blade.php      ← Formulário novo aluno
│       │   ├── edit.blade.php        ← Formulário edição
│       │   └── show.blade.php        ← Perfil do aluno
│       ├── 📁 planos/
│       ├── 📁 matriculas/
│       └── 📁 checkins/
│
├── 📁 routes/
│   ├── web.php                       ← Rotas principais
│   └── auth.php                      ← Rotas do Breeze (login etc.)
│
├── tailwind.config.js                ← Configuração do Tailwind
├── .env                              ← Configurações do ambiente
└── composer.json                     ← Dependências PHP
```

---

## 🔄 FLUXO DE UMA REQUISIÇÃO (Exemplo: Abrir /alunos)

```
1. Usuário acessa: http://localhost:8000/alunos
       ↓
2. routes/web.php encontra:
   Route::resource('alunos', AlunoController::class);
       ↓
3. Como é GET /alunos → chama AlunoController@index()
       ↓
4. AlunoController::index() executa:
   $alunos = Aluno::latest()->paginate(12);
   return view('alunos.index', compact('alunos'));
       ↓
5. Eloquent executa no banco:
   SELECT * FROM alunos ORDER BY created_at DESC LIMIT 12
       ↓
6. O resultado vai para resources/views/alunos/index.blade.php
       ↓
7. Blade gera o HTML com os dados dos alunos
       ↓
8. O HTML é retornado para o navegador
```

---

## 💡 DICAS IMPORTANTES

### 1. Sempre use `@csrf` em formulários POST/PUT/DELETE
```blade
<form method="POST" action="...">
    @csrf  ← SEM ISSO O LARAVEL RETORNA ERRO 419!
    ...
</form>
```

### 2. Use `old()` nos inputs para preservar dados após erro
```blade
<input name="nome" value="{{ old('nome', $aluno->nome ?? '') }}">
```

### 3. Use `@method()` para PUT/PATCH/DELETE em formulários
```blade
<form method="POST" ...>
    @csrf
    @method('DELETE')  ← Simula DELETE pois HTML só suporta GET e POST
</form>
```

### 4. Mensagens flash funcionam assim:
```php
// No Controller:
return redirect()->route('alunos.index')->with('success', 'Criado!');

// No layout (app.blade.php):
@if(session('success'))
    <div>{{ session('success') }}</div>
@endif
```

### 5. Eager Loading evita o "N+1 problem"
```php
// ❌ Ruim: Faz 1 query por aluno para buscar a matrícula
$alunos = Aluno::all();
foreach ($alunos as $aluno) {
    echo $aluno->matriculas; // 1 query extra por aluno!
}

// ✅ Bom: Faz apenas 2 queries no total
$alunos = Aluno::with('matriculas')->get();
```

---

## 🛠️ COMANDOS ARTISAN MAIS USADOS

```bash
# Servidor de desenvolvimento
php artisan serve

# Criar arquivos
php artisan make:model NomeModel
php artisan make:controller NomeController --resource
php artisan make:migration create_tabela_table
php artisan make:seeder NomeSeeder

# Banco de dados
php artisan migrate              # Rodar migrations pendentes
php artisan migrate:fresh        # Apagar tudo e recriar
php artisan migrate:fresh --seed # Recriar + rodar seeders
php artisan db:seed              # Rodar seeders

# Diagnóstico
php artisan route:list           # Listar todas as rotas
php artisan tinker               # Console interativo PHP/Laravel

# Cache
php artisan config:clear         # Limpa cache de config
php artisan view:clear           # Limpa cache de views
```

---

## 📚 GLOSSÁRIO

| Termo | Significado |
|-------|-------------|
| **Artisan** | CLI (linha de comando) do Laravel |
| **Blade** | Motor de templates do Laravel |
| **Composer** | Gerenciador de pacotes PHP |
| **Controller** | Classe que processa requisições |
| **Eloquent** | ORM do Laravel (PHP ↔ banco de dados) |
| **Migration** | Arquivo que define estrutura do banco |
| **Middleware** | Código executado antes do Controller |
| **Model** | Classe que representa uma tabela do banco |
| **MVC** | Padrão de arquitetura: Model-View-Controller |
| **ORM** | Object Relational Mapper |
| **Route** | Mapeamento de URL para Controller |
| **Seeder** | Arquivo que popula o banco com dados |
| **Tailwind** | Framework CSS utilitário |
| **View** | Template HTML (arquivo .blade.php) |
| **Vite** | Bundler de assets (CSS, JS) |
| **Breeze** | Kit de autenticação do Laravel |
| **CSRF** | Proteção contra falsificação de requisições |
| **Mass Assignment** | Criar/atualizar com array de dados |
| **Eager Loading** | Carregar relacionamentos eficientemente |
| **Carbon** | Biblioteca PHP para trabalhar com datas |
| **Facade** | Interface estática para serviços do Laravel |
```
