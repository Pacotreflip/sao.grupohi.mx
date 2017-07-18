Estimado Colaborador: {{$usuario}} {{'\n\n\n\n'}}
Se le informa que las siguientes pólizas han sido registradas y tienen errores que deben corregirse  para que puedan ser enviadas al Contpaq
@foreach($polizas as $index=>$poliza)
    Numero de pre-póliza: {{$poliza->id_int_poliza}}    {{'\n'}}
    Tipo de Póliza: {{$poliza->tipo_poliza}}   {{'\n'}}
    Concepto: {{$poliza->concepto}}    {{'\n'}}
    Total: {{$poliza->total}}   {{'\n'}}
    Cuadre: {{$poliza->cuadre}}    {{'\n'}}
    Estatus:
    @if($poliza->estatus == \Ghi\Domain\Core\Models\Contabilidad\Poliza::REGISTRADA) Registrada @endif
    @if($poliza->estatus == \Ghi\Domain\Core\Models\Contabilidad\Poliza::LANZADA) Lanzada @endif
    @if($poliza->estatus ==\Ghi\Domain\Core\Models\Contabilidad\Poliza::NO_LANZADA) No lanzada @endif
    @if($poliza->estatus == \Ghi\Domain\Core\Models\Contabilidad\Poliza::CON_ERRORES)Con errores @endif
    {{'\n'}}
    Póliza ContPaq: {{$poliza->poliza_contpaq}}    {{'\n\n'}}

@endforeach
