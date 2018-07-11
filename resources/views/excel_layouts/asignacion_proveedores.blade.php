<?php $totales = isset($requisicion['totales']) ? $requisicion['totales'] : 0 ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    .border {
        border: 1px solid #000000;
    }

    .button-border {
        border-right: 1px solid #000000;
        border-left: 1px solid #000000;
        border-top: 1px solid #000000;
    }

    .laterales-right {
        border-left: 1px solid #000000;
        border-top: 1px solid #000000;
        border-bottom: 1px solid #000000;
    }

    .laterales-left {
        border-right: 1px solid #000000;
        border-top: 1px solid #000000;
        border-bottom: 1px solid #000000;
    }

    .laterales-right-sin {
        border-left: 1px solid #000000;
        border-top: 1px solid #000000;
    }

    .laterales-left-sin {
        border-right: 1px solid #000000;
        border-top: 1px solid #000000;
    }
    .notSelect{
        background-color: #C9C9C9;
    }
</style>
<table>
    <thead>
    {{--Identificador--}}
    <tr>
        <td colspan="{{ count($headerRequisiciones) }}">
            <?php $empresas_ids = $cotizacions_ids = []; ?>
            @if($totales>0 && count($requisicion['valores'])>0):

            @foreach($requisicion['valores'] as $key => $req)
                @foreach($req['presupuesto'] as $key => $cot)
                    <?php
                    $cotizacions_ids[] = $cot->idtransaccion_sao;
                    $empresas_ids[] = $cot->empresa->id_empresa;
                    ?>
                @endforeach
            @endforeach
            <?php
            $empresas_ids = implode(',', array_unique($empresas_ids));
            $cotizacions_ids = implode(',', array_unique($cotizacions_ids));
            ?>
            {{ $mcrypt->encrypt($cotizacions_ids .'|'.$empresas_ids .'|'. implode(',', (is_array
                ($info['agrupadores']) ? $info['agrupadores'] : [])) .'|'.
            $info['solo_pendientes']) }}
            @endif
        </td>
        <?php $primerValor = !empty($requisicion['valores']) ? array_values($requisicion['valores'])[0] :
            ['presupuesto' => []]; ?>
        @foreach($primerValor['presupuesto'] as $key => $cotizacion)
            <td colspan="{{ count($headerCotizaciones) }}">
                {{ $cotizacion->empresa->razon_social }}
            </td>
        @endforeach
    </tr>
    <tr>
        {{-- Información de la Partida --}}
        @foreach($headerRequisiciones as $_headerRequisiciones)
            <th style="background-color: #C8C8C8" class="border">{{ $_headerRequisiciones }}</th>
        @endforeach
        {{-- Información del Proveedor --}}
        <?php $ocultar = ["material_sao",
            "idrqctoc_solicitudes_partidas",
            "idrqctoc_solicitudes",
            "idrqctoc_cotizaciones_partidas",
            "idrqctoc_cotizaciones",
            "idmoneda",
            "separador"]; ?>
        @for($i=0;$i<$totales;$i++)
            @foreach($headerCotizaciones as $k => $_headerCotizaciones)
                <th style="{{ in_array($k, $ocultar) ? 'background-color: #fff; color: #fff' : 'background-color: #C8C8C8' }}" class="border">{{
                $_headerCotizaciones
                }}</th>
            @endforeach
        @endfor
    </tr>
    </thead>
    <tbody>

    <?php
    $index = 1;
    $haciaAbajo = 3;
    ?>
    @if($totales>0 && count($requisicion['valores'])>0):
    @foreach($requisicion['valores'] as $key => $req)
        <?php $ultimalinea = ($index==count($requisicion['valores']))? 'button-border':'border'; ?>
        <?php $ultimalinealeft = ($index==count($requisicion['valores']))? 'laterales-left-sin':'laterales-left'; ?>
        <?php $ultimalinearinght = ($index==count($requisicion['valores']))? 'laterales-right-sin':'laterales-right'; ?>

        <tr>
            <!-- Información general de la partida -->
            <td style="background-color: #ffd966" class="laterales-left">{{ $index }}</td>
            <td style="background-color: #ffd966" class="border">{{  $mcrypt->encrypt($req['partida']->idrqctoc_solicitudes_partidas) }}</td>
            <td style="background-color: #ffd966" class="border">{{ (!empty($req['partida']->material) ?
            '['. $req['partida']->material->numero_parte .']' : '') . (!empty($req['partida']->material) ?
            $req['partida']->material->descripcion : '')
            }}</td>
            <td style="background-color: #ffd966" class="border">{{ (!empty($req['partida']->material->unidad) ?
            $req['partida']->material->unidad : '') }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ $req['partida']->cantidad_solicitada }}</td>
            <td style="background-color: #ffd966"
                class="laterales-right">{{ $req['partida']->cantidad_autorizada }}</td>

            <!-- Información de la cotización -->
            @foreach($req['presupuesto'] as $key => $cot)
                <?php

                $cot_partida = $cot->rqctocCotizacionPartidas()->with('material')->where('idrqctoc_solicitudes_partidas', '=',
                    $req['partida']->idrqctoc_solicitudes_partidas)->first();
                $desde = (count($headerCotizaciones) * $key) + (count($headerRequisiciones));

                ?>

                {{--Precio Unitario--}}
                <td style="background-color: #fff;" class="{{$ultimalinealeft}} ">
                    {{ $cot_partida ? $cot_partida->precio_unitario : '' }}
                </td>

                {{--% Descuento--}}
                <td style="background-color: #fff" class="{{$ultimalinea}} ">
                    {{ $cot_partida ? $cot_partida->porcentaje_descuento : '0' }}
                </td>

                {{--Precio Total--}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                </td>

                {{--Moneda--}}
                <td style="background-color: #fff" class="{{$ultimalinea}} "><?php
                            switch ((int) $cot_partida->idmoneda)
                            {
                                case 2:
                                    echo "EURO";
                                    break;
                                case 1:
                                    echo "DOLAR USD";
                                    break;
                                case 3:
                                    echo "PESO MXP";
                                    break;
                            } ?></td>

                {{--Precio Total Moneda Conversión--}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} "></td>

                {{--Observaciones--}}
                <td style="background-color: #fff" class="{{$ultimalinea}} "></td>

                {{--material_sao--}}
                <td style="background-color: #fff; color: #fff">{{ $mcrypt->encrypt((!empty($req['partida']->material) ?
                $req['partida']->material->id_material : '0')) }}</td>

                {{--idrqctoc_solicitudes_partidas--}}
                <td style="background-color: #fff; color: #fff"></td>

                {{--idrqctoc_solicitudes--}}
                <td style="background-color: #fff; color: #fff" >{{ $mcrypt->encrypt($cot->idrqctoc_solicitudes) }}</td>

                {{--idmoneda--}}
                <td style="background-color: #fff; color: #fff" >{{ $cot->idmoneda }}</td>

                {{--Separador--}}
                <td style="background-color: #fff; color: #fff"></td>

            @endforeach
        </tr>
        <?php $index++; $haciaAbajo++; ?>

    @endforeach
    @endif
    </tbody>
</table>