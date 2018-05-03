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
        <th style="background-color: #C8C8C8">Error</th>
    </tr>
    </thead>
    <tbody>
    @if(count($requisicion)>0)
        @foreach($requisicion as $index => $cotizacion)
                <tr>
                    <!-- Información general de la partida -->
                    <td style="background-color: #ffffaa">{{ $cotizacion[0] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['id_partida'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['descripcion'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['unidad'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['cantidad_solicitada'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['cantidad_autorizada'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['cantidad_asignada_previamente'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['cantidad_pendiente_de_asignar'] }}</td>

                    <!-- Información de l cotización -->
                    <td style="background-color: #ffffaa">{{ $cotizacion['id_cotizacion'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['fecha_de_cotizacion'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['nombre_del_proveedor'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['sucursal'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['direccion'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['precio_unitario'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['descuento'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['precio_total'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['moneda'] }}</td>
                    <td style="background-color: #ffffaa">{{ $cotizacion['observaciones'] }}</td>
                    <td style="background-color: #FFF823">{{ $cotizacion['cantidad_asignada'] }}</td>
                    @if(isset($cotizacion['error']))
                        @if($cotizacion['error']=='')
                            <td style="background-color: #00E700">{{ $cotizacion['error'] }}</td>
                        @else
                            <td style="background-color: #ff0000;color: #FFFFFF;">{{ $cotizacion['error'] }}</td>
                        @endif
                    @else
                        <td style="background-color: #ff0000">No se guardo ningun valor</td>
                    @endif
                </tr>
        @endforeach
    @endif
            <tr>
                <td style="background-color: #ffffaa" colspan="3">Detalles de errores del documentos</td>
                @if($mensaje === '')
                    <td style="background-color: #00E700 "></td>
                @else
                    <td style="background-color: #ff0000 ;color: #FFFFFF" colspan="17">{{ $mensaje }}</td>
                @endif
            </tr>
    </tbody>
</table>