<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ConsumeApi;
use App\Models\Log;

class ConsultaController extends Controller
{
    //

    public function consulta(Request $request) {
        $cpf = $request->cpf;
        $valorSolicitado = $request->valorSolicitado;
        $qtdParcelas = $request->qntParcelas;
        
        $arrayFinalOfertas = array();
        $req = ConsumeApi::post('/credito', ['cpf' => $cpf]);
        $ofertas = json_decode($req);

        foreach ($ofertas as $instituicoes) {

            foreach ($instituicoes as $instituicao) {
               $idInstituicao = $instituicao->id;
               $nomeInstituicao = $instituicao->nome;
               
               foreach ($instituicao->modalidades as $modalidade) {
                    $modalidadeNome = $modalidade->nome;
                    $modalidadeCod = $modalidade->cod;
                    
                    $detalhes = json_decode(ConsumeApi::post('/oferta', [
                        'cpf' => $request->cpf,
                        'instituicao_id' => $idInstituicao,
                        'codModalidade' => $modalidadeCod,
                    ]));
                    $jurosMes = $detalhes->jurosMes;
                    $valorMin = $detalhes->valorMin;
                    $valorMax = $detalhes->valorMax;
                    $qntParcelaMin = $detalhes->QntParcelaMin;
                    $qntParcelaMax = $detalhes->QntParcelaMax;
                    
                    if(($qntParcelaMax >= $qtdParcelas && $qntParcelaMin <= $qtdParcelas) && ($valorMin <= $valorSolicitado && $valorMax >= $valorSolicitado)) {
                     
                        $valorJuros = $valorSolicitado * $jurosMes * $qtdParcelas;
                        $valorAPagar = $valorSolicitado + $valorJuros;

                        $arrayFinalOfertas[] = array(
                            'instituicaoFinanceira' => array(
                                'id' => $idInstituicao,
                                'nome' => $nomeInstituicao,
                            ),
                            'modalidadeCredito' => array(
                                'nome' => $modalidadeNome,
                                'cod' => $modalidadeCod,
                            ),
                            'valorAPagar' => $valorAPagar,
                            'valorSolicitado' => $valorSolicitado,
                            'taxaJuros' => $jurosMes,
                            'qntParcelas' => $qtdParcelas,
                        );
                    } else {
                        $valorAPagar = 0;
                        $arrayFinalOfertas[] = array(
                            'instituicaoFinanceira' => array(
                                'id' => $idInstituicao,
                                'nome' => $nomeInstituicao,
                            ),
                            'modalidadeCredito' => array(
                                'nome' => $modalidadeNome,
                                'cod' => $modalidadeCod,
                            ),
                            'valorAPagar' => $valorAPagar,
                            'valorSolicitado' => ($valorMin <= $valorSolicitado && $valorMax >= $valorSolicitado) ? $valorSolicitado : "Valor Solicitado Inválido",
                            'taxaJuros' => $jurosMes,
                            'qntParcelas' => ($qntParcelaMax >= $qtdParcelas && $qntParcelaMin <= $qtdParcelas) ? $qtdParcelas : "Quantidade de Parcelas Inválidas",
                        );
                    }

                    $arrayInserirBanco = array(
                        'cpf' => $cpf,
                        'idInstituicao' => $idInstituicao,
                        'instituicaoFinanceira' => $nomeInstituicao,
                        'modalidadeCredito' => $modalidadeNome,
                        'codModalidade' => $modalidadeCod,
                        'valorAPagar' => $valorAPagar,
                        'valorSolicitado' => $valorSolicitado,
                        'taxaJuros' => $jurosMes,
                        'qntParcelas' => $qtdParcelas,
                    );
                    Log::create($arrayInserirBanco);
               }
            }
        }

        $ordem = array();
        foreach($arrayFinalOfertas as $key => $oferta) {
            $oferta['valorAPagar'] = ($oferta['valorAPagar'] == 0) ? PHP_INT_MAX : $oferta['valorAPagar'];
            $ordem[$key] = $oferta['valorAPagar'];
        }
        array_multisort($ordem, SORT_ASC, $arrayFinalOfertas);

        return response()->json(
            $arrayFinalOfertas,
        );
    }
}
