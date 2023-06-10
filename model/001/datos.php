<?php
class Datos
{

    private $conexion;
    public function __construct()
    {
        require_once '../conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }



    public function eliminar($codigo)
    {
        $sql = "DELETE FROM resumen WHERE llave='$codigo'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function modificar_Error($codigo,$error,$cdr)
    {
        $error = base64_encode($error);
        $sql = "UPDATE resumen SET errores='$error',cdr='$cdr' WHERE llave='$codigo'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
       
       
        $this->conexion->cerrar();
    }

    public function modificar_Error_Ticket($codigo,$error)
    {
        $error = base64_encode($error);
        $sql = "UPDATE resumen SET errores='$error' WHERE llave='$codigo'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
       
       
        $this->conexion->cerrar();
    }

    public function agregar_Ticket($codigo,$ticket,$status)
    {

        if($status==1){
            $sql = "UPDATE resumen SET nticket='$ticket',anu='$status',estadocpe='1' WHERE llave='$codigo'";
        }else{
            $sql = "UPDATE resumen SET nticket='$ticket',anu='$status',estadocpe='2' WHERE llave='$codigo'";
        }
  
        
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
       
       
        $this->conexion->cerrar();
    }

    public function consultar_Error($codigo)
    {
       // $error = base64_encode($codigo);
        $sqlNum="SELECT errores FROM resumen WHERE llave='$codigo' ";
        $result = $this->conexion->conexion->query($sqlNum);
        $row = mysqli_fetch_array($result);
        if ($row[0]==''){
              echo '';
        }else{
              echo base64_decode($row[0]);
        }
       
        $this->conexion->cerrar();
    }

    




}
