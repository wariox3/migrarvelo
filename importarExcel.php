<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/src/SimpleXLSX.php';
include 'conexion.php';
$mysql = new manejadorMySql();
set_time_limit(0);
ini_set("memory_limit", -1);
$ruta = "/home/desarrollo/Escritorio/veloenvios/p2.xlsx";
if ( $xlsx = SimpleXLSX::parse( $ruta ) ) {
    $dim = $xlsx->dimension();
    $cols = $dim[0];
    $indice = 0;
    foreach ( $xlsx->rows() as $k => $r ) {
        if($indice > 0) {
            $numeroIdentificacion = $r[4];
            $dane_ciudad_remitente = $r[10];
            $dane_ciudad_destinatario = $r[17];
            $sql = "INSERT INTO temporal (doccliente, dane_ciudad_remitente, dane_ciudad_destinatario)
                            VALUES ('{$numeroIdentificacion}', '{$dane_ciudad_remitente}', '{$dane_ciudad_destinatario}')";
            if($insertar = $mysql->insertar($sql)) {

            }
        }
        $indice++;
    }
} else {
    echo SimpleXLSX::parseError();
}