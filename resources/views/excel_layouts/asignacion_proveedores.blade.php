<?php $totales = isset($requisiciones['totales']) ? $requisiciones['totales'] : 0 ?>
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
<table border="1" style="border: 1px solid #000000;">
    <thead>
    <tr>
        {{-- Información de la Partida --}}
        @foreach($headerPartidas as $_headerPartidas)
            <th style="background-color: #C8C8C8" class="border">{{ $_headerPartidas }}</th>
        @endforeach
        {{-- Información del Proveedor --}}
        @for($i=0;$i<$totales;$i++)
            @foreach($headerCotizacion as $_headerCotizacion)
                <th style="background-color: #C8C8C8" class="border">{{ $_headerCotizacion }}</th>
            @endforeach
        @endfor
        <th></th>
        <th style="background-color: #C8C8C8">Pendiente de Asignar</th>
    </tr>
    </thead>
    <tbody>
    <?php $index = 1; ?>
    @if($totales>0 && count($requisiciones['valores'])>0):
    @foreach($requisiciones['valores'] as $key => $requisicion)
        <?php $ultimalinea = ($index==count($requisiciones['valores']))? 'button-border':'border'; ?>
        <?php $ultimalinealeft = ($index==count($requisiciones['valores']))? 'laterales-left-sin':'laterales-left'; ?>
        <?php $ultimalinearinght = ($index==count($requisiciones['valores']))? 'laterales-right-sin':'laterales-right'; ?>
        <tr>
            <!-- Información general de la partida -->
            <td style="background-color: #ffd966" class="border ">{{ $index }}</td>
            <td style="background-color: #ffd966"
                class="border ">{{ $mcrypt->encrypt($requisicion['partida']->idrqctoc_solicitudes_partidas) }}</td>
            <td style="background-color: #ffd966" class="border ">{{ $requisicion['partida']->descripcion }}</td>
            <td style="background-color: #ffd966" class="border ">{{ $requisicion['partida']->unidad_sao }}</td>
            <td style="background-color: #ffd966"
                class="border ">{{ $requisicion['partida']->cantidad_solicitada }}</td>
            <td style="background-color: #ffd966"
                class="border ">{{ $requisicion['partida']->cantidad - $requisicion['partida']->cantidad_pendiente }}</td>
            <td style="background-color: #ffd966" class="border ">{{ $requisicion['partida']->cantidad_pendiente }}</td>
            <!-- Información de l cotización -->
            @for($i=0;$i<$totales;$i++)
                @if(isset($requisicion['cotizacionPartida'][$i]))
                    <?php $cotizacionPartida = $requisicion['cotizacionPartida'][$i];?>
                    @if(count($cotizacionPartida)>0)
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinealeft}}">{{ $mcrypt->encrypt($requisicion['cotizacion'][$i]->idrqctoc_cotizaciones)  }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinealeft}}">{{ $requisicion['cotizacion'][$i]->empresa->razon_social  }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}}">{{ $cotizacionPartida->precio_unitario }}</td>
                        <td style="background-color: #9bc2e6" class="{{$ultimalinea}}">{{ $cotizacionPartida->descuento }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}}">{{ $cotizacionPartida->precio_total }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}}">{{ (isset($cotizacionPartida->ctgMoneda))?$cotizacionPartida->ctgMoneda->moneda:'' }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}}">{{ $cotizacionPartida->observaciones }}</td>
                        <td style="background-color: #a9d08e" class="{{$ultimalinearinght}}"></td>
                    @else
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                    @endif
                @else
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                    <td class="notSelect"></td>
                @endif
            @endfor
        </tr>
        <?php $index++; ?>
    @endforeach
    @endif
    </tbody>
</table>