<?php

class manejadorMySql{
    private $host   ="192.168.2.91";
    private $usuario="administrador";
    private $clave  ="seracis2020";
    private $db     ="bdseracis";
    public $conexion;
    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db);
        if ($this->conexion->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $this->conexion->connect_errno . ") " . $this->conexion->connect_error;
        }
        $this->conexion->set_charset("utf8");
    }
    //BUSCAR
    public function buscar($sql){
        $resultado = $this->conexion->query($sql) or die($this->conexion->error);
        if($resultado)
            return $resultado;
        return false;
    }
    //CONSULTA
    public function consulta($sql){
        $resultado = $this->conexion->query($sql) or die($this->conexion->error);
        if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }
    //INSERTAR
    public function insertar($sql){
        $resultado = mysqli_query($this->conexion, $sql);
        if($resultado) {
            return $resultado;
        } else {
            echo "Falló script: ({$sql})" . $this->conexion->error . "<br/>";
        }
        return false;
    }
}

class manejadorSqlServer{
    public $conexion;
    public function __construct(){
        $serverName = "192.168.2.243\RDBSERACIS";
        $connectionInfo = array( "Database" => "seracis_prd", "UID"=>"semantica", "PWD"=>"Vigilancia2022@");
        $this->conexion = sqlsrv_connect( $serverName, $connectionInfo);
    }
    //CONSULTA
    public function consulta($sql){
        $resultado = sqlsrv_query($this->conexion, $sql, array(), array( "Scrollable" => SQLSRV_CURSOR_CLIENT_BUFFERED ));
        if($resultado) {
            return $resultado;
        } else {
            die( print_r( sqlsrv_errors(), true) );
        }
        return false;

    }
}