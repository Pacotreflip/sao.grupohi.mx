Estimado Colaborador: {{$usuario}}
Se le informa que las siguientes pólizas requieren de revisión para poder ser emitidas correctamente.
Proyecto: {{$obra->nombre}}
<?php
if (count($polizas_errores)) {
    echo "PÓLIZAS CON ERRORES";
    foreach ($polizas_errores as $index => $poliza) {
        echo utf8_decode("
    Numero de pre-póliza: " . $poliza['id_int_poliza']. "
    Tipo de Póliza: " . $poliza['tipo_poliza']. "
    Concepto: " . $poliza['concepto']. "
    Total: " . $poliza['total']. "
    Cuadre:" . $poliza['cuadre']. "
    Estatus: CON ERROR
    Póliza ContPaq: " . $poliza['poliza_contpaq']. "
    _______________________________________________________________
    ");
    }
}
if (count($polizas_no_validadas)) {
    echo "PÓLIZAS NO VALIDADAS";
    foreach ($polizas_no_validadas as $index => $poliza) {
        echo utf8_decode("
    Numero de pre-póliza: " . $poliza['id_int_poliza']. "
    Tipo de Póliza: " . $poliza['tipo_poliza']. "
    Concepto: " . $poliza['concepto']. "
    Total: " . $poliza['total']. "
    Cuadre:" . $poliza['cuadre']. "
    Estatus: NO VALIDADA
    Póliza ContPaq: " . $poliza['poliza_contpaq']. "
    _______________________________________________________________
    ");
    }
}
if (count($polizas_no_lanzadas)) {
    echo "PÓLIZAS NO LANZADAS";
    foreach ($polizas_no_lanzadas as $index => $poliza) {
        echo utf8_decode("
    Numero de pre-póliza: " . $poliza['id_int_poliza']. "
    Tipo de Póliza: " . $poliza['tipo_poliza']. "
    Concepto: " . $poliza['concepto']. "
    Total: " . $poliza['total']. "
    Cuadre:" . $poliza['cuadre']. "
    Estatus: NO LANZADA
    Póliza ContPaq: " . $poliza['poliza_contpaq']. "
    _______________________________________________________________
    ");
    }
}

?>