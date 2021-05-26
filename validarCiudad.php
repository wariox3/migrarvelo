<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/src/SimpleXLSX.php';
include 'conexion.php';
$mysql = new manejadorMySql();
$mysqlDestino = new manejadorMySqlDestino();
set_time_limit(0);
ini_set("memory_limit", -1);
$arCiudades = $mysql->consulta2("SELECT dane_ciudad_destinatario FROM temporal GROUP BY dane_ciudad_destinatario");
while ($fila = $arCiudades->fetch_row()) {
    $arCiudad = $mysqlDestino->buscar("SELECT codigo_ciudad_pk FROM tte_ciudad WHERE codigo_division = '{$fila[0]}'");
    if($arCiudad->num_rows <= 0) {
        echo "Destino {$fila[0]}<br/>";
    }
}
$arCiudades = $mysql->consulta2("SELECT dane_ciudad_remitente FROM temporal GROUP BY dane_ciudad_remitente");
while ($fila = $arCiudades->fetch_row()) {
    $arCiudad = $mysqlDestino->buscar("SELECT codigo_ciudad_pk FROM tte_ciudad WHERE codigo_division = '{$fila[0]}'");
    if($arCiudad->num_rows <= 0) {
        echo "Remitente {$fila[0]}<br/>";
    }
}

