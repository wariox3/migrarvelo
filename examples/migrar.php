<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/../src/SimpleXLSX.php';

$ruta = "/home/desarrollo/Escritorio/importar.xlsx";
if ( $xlsx = SimpleXLSX::parse( $ruta ) ) {
    $dim = $xlsx->dimension();
    $cols = $dim[0];
    foreach ( $xlsx->rows() as $k => $r ) {
        echo $r[0] . "<br/>";
//        for ( $i = 0; $i < $cols; $i ++ ) {
//            echo '<td>' . ( isset( $r[ $i ] ) ? $r[ $i ] : '&nbsp;' ) . '</td>';
//        }
    }

} else {
    echo SimpleXLSX::parseError();
}