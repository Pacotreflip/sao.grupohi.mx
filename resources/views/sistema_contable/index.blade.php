@extends('sistema_contable.layout')
@section('title', 'Sistema Contable')
@section('contentheader_title', 'SISTEMA CONTABLE')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Información Semanal de Prepólizas</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="prepolizas" width="1428" height="300" ></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de Cuentas Contables</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="cuentas_contables" width="1428" height="450" style="display: block; width: 1428px; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Acumulados de Prepólizas</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="acumulado" width="762" height="500"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('scripts-content')
    <script>
        var chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        var data = {!! json_encode($config)!!};
        var dataAcumulado = {!! json_encode($acumulado)!!};
        var cuentas_contables = {!! json_encode($cuentas_contables)!!};

        var config_prepolizas = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Del {{$config['labels'][0]}} al {{$config['labels'][count($config['labels']) -1]}}'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Día'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'No. de Prepólizas'
                        }
                    }]
                }
            }
        };
        var config_cuentas_contables = {
            type: 'bar',
            data: cuentas_contables,
            options: {
                title:{
                    display:true,
                    text:"Relación de Cuentas Contables"
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        stacked: false,
                    }],
                    yAxes: [{
                        stacked: false
                    }]
                }
            }
        };
        var fecha = new Date();
        var config_acumulado = {
            type: 'doughnut',
            data: dataAcumulado,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: fecha.getDate()+' / '+(fecha.getMonth() + 1)+' / '+fecha.getFullYear()
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        $(document).ready(function() {
            var prepolizas = $("#prepolizas")[0].getContext("2d");
           var line = new Chart(prepolizas, config_prepolizas);

            var cuentas_contables = $("#cuentas_contables")[0].getContext("2d");
            var bar = new Chart(cuentas_contables, config_cuentas_contables);

            var acumulado = $("#acumulado")[0].getContext("2d");
            var doughnut = new Chart(acumulado, config_acumulado);
        });

    </script>
@endsection