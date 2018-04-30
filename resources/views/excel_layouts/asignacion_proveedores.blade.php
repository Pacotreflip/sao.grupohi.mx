<table>
    <thead>
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

        {{-- Información del Proveedor --}}
        <th style="background-color: #C8C8C8">ID Cotización</th>
        <th style="background-color: #C8C8C8">Fecha de Cotización</th>
        <th style="background-color: #C8C8C8">Nombre del Proveedor</th>
        <th style="background-color: #C8C8C8">Sucursal</th>
        <th style="background-color: #C8C8C8">Dirección</th>
        <th style="background-color: #C8C8C8">Precio Unitario</th>
        <th style="background-color: #C8C8C8">% Descuento</th>
        <th style="background-color: #C8C8C8">Precio Total</th>
        <th style="background-color: #C8C8C8">Moneda</th>
        <th style="background-color: #C8C8C8">Observaciones</th>
        <th style="background-color: #C8C8C8">Cantidad Asignada</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requisicion->rqctocSolicitud->rqctocCotizaciones->filter(function ($value) { return $value->candidata; }) as $key => $cotizacion)
        @foreach($cotizacion->rqctocCotizacionPartidas->filter(function ($value) { return $value->precio_unitario != 0; }) as $index => $cotizacionPartida)
            {{ $partida = $requisicion->rqctocSolicitud->rqctocSolicitudPartidas()->find($cotizacionPartida->idrqctoc_solicitudes_partidas) }}
            <tr>
                <!-- Información general de la partida -->
                <td style="background-color: #ffffaa">{{ $index + 1 }}</td>
                <td style="background-color: #ffffaa">{{ $partida->idrqctoc_solicitudes_partidas }}</td>
                <td style="background-color: #ffffaa">{{ $partida->descripcion }}</td>
                <td style="background-color: #ffffaa">{{ $partida->unidad_sao }}</td>
                <td style="background-color: #ffffaa">{{ $partida->cantidad_solicitada }}</td>
                <td style="background-color: #ffffaa">{{ $partida->cantidad_autorizada }}</td>
                <td style="background-color: #ffffaa">{{ $partida->cantidad - $partida->cantidad_pendiente }}</td>
                <td style="background-color: #ffffaa">{{ $partida->cantidad_pendiente }}</td>

                <!-- Información de l cotización -->
                <td style="background-color: #ffffaa">{{ $cotizacion->idrqctoc_cotizaciones }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacion->fecha_cotizacion }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacion->empresa->razon_social }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacion->sucursal->descripcion }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacion->sucursal->direccion }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacionPartida->precio_unitario }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacionPartida->descuento }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacionPartida->precio_total }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacionPartida->ctgMoneda->moneda }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacionPartida->observaciones }}</td>
                <td style="background-color: #86ff88"></td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>