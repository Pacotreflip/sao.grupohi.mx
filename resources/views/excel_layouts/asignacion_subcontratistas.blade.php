<?php $totales = isset($requisiciones['totales']) ? $requisiciones['totales'] : 0 ?>
<table>
    <thead>
    <tr>
        {{-- Información de la Partida --}}
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        <th style="background-color: #C8C8C8"></th>
        {{-- Información del Proveedor --}}
        @for($i=0;$i<$totales;$i++)
            <th style="background-color: #C8C8C8"></th>
            <th style="background-color: #C8C8C8"></th>
            <th style="background-color: #C8C8C8"></th>
            <th style="background-color: #C8C8C8"></th>
            <th style="background-color: #C8C8C8"></th>
            <th style="background-color: #C8C8C8"></th>
            <th style="background-color: #C8C8C8"></th>
            <td style="background-color: #C8C8C8"></td>
            <td style="background-color: #C8C8C8"></td>
            <td style="background-color: #C8C8C8"></td>
            <td style="background-color: #C8C8C8"></td>
        @endfor
    </tr>
    <tr>
        {{-- Información de la Partida --}}
        <th style="background-color: #C8C8C8">#</th>
        <th style="background-color: #C8C8C8">ID Partida</th>
        <th style="background-color: #C8C8C8">Descripción</th>
        <th style="background-color: #C8C8C8">Destino</th>
        <th style="background-color: #C8C8C8">Unidad</th>
        <th style="background-color: #C8C8C8">Cantidad Solicitada</th>
        <th style="background-color: #C8C8C8">Cantidad Autorizada</th>
        <th style="background-color: #C8C8C8">Cantidad Pendiente de Asignar</th>

        {{-- Información del Proveedor --}}
        @for($i=0;$i<$totales;$i++)
            <th style="background-color: #C8C8C8">ID Presupuesto</th>
            <th style="background-color: #C8C8C8">Fecha de Presupuesto</th>
            <th style="background-color: #C8C8C8">Nombre del Proveedor</th>
            <th style="background-color: #C8C8C8">Precio Unitario Antes Descto.</th>
            <th style="background-color: #C8C8C8">Precio Total Antes Descto.</th>
            <th style="background-color: #C8C8C8">% Descuento</th>
            <th style="background-color: #C8C8C8">Precio Unitario</th>
            <th style="background-color: #C8C8C8">Precio Total</th>
            <th style="background-color: #C8C8C8">Moneda</th>
            <th style="background-color: #C8C8C8">Observaciones</th>
            <th style="background-color: #C8C8C8">Cantidad Asignada</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    <?php $index = 1; ?>
    @if($totales>0):
        @foreach($contratoProyectados['valores'] as $key => $contratoProyectado)
            <tr>
                <!-- Información general de la partida -->
                <td style="background-color: #ffffaa">{{ $index }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->id_concepto }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->descripcion }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->destinos()->first()->path }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->unidad }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->cantidad_original }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->cantidad_original }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->cantidad_pendiente }}</td>
                <!-- Información de l cotización -->
            @for($i=0;$i<$totales;$i++)
                @if(isset($contratoProyectado['cotizacion'][$i]))
                    <?php $presupuesto = $contratoProyectado['presupuesto'][$i];?>
                    @if(count($presupuesto)>0)
                        <!-- Información de la cotización -->
                            <td style="background-color: #ffffaa">{{ $contratoProyectado['cotizacion'][$i]->id_transaccion }}</td>
                            <td style="background-color: #ffffaa">{{ $contratoProyectado['cotizacion'][$i]->fecha }}</td>
                            <td style="background-color: #ffffaa">{{ $contratoProyectado['cotizacion'][$i]->empresa->razon_social }}</td>
                            <td style="background-color: #ffffaa">{{ $presupuesto->precio_unitario_antes_descuento }}</td>
                            <td style="background-color: #ffffaa">{{ $presupuesto->precio_total_antes_descuento }}</td>
                            <td style="background-color: #ffffaa">{{ $presupuesto->PorcentajeDescuento }}</td>
                            <td style="background-color: #ffffaa">{{ $presupuesto->precio_unitario_despues_descuento }}</td>
                            <td style="background-color: #ffffaa">{{ $presupuesto->precio_total_despues_descuento }}</td>
                            <td style="background-color: #ffffaa">{{ ! $presupuesto->moneda ? : $presupuesto->moneda->nombre }}</td>
                            <td style="background-color: #ffffaa">{{ $presupuesto->Observaciones }}</td>
                            <td style="background-color: #86ff88"></td>
                        @else
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #ffffaa"></td>
                            <td style="background-color: #86ff88"></td>
                        @endif
                    @else
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #ffffaa"></td>
                        <td style="background-color: #86ff88"></td>
                    @endif
                @endfor
            </tr>
            <?php $index++; ?>
        @endforeach
    @endif
    </tbody>
</table>