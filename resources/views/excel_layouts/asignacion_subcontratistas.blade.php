<table>
    <thead>
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
    </tr>
    </thead>
    <tbody>
    @foreach($contrato_proyectado->cotizacionesContrato->filter(function ($value) { return $value->candidata; }) as $key => $cotizacion)
        @foreach($cotizacion->presupuestos->filter(function ($value) use ($contrato_proyectado){ return $value->no_cotizado == 0 && $contrato_proyectado->contratos()->find($value->id_concepto)->cantidad_pendiente > 0; }) as $index => $presupuesto)
            {{ $contrato = $contrato_proyectado->contratos()->find($presupuesto->id_concepto) }}

            <tr>
                <!-- Información general de la partida -->
                <td style="background-color: #ffffaa">{{ $index + 1 }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->id_concepto }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->descripcion }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->destinos()->first()->path }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->unidad }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->cantidad_original }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->cantidad_original }}</td>
                <td style="background-color: #ffffaa">{{ $contrato->cantidad_pendiente }}</td>

                <!-- Información de la cotización -->
                <td style="background-color: #ffffaa">{{ $cotizacion->id_transaccion }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacion->fecha }}</td>
                <td style="background-color: #ffffaa">{{ $cotizacion->empresa->razon_social }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->precio_unitario_antes_descuento }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->precio_total_antes_descuento }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->PorcentajeDescuento }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->precio_unitario_despues_descuento }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->precio_total_despues_descuento }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->moneda->nombre }}</td>
                <td style="background-color: #ffffaa">{{ $presupuesto->Observaciones }}</td>
                <td style="background-color: #86ff88"></td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>