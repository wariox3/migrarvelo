<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/src/SimpleXLSX.php';
include 'conexion.php';
$mysql = new manejadorMySql();
$mysqlDestino = new manejadorMySqlDestino();
$utilidades = new utilidades();
set_time_limit(0);
ini_set("memory_limit", -1);
$arGuias = $mysql->consulta3("SELECT * FROM temporal limit 100000");
if (mysqli_num_rows($arGuias) > 0) {
    $codigoGuia = 1;
    while($fila = mysqli_fetch_assoc($arGuias)){
        $codigoGuiaTipoFk = $utilidades->tipoGuia($fila["formaPago"]);
        $codigoOperacionIngresoFk = $utilidades->operacion($fila["centro_costo_cl_envia"]);
        $codigoOperacionCargoFk = $utilidades->operacion($fila["centrocosto_cl_recibe"]);
        $codigoTerceroFk = $utilidades->codigoTercero($fila["doccliente"]);
        $codigoCiudadOrigenFk = $utilidades->codigoCiudad($fila["dane_ciudad_remitente"]);
        $codigoCiudadDestinoFk = $utilidades->codigoCiudad($fila["dane_ciudad_destinatario"]);
        $estadoEntregado = $utilidades->estadoEntregado($fila['estadoGuia']);
        $estadoFacturado = $utilidades->estadoFacturado($fila["fecha_facturado"]);
        $estadoCumplido = $fila['estadoGuia'] == 'C'?1:0;
        $estadoSoporte = $fila['estadoGuia'] == 'C'?1:0;
        if($codigoTerceroFk && $codigoCiudadOrigenFk && $codigoCiudadDestinoFk) {
            $sql = "INSERT INTO tte_guia (codigo_guia_pk, codigo_guia_tipo_fk, codigo_operacion_ingreso_fk, codigo_operacion_cargo_fk, codigo_tercero_fk, codigo_ciudad_origen_fk, 
                      codigo_ciudad_destino_fk, numero, documento_cliente, remitente, nombre_remitente, direccion_remitente,
                      nombre_destinatario, direccion_destinatario, fecha_ingreso, fecha_entrega,
                      fecha_cumplido, fecha_factura, unidades, peso_real, peso_volumen, peso_facturado, 
                      vr_declara, vr_flete, vr_manejo, estado_autorizado, estado_aprobado, estado_entregado, estado_facturado, estado_cumplido, estado_soporte, 
                      seguimiento)
                            VALUES ({$codigoGuia}, '{$codigoGuiaTipoFk}', '{$codigoOperacionIngresoFk}', '{$codigoOperacionCargoFk}', {$codigoTerceroFk}, {$codigoCiudadOrigenFk},
                                    {$codigoCiudadDestinoFk}, {$codigoGuia}, '{$fila["anexo"]}', '{$fila["nomcliente"]}', '{$fila["nomcliente"]}', '{$fila["direccion_recogida"]}',
                                    '{$fila["detalle_destinatario"]}','{$fila["direccion_destinatario"]}', {$utilidades->fecha($fila["fecha_registro"])}, {$utilidades->fecha($fila["fecha_entregado"])},
                                    {$utilidades->fecha($fila["fecha_cumplido"])}, {$utilidades->fecha($fila["fecha_facturado"])}, {$fila["unidades"]}, {$fila["PesoReal"]}, {$fila["PesoReal"]}, {$fila["PesoFacturado"]}, 
                                    {$fila["valor_declarado"]}, 0, {$fila["valor_manejo"]}, 1, 1, {$estadoEntregado}, {$estadoFacturado}, {$estadoCumplido}, {$estadoSoporte},
                                    '{$fila["numero_guia"]}')";
            if($insertar = $mysqlDestino->insertar($sql)) {

            }
            $codigoGuia++;
        }
    }
} else {
    die("Error: No hay datos en la tabla seleccionada");
}

class utilidades {

    public function operacion($codigoCentroCosto){
        switch ($codigoCentroCosto) {
            case "14002":
                return "ARM";
            case "15001":
                return "BAR";
            case "12001":
                return "BOG";
            case "17001":
                return "BUC";
            case "13203":
                return "BUE";
            case "13001":
                return "CAL";
            case "17002":
                return "CUC";
            case "14001":
                return "DOS";
            case "16001":
                return "IBA";
            case "13206":
                return "IPI";
            case "11001":
                return "MED";
            case "13205":
                return "PAS";
            case "15002":
                return "SIN";
            case "13200":
                return "TUL";
            default:
                return "MED";
        }
    }

    public function tipoGuia($formaPago) {
        switch ($formaPago) {
            case "Contado":
                $codigoGuiaTipoFk = 'CON';
                break;
            case "Cuenta Corriente":
                $codigoGuiaTipoFk = 'COR';
                break;
            case "Contra Entrega":
                $codigoGuiaTipoFk = 'CEN';
                break;
            case "Carta Porte":
                $codigoGuiaTipoFk = 'CPT';
                break;
            default:
                $codigoGuiaTipoFk = 'COR';
        }
        return $codigoGuiaTipoFk;
    }

    public function codigoTercero($doccliente) {
        $mysqlDestino = new manejadorMySqlDestino();
        $arTercero = $mysqlDestino->buscar("SELECT codigo_tercero_pk FROM gen_tercero WHERE numero_identificacion = '{$doccliente}'");
        if($arTercero->num_rows > 0) {
            $arTercero = $arTercero->fetch_row();
            return $arTercero[0];
        } else {
            echo "El numero de identificacion {$doccliente} no existe<br/>";
            return null;
        }
    }

    public function codigoCiudad($codigo) {
        $mysqlDestino = new manejadorMySqlDestino();
        $arCiudad = $mysqlDestino->buscar("SELECT codigo_ciudad_pk FROM tte_ciudad WHERE codigo_division = '{$codigo}'");
        if($arCiudad->num_rows > 0) {
            $arCiudad = $arCiudad->fetch_row();
            return $arCiudad[0];
        } else {
            echo "Codigo dane ciduad {$codigo} no existe<br/>";
            return null;
        }
    }

    public function fecha($fecha) {
        if($fecha) {
            if($fecha == "N") {
                return "NULL";
            } else {
                $validacion = date_create($fecha);
                if($validacion) {
                    return "'{$fecha}'";
                } else {
                    return "NULL";
                }
            }
        } else {
            return "NULL";
        }


    }

    public function estadoEntregado($estado) {
        if($estado == 'C' || $estado == 'E') {
            return 1;
        } else {
            return 0;
        }
    }

    public function estadoFacturado($fechaFactura) {
        if($fechaFactura == 'N') {
            return 0;
        } else {
            return 1;
        }
    }
}
