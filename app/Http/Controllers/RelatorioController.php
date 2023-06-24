<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    //
    public function relatorio() {

        $consultas = Log::orderBy('id', 'desc')->get();
        $cpfs = DB::table('logs')->select('cpf')->groupBy('cpf')->get();

        return view('relatorio', ['consultas' => $consultas, 'cpfs' => $cpfs]);
    }
}
