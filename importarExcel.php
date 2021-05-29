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
            $nomcliente = str_replace("'","", $r[5]);
            $detalle_destinatario = str_replace("'","", $r[12]);
            $anexo = str_replace("'","", $r[3]);
            $otros_cobros = 0;
            if(is_numeric($r[24])) {
                $otros_cobros = $r[24];
            }
            $sql = "INSERT INTO temporal (fecha_registro, estadoGuia, numero_guia, anexo, doccliente, nomcliente, direccion_recogida,
                                centro_costo_cl_envia, centro_logistico_envia, ciudadRemitente, dane_ciudad_remitente, documento_destinatario, detalle_destinatario,    
                                direccion_destinatario, centrocosto_cl_recibe, centro_logistico_recibe, ciudadDestinatario, dane_ciudad_destinatario, formaPago,
                                unidades, PesoReal, PesoFacturado, valor_declarado, valor_manejo, otros_cobros, valor_total, fecha_entregado, fecha_cumplido, fecha_facturado,
                                vr_flete, telefono_destinatario)
                            VALUES ('{$r[0]}','{$r[1]}','{$r[2]}','{$anexo}','{$r[4]}','{$nomcliente}','{$r[6]}','{$r[7]}','{$r[8]}','{$r[9]}','{$r[10]}','{$r[11]}','{$detalle_destinatario}',
                                    '{$r[13]}','{$r[14]}','{$r[15]}','{$r[16]}','{$r[17]}','{$r[18]}','{$r[19]}','{$r[20]}','{$r[21]}','{$r[22]}','{$r[23]}','{$otros_cobros}','{$r[25]}','{$r[26]}'
                                    ,'{$r[27]}','{$r[28]}','{$r[30]}','{$r[31]}')";
            if($insertar = $mysql->insertar($sql)) {

            }
        }
        $indice++;
    }
} else {
    echo SimpleXLSX::parseError();
}