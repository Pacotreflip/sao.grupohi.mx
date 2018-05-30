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
            <?php $primerValor = array_values($contratoProyectados['valores'])[0]; ?>
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
            <td style="background-color: #ffd966" class="border">{{  $contratoProyectado['partida']->agrupados }}</td>
            <td style="background-color: #ffd966" class="border">{{  $contratoProyectado['partida']->hijos }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ (!empty($contratoProyectado['partida']->clave) ?
                $contratoProyectado['partida']->clave : '') }}</td>
            <td style="background-color: #ffd966" class="border">{{ (!empty($contratoProyectado['partida']->descripcion_span) ?
            $contratoProyectado['partida']->descripcion_span : '') }}</td>
            <td style="background-color: #ffd966" class="border">{{ (!empty($contratoProyectado['partida']->unidad) ?
            $contratoProyectado['partida']->unidad : '') }}</td>
            <td style="background-color: #ffd966"
                class="border">{{ $contratoProyectado['partida']->cantidad_original }}</td>
            <td style="background-color: #ffd966"
                class="laterales-right">{{ $contratoProyectado['partida']->cantidad_presupuestada }}</td>

        <!-- Información de la cotización -->
        @foreach($contratoProyectado['presupuesto'] as $key => $presupuesto)

            <?php
            $desde = (count($headerPresupuestos) * $key) + (count($headerCotizaciones));
            ?>

            {{--Precio Unitario Antes Descto--}}
            <td style="background-color: #fff;" class="{{$ultimalinealeft}} ">
                {{ $presupuesto->monto }}
            </td>

            {{--Precio Total Antes Descto--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                =G{{ $haciaAbajo }}*{{
                \PHPExcel_Cell::stringFromColumnIndex($desde) }}{{
                $haciaAbajo }}
            </td>

            {{--% Descuento--}}
            <td style="background-color: #fff" class="{{$ultimalinea}} ">
                0
            </td>

            {{--Precio Unitario--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                ={{ \PHPExcel_Cell::stringFromColumnIndex($desde) }}{{ $haciaAbajo }}-({{ \PHPExcel_Cell::stringFromColumnIndex($desde) }}{{ $haciaAbajo }}*{{ \PHPExcel_Cell::stringFromColumnIndex($desde +2) }}{{ $haciaAbajo }}/100)
            </td>

            {{--Precio Total--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">
                ={{ \PHPExcel_Cell::stringFromColumnIndex($desde +1) }}{{ $haciaAbajo }}-({{ \PHPExcel_Cell::stringFromColumnIndex($desde +2) }}{{ $haciaAbajo }}*{{ \PHPExcel_Cell::stringFromColumnIndex($desde +1) }}{{ $haciaAbajo }}/100)
            </td>

            {{--Moneda - calculado en backend --}}
            <td style="background-color: #fff" class="{{$ultimalinea}} "></td>

            {{--Precio Unitario Moneda Conversión - calculado en backend--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} ">

            </td>

            {{--Precio Total Moneda Conversión--}}
            <td style="background-color: #9bc2e6" class="{{$ultimalinea}} "></td>

            {{--Observaciones--}}
            <td style="background-color: #fff" class="{{$ultimalinea}} "></td>

            {{--id_moneda--}}
            <td style="background-color: #fff; color: #fff"></td>

            {{--precio_total_mxp--}}
            <td style="background-color: #fff; color: #fff"></td>

            {{--cotizado_img--}}
            <td style="background-color: #fff; color: #fff" >{{ $contratoProyectado['partida']->en_asig }}</td>

            {{--Separador--}}
            <td style="background-color: #fff; color: #fff"></td>

        @endforeach
        </tr>
        <?php $index++; $haciaAbajo++; ?>

    @endforeach
    @endif
    </tbody>
</table>