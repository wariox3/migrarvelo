<?php
//     include 'conexion.php';
//     $mysql = new manejadorMySql();
//     $sqlServer = new manejadorSqlServer();
//     $arCuentasOfima = $sqlServer->consulta("SELECT RTRIM(CODIGOCTA) AS CODIGOCTA, RTRIM(DESCRIPCIO) AS DESCRIPCIO FROM CUENTAS");
//     while( $row = sqlsrv_fetch_array( $arCuentasOfima, SQLSRV_FETCH_ASSOC) ) {
//          $arCuenta = $mysql->buscar("SELECT codigo_cuenta_pk FROM fin_cuenta WHERE codigo_cuenta_pk = '{$row['CODIGOCTA']}'");
//          if($arCuenta->num_rows <= 0) {
//               $nombre = utf8_encode($row['DESCRIPCIO']);
//               $sql = "INSERT INTO fin_cuenta (codigo_cuenta_pk, nombre)
//                                    VALUES ('{$row['CODIGOCTA']}', '{$nombre}')";
//               if($insertar = $mysql->insertar($sql)) {
//                    echo "Se creo la cuenta {$row['CODIGOCTA']} <br/>";
//               }
//          }
//     }



?>
