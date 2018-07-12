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
    {{--Identificador--}}
    <tr>
        <td colspan="{{ count($headerCotizaciones) }}">
            <?php $empresas_ids = $presupuestos_ids = []; ?>
            @if($totales>0 && count($contratoProyectados['valores'])>0):
                @foreach($contratoProyectados['valores'] as $key => $contratoProyectado)
                    @foreach($contratoProyectado['presupuesto'] as $key => $presupuesto)
                        <?php
                        $empresas_ids[] = $presupuesto->id_empresa;
                        $presupuestos_ids[] = $presupuesto->id_transaccion;
                        ?>

                    @endforeach
                @endforeach
                <?php
                $empresas_ids = implode(',', array_unique($empresas_ids));
                $presupuestos_ids = implode(',', array_unique($presupuestos_ids));
                ?>
                {{ $mcrypt->encrypt($presupuestos_ids .'|'.$empresas_ids .'|'. implode(',', (is_array
                ($info['agrupadores']) ? $info['agrupadores'] : [])) .'|'.
                $info['solo_pendientes']) }}
            @endif
        </td>
            <?php $primerValor = !empty($contratoProyectados['valores']) ? array_values
        ($contratoProyectados['valores'])[0] : ['presupuesto' => []]; ?>
                @foreach($primerValor['presupuesto'] as $key => $presupuesto)
                        <td colspan="{{ count($headerPresupuestos) }}">
                        {{ $presupuesto->empresa->razon_social }}
                        </td>
                @endforeach
    </tr>
    <tr>
        {{-- Información de la Partida --}}
        @foreach($headerCotizaciones as $_headerCotizaciones)
            <th style="background-color: #C8C8C8" class="border">{{ $_headerCotizaciones }}</th>
        @endforeach
        {{-- Información del Proveedor --}}
        <?php $ocultar = ["cotizado_img", "separador", "id_moneda", "precio_total_mxp"]; ?>
        @for($i=0;$i<$totales;$i++)
            @foreach($headerPresupuestos as $k => $_headerPresupuestos)
                <th style="{{ in_array($k, $ocultar) ? 'background-color: #fff; color: #fff' : 'background-color:
                #C8C8C8' }}" class="border">{{
                $_headerPresupuestos
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
    @if($totales>0 && count($contratoProyectados['valores'])>0):
    @foreach($contratoProyectados['valores'] as $key => $contratoProyectado)
        <?php $ultimalinea = ($index==count($contratoProyectados['valores']))? 'button-border':'border'; ?>
        <?php $ultimalinealeft = ($index==count($contratoProyectados['valores']))? 'laterales-left-sin':'laterales-left'; ?>
        <?php $ultimalinearinght = ($index==count($contratoProyectados['valores']))? 'laterales-right-sin':'laterales-right'; ?>
        <tr>
            <!-- Información general de la partida -->
            <td style="background-color: #ffd966" class="laterales-left">{{ $index }}</td>

            {{--IDs--}}
            <td style="background-color: #ffd966" class="border">{{  $mcrypt->encrypt($contratoProyectado['partida']->agrupados) }}</td>

            {{--Hijos--}}
            <td style="background-color: #ffd966" class="border">{{  $contratoProyectado['partida']->hijos }}</td>

            {{--Clave--}}
            <td style="background-color: #ffd966"
                class="border">{{ (!empty($contratoProyectado['partida']->clave) ?
                $contratoProyectado['partida']->clave : '') }}</td>

            {{--Descripción--}}
            <td style="background-color: #ffd966" class="border">{{ (!empty($contratoProyectado['partida']->descripcion_span) ?
            $contratoProyectado['partida']->descripcion_span : '') }}</td>

            {{--Unidad--}}
            <td style="background-color: #ffd966" class="border">{{ (!empty($contratoProyectado['partida']->unidad) ?
            $contratoProyectado['partida']->unidad : '') }}</td>

            {{--Cantidad Autorizada--}}
            <td style="background-color: #ffd966"
                class="border">{{ $contratoProyectado['partida']->cantidad }}</td>

            {{--Cantidad Solicitada--}}
            <td style="background-color: #ffd966"
                class="laterales-right">{{ $contratoProyectado['partida']->cantidad_presupuestada }}</td>

        <!-- Información de la cotización -->
        @foreach($contratoProyectado['presupuesto'] as $key => $presupuesto)
            <?php
                $desde = (count($headerPresupuestos) * $key) + (count($headerCotizaciones));
                $presupuesto_partida = $presupuesto->presupuestos()->where('id_concepto', '=', $contratoProyectado['partida']->id_concepto)->first();

            ?>

            {{--Precio Unitario Antes Descto--}}
            <td style="background-color: #fff;" class="{{$ultimalinealeft}} ">{{ $presupuesto_partida->Precio_Unitario_Antes_Descuento }}</td>

            {{--Precio Total Antes Descto--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                =G{{ $haciaAbajo }}*{{
                \PHPExcel_Cell::stringFromColumnIndex($desde) }}{{
                $haciaAbajo }}
            </td>

            {{--% Descuento--}}
            <td style="background-color: #fff" class="{{$ultimalinea}} ">{{ $presupuesto_partida->PorcentajeDescuento }}</td>

            {{--Precio Unitario--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                ={{ \PHPExcel_Cell::stringFromColumnIndex($desde) }}{{ $haciaAbajo }}-({{ \PHPExcel_Cell::stringFromColumnIndex($desde) }}{{ $haciaAbajo }}*{{ \PHPExcel_Cell::stringFromColumnIndex($desde +2) }}{{ $haciaAbajo }}/100)
            </td>

            {{--Precio Total--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                ={{ \PHPExcel_Cell::stringFromColumnIndex($desde +1) }}{{ $haciaAbajo }}-({{ \PHPExcel_Cell::stringFromColumnIndex($desde +2) }}{{ $haciaAbajo }}*{{ \PHPExcel_Cell::stringFromColumnIndex($desde +1) }}{{ $haciaAbajo }}/100)
            </td>

            {{--Moneda - calculado en backend --}}
            <td style="background-color: #fff" class="{{$ultimalinea}} "><?php
                if (isset($presupuesto_partida->IdMoneda))
                    switch ((int) $presupuesto_partida->IdMoneda)
                    {
                        case 3:
                            echo "EURO";
                            break;
                        case 2:
                            echo "DOLAR USD";
                            break;
                        case 1:
                            echo "PESO MXP";
                            break;
                    }

                else
                    echo "PESO MXP";
                ?></td>

            {{--Precio Unitario Moneda Conversión - calculado en backend--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">

            </td>

            {{--Precio Total Moneda Conversión--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} "></td>

            {{--Observaciones--}}
            <td style="background-color: #fff" class="{{$ultimalinea}} ">{{ $presupuesto_partida->Observaciones }}</td>

            {{--id_moneda--}}
            <td style="background-color: #fff; color: #fff"></td>

            {{--precio_total_mxp--}}
            <td style="background-color: #fff; color: #fff"></td>

            {{--cotizado_img--}}
            <td style="background-color: #fff; color: #fff" ></td>

            {{--Separador--}}
            <td style="background-color: #fff; color: #fff"></td>

        @endforeach
        </tr>
        <?php $index++; $haciaAbajo++; ?>

    @endforeach
    @endif
    </tbody>
</table>