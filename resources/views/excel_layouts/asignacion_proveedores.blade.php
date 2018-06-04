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
        <?php $primerValor = array_values($requisicion['valores'])[0]; ?>
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
        {{--Cantidades--}}
        <?php
        if(isset($req['partida']->item) && $req['partida']->item->transaccion->estatus_transaccion == 1)
        {
            if($req['partida']->cantidad_original !=0)
            {
                $cantidad_autorizada = $req['partida']->cantidad;
                $cantidad_solicitada = $req['partida']->cantidad_original;
            }
            else
            {
                $cantidad_autorizada = $req['partida']->cantidad;
                $cantidad_solicitada = $req['partida']->cantidad;
            }

        }
        else
        {
            $cantidad_autorizada = 0;
            $cantidad_solicitada = $req['partida']->cantidad;
        }

        ?>
        <tr>
            <!-- Información general de la partida -->
            <td style="background-color: #ffd966" class="laterales-left">{{ $index }}</td>
            <td style="background-color: #ffd966" class="border">{{  $req['partida']->idrqctoc_solicitudes_partidas }}</td>
            <td style="background-color: #ffd966" class="border">{{ (!empty($req['partida']->material->numero_parte) ?
            '['. $req['partida']->material->numero_parte .']' : '') . $req['partida']->material->descripcion }}</td>
            <td style="background-color: #ffd966" class="border">{{ (!empty($req['partida']->material->unidad) ?
            $req['partida']->material->unidad : '') }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ $cantidad_solicitada }}</td>
            <td style="background-color: #ffd966"
                class="laterales-right">{{ $cantidad_autorizada }}</td>

            <!-- Información de la cotización -->
            @foreach($req['presupuesto'] as $key => $cot)
                <?php
                $desde = (count($headerCotizaciones) * $key) + (count($headerRequisiciones));
                ?>

                {{--Precio Unitario--}}
                <td style="background-color: #9bc2e6;" class="{{$ultimalinealeft}} ">
                    {{ $cot->importe }}
                </td>

                {{--% Descuento--}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                    0
                </td>

                {{--Precio Total--}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                    ={{ \PHPExcel_Cell::stringFromColumnIndex($desde +1) }}{{ $haciaAbajo }}-({{ \PHPExcel_Cell::stringFromColumnIndex($desde +2) }}{{ $haciaAbajo }}*{{ \PHPExcel_Cell::stringFromColumnIndex($desde +1) }}{{ $haciaAbajo }}/100)
                </td>

                {{--Moneda - calculado en backend --}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} "></td>

                {{--Precio Total Moneda Conversión--}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} "></td>

                {{--Observaciones--}}
                <td style="background-color: #9bc2e6" class="{{$ultimalinea}} "></td>

                {{--material_sao--}}
                <td style="background-color: #fff; color: #fff">{{ $cot->idmaterial_sao }}</td>

                {{--idrqctoc_solicitudes_partidas--}}
                <td style="background-color: #fff; color: #fff"></td>

                {{--idrqctoc_solicitudes--}}
                <td style="background-color: #fff; color: #fff" >{{ $cot->idrqctoc_solicitudes }}</td>

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