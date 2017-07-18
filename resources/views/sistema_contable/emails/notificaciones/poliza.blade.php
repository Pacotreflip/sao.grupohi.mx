Estimado Colaborador: {{$usuario}}
Se le informa que las siguientes pólizas han sido registradas y tienen errores que deben corregirse  para que puedan ser enviadas al Contpaq.

<?php

foreach($polizas as $index=>$poliza){
    echo utf8_decode("
    Numero de pre-póliza: ".$poliza->id_int_poliza."
    Tipo de Póliza: ".$poliza->tipo_poliza."
    Concepto: ".$poliza->concepto."
    Total: ".$poliza->total."
    Cuadre:".$poliza->cuadre."
    Póliza ContPaq: ".$poliza->poliza_contpaq."
    _______________________________________________________________
");


}

?>