Estimado Colaborador: {{$usuario}}
Se le informa que las siguientes Empresas no cuentan con cuenta contable asignada favor de verificarlas.
Proyecto: {{$obra->nombre}}
<?php

if (count($cuentas_empresa)) {
    echo "CUENTAS SIN CONFIGURAR";
    foreach ($cuentas_empresa as $index => $cuenta) {
        echo utf8_decode("
    Cuenta: " . $cuenta_empresa->razon_social . "
    Estatus: Sin configurar
    ______________________________________________________________
    ");
    }
}

?>