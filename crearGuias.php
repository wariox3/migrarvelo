<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/src/SimpleXLSX.php';
include 'conexion.php';
$mysql = new manejadorMySql();
$mysqlDestino = new manejadorMySqlDestino();
set_time_limit(0);
ini_set("memory_limit", -1);
$arGuias = $mysql->consulta2("SELECT * FROM temporal");
while ($fila = $arGuias->fetch_row()) {
    $arTercero = $mysqlDestino->buscar("SELECT codigo_tercero_pk FROM gen_tercero WHERE numero_identificacion = '{$fila[0]}'");
    if($arTercero->num_rows <= 0) {
        echo "{$fila[0]}<br/>";
    }
}

