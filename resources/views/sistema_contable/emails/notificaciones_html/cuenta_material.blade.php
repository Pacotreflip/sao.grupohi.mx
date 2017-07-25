<?php

?>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <style>
        @charset "utf-8";
        /* CSS Document 090 06C 444 */
        html, body {
            background-color: #808080;
            color: #272727;
            font: 62.5% Calibri, Trebuchet, Verdana, Arial, sans-serif;
            margin: 0;
        }

        div#layout {
            background: none repeat scroll 0 0 #fff;
            margin: 0 auto;
            width: 960px;
            min-width: 960px;
            min-height: 100%;
        }

        div#cuerpo {
            overflow: hidden;
        }

        div#cuerpo div#contenido {
            width: 920px;
            float: left;
            margin: 20px 20px 25px 20px;
        }

        div#cuerpo div#menu + div#contenido {
            width: 800px;
            float: left;
            margin: 20px 20px 25px 20px;
        }

        div#contenido div#seleccion {
            font-size: 1.2em;
            margin: 20px 0 0 20px
        }

        div#footer {
            background: none repeat scroll 0 0 #383838;
            color: #3c3;
            font: normal normal bold 10px/10px Verdana, Geneva, sans-serif;
            text-align: center;
            width: 960px;
            min-width: 960px;
            height: 20px;
            position: fixed;
            bottom: 0px;
        }

        div#footer p {
            margin-top: 5px
        }

        div#contenido div#opc_ctg, div#contenido div#frm_ctg {
            font-size: 1.5em;
        }

        hr {
            color: #7ac142;
            background-color: #7ac142;
            border: 1px solid #7ac142;
        }

        #cargando img {
            margin: 4px
        }

        table {
            font: 12px Calibri, Trebuchet, Verdana, Arial, sans-serif;
        }

        table caption {
            text-align: left;
            font-size: 14px;
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }

        td {
            vertical-align: top;
            padding: 2px;
        }

        table.generica {
            font-size: 12px;
            border: 1px solid #999;
            border-collapse: collapse;
            width: 98%;
            margin: 0px auto;
            color: #333;
        }

        table.generica th {
            background-color: #666;
            color: #DDD;
            border: 1px dotted #999;
        }

        table.generica tr td {
            border: 1px dotted #999;
            padding: 5px;
        }

        table.generica tbody tr:hover {
            background: url(<?php  ?>img/company-icon.png);
        }

        h1 {
            font-size: 20px;
        }
    </style>
</head>
<body>
<div id="load" class="data-loader"></div>
<div id="layout">

    <div id="cuerpo">
        <div id="contenido">
            <h1>Estimado Colaborador {{$usuario}} </h1>
            <h1>Se le informa que los siguientes Materiales no cuentan con cuenta contable asignada favor de
                verificarlas.</h1>
            <h1>Proyecto: {{$obra->nombre}}</h1>
            <div id="lista_contratos">
                @if($material_restante>0)
                    <table class="generica" style="width:100%">
                        <thead>
                        <tr>
                            <th colspan="9" style="text-align: left">MATERIALES</th>
                        </tr>
                        <tr>
                            <th>Configuradas</th>
                            <th>Pendientes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><center><h1><b>{{$material_actual}}</b></h1></center></td>
                            <td><center><h1><b>{{$material_restante}}</b></h1></center></td>
                        </tr>
                        </tbody>
                    </table>
                @endif
                <br/>

                @if($mano_restante>0)
                    <table class="generica" style="width:100%">
                        <thead>
                        <tr>
                            <th colspan="9" style="text-align: left">MANO DE OBRA Y SERVICIOS</th>
                        </tr>
                        <tr>
                            <th>Configuradas</th>
                            <th>Pendientes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><center><h1><b>{{$mano_actual}}</b></h1></center></td>
                            <td><center><h1><b>{{$mano_restante}}</b></h1></center></td>
                        </tr>
                        </tbody>
                    </table>
                @endif

                <br/>

                @if($herramienta_restante>0)
                    <table class="generica" style="width:100%">
                        <thead>
                        <tr>
                            <th colspan="9" style="text-align: left">HERRAMIENTA Y EQUIPO</th>
                        </tr>
                        <tr>
                            <th>Configuradas</th>
                            <th>Pendientes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><center><h1><b>{{$herramienta_actual}}</b></h1></center></td>
                            <td><center><h1><b>{{$herramienta_restante}}</b></h1></center></td>
                        </tr>
                        </tbody>
                    </table>
                @endif
                <br/>
                @if($maquinaria_restante>0)
                    <table class="generica" style="width:100%">
                        <thead>
                        <tr>
                            <th colspan="9" style="text-align: left">MAQUINARIA</th>
                        </tr>
                        <tr>
                            <th>Configuradas</th>
                            <th>Pendientes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><center><h1><b>{{$maquinaria_actual}}</b></h1></center></td>
                            <td><center><h1><b>{{$maquinaria_restante}}</b></h1></center></td>
                        </tr>
                        </tbody>
                    </table>
                @endif

            </div>
        </div>

    </div>
</div>

</body>

</html>

