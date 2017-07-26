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
                        <canvas id="prepolizas" width="1428" height="300" style="display: block; width: 1428px; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de Cuentas Contables</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="cuentas_contables" width="1428" height="300" style="display: block; width: 1428px; height: 300px;"></canvas>
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

        var config_prepolizas = {
            type: 'line',
            data: {
                labels: ["2017-07-18", "2017-07-19", "2017-07-20", "2017-07-21", "2017-07-22", "2017-07-23", "2017-07-24"],
                datasets: [{
                    label: "Lanzadas",
                    backgroundColor: chartColors.green,
                    borderColor: chartColors.green,
                    data: [
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1)
                    ],
                    fill: false,
                }, {
                    label: "No Lanzadas",
                    fill: false,
                    backgroundColor: chartColors.orange,
                    borderColor: chartColors.orange,
                    data: [
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1)
                    ],
                }, {
                        label: "Validadas",
                        fill: false,
                        backgroundColor: chartColors.blue,
                        borderColor: chartColors.blue,
                        data: [
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1)
                        ],
                    }, {
                        label: "No Validadas",
                        fill: false,
                        backgroundColor: chartColors.yellow,
                        borderColor: chartColors.yellow,
                        data: [
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1),
                            Math.floor((Math.random() * 20) + 1)
                        ],
                    }, {
                    label: "Con Errores",
                    fill: false,
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    data: [
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1)
                    ],
                }, {
                    label: "Omitidas",
                    fill: false,
                    backgroundColor: chartColors.grey,
                    borderColor: chartColors.grey,
                    data: [
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1),
                        Math.floor((Math.random() * 20) + 1)
                    ],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Del 2017-07-17 al 2017-07-21'
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
            data: {
                labels: ["Almacenes", "Conceptos", "Materiales", "Empresas"],
                datasets: [
                    {
                        label: 'Con Cuenta Contable',
                        backgroundColor: window.chartColors.green,
                        data: [
                            1560-500, 15000-10999, 5909-909, 1400-300
                        ]
                    },
                    {
                        label: 'Sin Cuenta Contable',
                        backgroundColor: window.chartColors.red,
                        data: [
                            500, 10999, 909, 300
                        ]
                    }
                ]
            },
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
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        };

        window.onload = function() {
            var prepolizas = document.getElementById("prepolizas").getContext("2d");
            window.myLine = new Chart(prepolizas, config_prepolizas);

            var cuentas_contables = document.getElementById("cuentas_contables").getContext("2d");
            window.myBar = new Chart(cuentas_contables, config_cuentas_contables);
        };
    </script>
@endsection