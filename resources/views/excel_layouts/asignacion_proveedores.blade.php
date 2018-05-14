<?php $totales = isset($requisiciones['totales']) ? $requisiciones['totales'] : 0 ?>
<table border="1" style="border: 1px solid #000000;" >
    <thead>
    <tr>
        {{-- Información de la Partida --}}
        @foreach($headerPartidas as $_headerPartidas)
            <th style="background-color: #C8C8C8">{{ $_headerPartidas }}</th>
        @endforeach
        {{-- Información del Proveedor --}}
        @for($i=0;$i<$totales;$i++)
            @foreach($headerCotizacion as $_headerCotizacion)
                <th style="background-color: #C8C8C8">{{ $_headerCotizacion }}</th>
            @endforeach
        @endfor
        <th style="background-color: #C8C8C8" >Pendiente de Asignar</th>
    </tr>
    </thead>
    <tbody>
    <?php $index = 1; ?>
    @if($totales>0 && count($requisiciones['valores'])>0):
        @foreach($requisiciones['valores'] as $key => $requisicion)
            <tr>
                <!-- Información general de la partida -->
                <td style="background-color: #ffd966">{{ $index }}</td>
                <td style="background-color: #ffd966">{{ $mcrypt->encrypt($requisicion['partida']->idrqctoc_solicitudes_partidas) }}</td>
                <td style="background-color: #ffd966">{{ $requisicion['partida']->descripcion }}</td>
                <td style="background-color: #ffd966">{{ $requisicion['partida']->unidad_sao }}</td>
                <td style="background-color: #ffd966">{{ $requisicion['partida']->cantidad_solicitada }}</td>
                <td style="background-color: #ffd966">{{ $requisicion['partida']->cantidad - $requisicion['partida']->cantidad_pendiente }}</td>
                <td style="background-color: #ffd966">{{ $requisicion['partida']->cantidad_pendiente }}</td>
                <!-- Información de l cotización -->
                @for($i=0;$i<$totales;$i++)
                    @if(isset($requisicion['cotizacionPartida'][$i]))
                        <?php $cotizacionPartida = $requisicion['cotizacionPartida'][$i];?>
                        @if(count($cotizacionPartida)>0)
                            <td style="background-color: #9bc2e6">{{ $mcrypt->encrypt($requisicion['cotizacion'][$i]->idrqctoc_cotizaciones)  }}</td>
                            <td style="background-color: #9bc2e6">{{ $cotizacionPartida->precio_unitario }}</td>
                            <td style="background-color: #9bc2e6">{{ $cotizacionPartida->descuento }}</td>
                            <td style="background-color: #9bc2e6">{{ $cotizacionPartida->precio_total }}</td>
                            <td style="background-color: #9bc2e6">{{ (isset($cotizacionPartida->ctgMoneda))?$cotizacionPartida->ctgMoneda->moneda:'' }}</td>
                            <td style="background-color: #9bc2e6">{{ $cotizacionPartida->observaciones }}</td>
                            <td style="background-color: #a9d08e"></td>
                        @else
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                        @endif
                    @else
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                    @endif
                @endfor
            </tr>
            <?php $index++; ?>
        @endforeach
    @endif
    </tbody>
</table>