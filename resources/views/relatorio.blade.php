@extends('layouts.main')

@section('title', 'Relatório')

@section('content')

<div class="container">
    <h3>Consultas Feitas</h3>
    <hr>
    
    <div class="row">
        <div class="col-md-12">
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
                    @foreach($cpfs as $cpf)
                        <tr>
                            <td>{{ $cpf->cpf }}</td>
                            <td>
                            @foreach($consultas as $consulta)
                                @if($consulta->cpf == $cpf->cpf)
                                    <table>
                                        <tr>
                                            <td><span>{{ $consulta->instituicaoFinanceira }}</span></td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach
                            </td>
                            <td>
                            @foreach($consultas as $consulta)
                                @if($consulta->cpf == $cpf->cpf)
                                    <table>
                                        <tr>
                                            <td><span>{{ $consulta->modalidadeCredito }}</span></td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach
                            </td>
                            <td>
                            @foreach($consultas as $consulta)
                                @if($consulta->cpf == $cpf->cpf)
                                    <table>
                                        <tr>
                                            <td><span>{{ $consulta->valorAPagar }}</span></td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach
                            </td>
                            <td>
                            @foreach($consultas as $consulta)
                                @if($consulta->cpf == $cpf->cpf)
                                    <table>
                                        <tr>
                                            <td><span>{{ $consulta->valorSolicitado }}</span></td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach
                            </td>
                            <td>
                            @foreach($consultas as $consulta)
                                @if($consulta->cpf == $cpf->cpf)
                                    <table>
                                        <tr>
                                            <td><span>{{ $consulta->taxaJuros }}</span></td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection('content')