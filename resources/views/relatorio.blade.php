@extends('layouts.main')

@section('title', 'Relatório')

@section('content')

<div class="container">
    <h3>Aqui você pode ver um relatório de Consultas recentes</h3>
    <hr>
    
    <div class="row">
        <div class="col-md-8">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Instituição</th>
                        <th>Modalidade</th>
                        <th>Valor A Pagar</th>
                        <th>Valor Solicitado</th>
                        <th>Taxa de Juros</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultas as $consulta)
                        <tr>
                            <td>{{ $consulta->cpf }}</td>
                            <td>{{ $consulta->instituicaoFinanceira }}</td>
                            <td>{{ $consulta->modalidadeCredito }}</td>
                            @if ($consulta->valorAPagar == 0.00)
                                <td>Valor Socilitado ou Quantidade de Parcelas inválido</td>
                            @else
                                <td>{{ $consulta->valorAPagar }}</td>
                            @endif
                            <td>{{ $consulta->valorSolicitado }}</td>
                            <td>{{ $consulta->taxaJuros }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            Gráfico
        </div>
    </div>

</div>

@endsection('content')