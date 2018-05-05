<?php $totales = $requisiciones['totales'] ?>
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
        @endfor
    </tr>
    <tr>
        {{-- Información de la Partida --}}
        <th style="background-color: #C8C8C8">#</th>
        <th style="background-color: #C8C8C8">ID Partida</th>
        <th style="background-color: #C8C8C8">Descripción</th>
        <th style="background-color: #C8C8C8">Unidad</th>
        <th style="background-color: #C8C8C8">Cantidad Solicitada</th>
        <th style="background-color: #C8C8C8">Cantidad Autorizada</th>
        <th style="background-color: #C8C8C8">Cantidad Asignada Previamente</th>
        <th style="background-color: #C8C8C8">Cantidad Pendiente de Asignar</th>

        @for($i=0;$i<$totales;$i++)
            <th style="background-color: #C8C8C8">ID Cotización</th>
            <th style="background-color: #C8C8C8">Precio Unitario</th>
            <th style="background-color: #C8C8C8">% Descuento</th>
            <th style="background-color: #C8C8C8">Precio Total</th>
            <th style="background-color: #C8C8C8">Moneda</th>
            <th style="background-color: #C8C8C8">Observaciones</th>
            <th style="background-color: #C8C8C8">Cantidad Asignada</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    <?php $index = 1; ?>
    @foreach($requisiciones['valores'] as $key => $requisicion)
            <tr>
                    <!-- Información general de la partida -->
                    <td style="background-color: #ffffaa">{{ $index }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->idrqctoc_solicitudes_partidas }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->descripcion }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->unidad_sao }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->cantidad_solicitada }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->cantidad_autorizada }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->cantidad - $requisicion['partida']->cantidad_pendiente }}</td>
                    <td style="background-color: #ffffaa">{{ $requisicion['partida']->cantidad_pendiente }}</td>
                    <!-- Información de l cotización -->
                    @for($i=0;$i<$totales;$i++)
                        @if(isset($requisicion['cotizacionPartida'][$i]))
                        <?php $cotizacionPartida = $requisicion['cotizacionPartida'][$i];?>
                            @if(count($cotizacionPartida)>0)
                                <td style="background-color: #ffffaa">{{ $requisicion['cotizacion'][$i]->idrqctoc_cotizaciones  }}</td>
                                <td style="background-color: #ffffaa">{{ $cotizacionPartida->precio_unitario }}</td>
                                <td style="background-color: #ffffaa">{{ $cotizacionPartida->descuento }}</td>
                                <td style="background-color: #ffffaa">{{ $cotizacionPartida->precio_total }}</td>
                                <td style="background-color: #ffffaa">{{ $cotizacionPartida->ctgMoneda->moneda }}</td>
                                <td style="background-color: #ffffaa">{{ $cotizacionPartida->observaciones }}</td>
                                <td style="background-color: #86ff88"></td>
                            @else
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
                            <td style="background-color: #86ff88"></td>
                        @endif
                    @endfor
            </tr>
            <?php $index++; ?>
    @endforeach
    </tbody>
</table>