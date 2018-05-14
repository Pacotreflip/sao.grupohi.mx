<?php $totales = isset($contratoProyectados['totales']) ? $contratoProyectados['totales'] : 0 ?>
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
    <tr>
        {{-- Información de la Partida --}}
        @foreach($headerCotizaciones as $_headerCotizaciones)
            <th style="background-color: #C8C8C8" class="border">{{ $_headerCotizaciones }}</th>
        @endforeach
        {{-- Información del Proveedor --}}
        @for($i=0;$i<$totales;$i++)
            @foreach($headerPresupuestos as $_headerPresupuestos)
                <th style="background-color: #C8C8C8" class="border">{{ $_headerPresupuestos }}</th>
            @endforeach
        @endfor
        <th></th>
        <th>Pendiente de Asignar</th>
    </tr>
    </thead>
    <tbody>
    <?php $index = 1; ?>
    @if($totales>0 && count($contratoProyectados['valores'])>0):
    @foreach($contratoProyectados['valores'] as $key => $contratoProyectado)
        <?php $ultimalinea = ($index==count($contratoProyectados['valores']))? 'button-border':'border'; ?>
        <?php $ultimalinealeft = ($index==count($contratoProyectados['valores']))? 'laterales-left-sin':'laterales-left'; ?>
        <?php $ultimalinearinght = ($index==count($contratoProyectados['valores']))? 'laterales-right-sin':'laterales-right'; ?>
        <tr>
            <!-- Información general de la partida -->
            <td style="background-color: #ffd966" class="laterales-left">{{ $index }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ $mcrypt->encrypt($contratoProyectado['contrato']->id_concepto) }}</td>
            <td style="background-color: #ffd966" class="border">{{ $contratoProyectado['contrato']->descripcion }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ $contratoProyectado['contrato']->destinos()->first()->path }}</td>
            <td style="background-color: #ffd966" class="border">{{ $contratoProyectado['contrato']->unidad }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ $contratoProyectado['contrato']->cantidad_original }}</td>
            <td style="background-color: #ffd966"
                class="laterales-right">{{ $contratoProyectado['contrato']->cantidad_pendiente }}</td>
            <!-- Información de l cotización -->
        @for($i=0;$i<$totales;$i++)
            @if(isset($contratoProyectado['cotizacion'][$i]))
                <?php $presupuesto = $contratoProyectado['presupuesto'][$i];?>
                @if(count($presupuesto)>0)
                    <!-- Información de la cotización -->
                        <td style="background-color: #9bc2e6;"
                            class="{{$ultimalinealeft}} ">{{ $mcrypt->encrypt($contratoProyectado['cotizacion'][$i]->id_transaccion) }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $contratoProyectado['cotizacion'][$i]->fecha }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $contratoProyectado['cotizacion'][$i]->empresa->razon_social }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $presupuesto->precio_unitario_antes_descuento }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $presupuesto->precio_total_antes_descuento }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $presupuesto->PorcentajeDescuento }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $presupuesto->precio_unitario_despues_descuento }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $presupuesto->precio_total_despues_descuento }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ ! $presupuesto->moneda ? : $presupuesto->moneda->nombre }}</td>
                        <td style="background-color: #9bc2e6"
                            class="{{$ultimalinea}} ">{{ $presupuesto->Observaciones }}</td>
                        <td style="background-color: #a9d08e;" class="{{$ultimalinearinght}}"></td>
                    @else
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
                        <td class="notSelect"></td>
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