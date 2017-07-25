Estimado Colaborador: {{$usuario}}
Se le informa que los siguientes Materiales no cuentan con cuenta contable asignada favor de verificarlas.
Proyecto: {{$obra->nombre}}
<?php
if ($material_restante>0) {
    echo "MATERIALES";
    echo utf8_decode("
    Configuradas: " . $material_actual . "
    Pendientes: " . $material_restante. "
    _______________________________________________________________
    ");
}
if ($mano_restante>0) {
    echo "MANO DE OBRA Y SERVICIOS";
    echo utf8_decode("
    Configuradas: " . $mano_actual . "
    Pendientes: " . $mano_restante. "
    _______________________________________________________________
    ");
}
if ($herramienta_restante>0) {
    echo "HERRAMIENTA Y EQUIPO";
    echo utf8_decode("
    Configuradas: " . $herramienta_actual . "
    Pendientes: " . $herramienta_restante. "
    _______________________________________________________________
    ");
}
if ($maquinaria_restante>0) {
    echo "MAQUINARIA";
    echo utf8_decode("
    Configuradas: " . $maquinaria_actual . "
    Pendientes: " . $maquinaria_restante. "
    _______________________________________________________________
    ");
}


?>
