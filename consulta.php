<?php
class CONSULTA{
    public function getConsulta($argConsulta){
        //obtenemos las materias disponibles
        //conectamos  la BD
        $modelo = new coneccion();
        $connecion = $modelo->getConneccion();
        //realizamos la consuta
        $declaracion = $connecion->prepare($argConsulta);
        //pasamos los datos por parametramos
        //ejecutamos la $consulta
        if(!$declaracion){
            return false;
        }
        else{
            $declaracion->execute();
            while ($resultado = $declaracion->fetch()){
                $registos[]= $resultado;
            }
            if(empty($registos)){
                return false;
            }else{
                return $registos;
            }
            //devoldemos los registros
        }
    }
}
?>