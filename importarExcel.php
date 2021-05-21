<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/src/SimpleXLSX.php';
include 'conexion.php';
$mysql = new manejadorMySql();
set_time_limit(0);
ini_set("memory_limit", -1);
$ruta = "/home/desarrollo/Escritorio/importarCompleto.xlsx";
if ( $xlsx = SimpleXLSX::parse( $ruta ) ) {
    $dim = $xlsx->dimension();
    $cols = $dim[0];
    foreach ( $xlsx->rows() as $k => $r ) {
        $numeroIdentificacion = $r[4];
        $sql = "INSERT INTO temporal (doccliente)
                            VALUES ('{$numeroIdentificacion}')";
        if($insertar = $mysql->insertar($sql)) {

        }
    }
} else {
    echo SimpleXLSX::parseError();
}