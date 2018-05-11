<?php $totales = isset($contratoProyectados['totales']) ? $contratoProyectados['totales'] : 0 ?>
<table>
    <thead>
    <tr>
        {{-- Información de la Partida --}}
        @foreach($headerCotizaciones as $_headerCotizaciones)
            <th style="background-color: #C8C8C8">{{ $_headerCotizaciones }}</th>
        @endforeach
        {{-- Información del Proveedor --}}
        @for($i=0;$i<$totales;$i++)
            @foreach($headerPresupuestos as $_headerPresupuestos)
                <th style="background-color: #C8C8C8">{{ $_headerPresupuestos }}</th>
            @endforeach
        @endfor
        <th style="background-color: #C8C8C8" >Pendiente de Asignar</th>
    </tr>
    </thead>
    <tbody>
    <?php $index = 1; ?>
    @if($totales>0 && count($contratoProyectados['valores'])>0):
        @foreach($contratoProyectados['valores'] as $key => $contratoProyectado)
            <tr>
                <!-- Información general de la partida -->
                <td style="background-color: #ffffaa">{{ $index }}</td>
                <td style="background-color: #ffffaa">{{ $mcrypt->encrypt($contratoProyectado['contrato']->id_concepto) }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->descripcion }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->destinos()->first()->path }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->unidad }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->cantidad_original }}</td>
                <td style="background-color: #ffffaa">{{ $contratoProyectado['contrato']->cantidad_pendiente }}</td>
                <!-- Información de l cotización -->
            @for($i=0;$i<$totales;$i++)
                @if(isset($contratoProyectado['cotizacion'][$i]))
                    <?php $presupuesto = $contratoProyectado['presupuesto'][$i];?>
                    @if(count($presupuesto)>0)
                        <!-- Información de la cotización -->
                            <td style="background-color: #ffffaa">{{ $mcrypt->encrypt($contratoProyectado['cotizacion'][$i]->id_transaccion) }}</td>
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
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
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