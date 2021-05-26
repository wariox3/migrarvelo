<?php

class manejadorMySql{
    private $host   ="localhost";
    private $usuario="root";
    private $clave  ="70143086";
    private $db     ="bdmigrarvelo";
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
    //CONSULTA
    public function consulta2($sql){
        $resultado = $this->conexion->query($sql) or die($this->conexion->error);
        return $resultado;
    }
    public function consulta3($sql){
        $resultado = mysqli_query($this->conexion, $sql);
        return $resultado;
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
class manejadorMySqlDestino{
    private $host   ="localhost";
    private $usuario="root";
    private $clave  ="70143086";
    private $db     ="bdveloenvios";
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
    //CONSULTA
    public function consulta2($sql){
        $resultado = $this->conexion->query($sql) or die($this->conexion->error);
        return $resultado;
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