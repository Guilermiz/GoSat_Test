<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    //
    public function relatorio() {

        $consultas = Log::orderBy('id', 'desc')->get();

        return view('relatorio', ['consultas' => $consultas]);
    }
}
