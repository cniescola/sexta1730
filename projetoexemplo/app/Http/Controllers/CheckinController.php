<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Checkin;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | index() → Lista check-ins do dia
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        // Busca check-ins de hoje, mostrando quem ainda está na academia
        $checkinHoje = Checkin::with('aluno')
            ->whereDate('entrada', today())
            ->latest('entrada')
            ->get();

        // Histórico paginado (todos os dias)
        $historico = Checkin::with('aluno')
            ->latest()
            ->paginate(20);

        return view('checkins.index', compact('checkinHoje', 'historico'));
    }

    /*
    |--------------------------------------------------------------------------
    | store() → Registra um check-in
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'aluno_id'   => 'required|exists:alunos,id',
            'observacao' => 'nullable|string|max:255',
        ]);

        // now() → data e hora atual (Carbon)
        $dados['entrada'] = now();

        Checkin::create($dados);

        return redirect()->route('checkins.index')
            ->with('success', 'Check-in registrado!');
    }

    /*
    |--------------------------------------------------------------------------
    | registrarSaida() → Registra a saída do aluno
    |--------------------------------------------------------------------------
    */
    public function registrarSaida(Checkin $checkin)
    {
        // Atualiza apenas a coluna saída com a hora atual
        $checkin->update(['saida' => now()]);

        return redirect()->route('checkins.index')
            ->with('success', 'Saída registrada!');
    }
}
