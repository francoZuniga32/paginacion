<?php
require_once("coneccion.php");
require_once("consulta.php");

if($_POST['buscar'] != ""){
    $buscar = $_POST['buscar'];
    
    $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina']: 1; //la pagina actual si es cualquier cosa es la primera sino la que sigue
    $registosPorPagina = 20; //cantidad de registros por pagina
    $inicio = ($pagina>0)?(($pagina * $registosPorPagina)- $registosPorPagina): 0;//la pagina inicio para la divicion de del paginador
    
    $sql = "SELECT * FROM materia WHERE LIMIT $inicio, $registosPorPagina";
    $consulta = new CONSULTA();
    $filas = $consulta->getConsulta("SELECT * FROM materia WHERE materia.nombre LIKE '%$buscar%' LIMIT $inicio, $registosPorPagina");
    $total = $consulta->getConsulta("SELECT * FROM materia WHERE materia.nombre LIKE '%$buscar%'");
    
    if(count($filas)==0){
        echo"
        <div class=\"alert alert-danger\" role=\"alert\">
            A simple danger alert—check it out!
        </div>";
    }else{
        $i = 0;
        foreach($filas as $fila){
            if($i % 3 == 0){
                echo "
                </div>
                <div class=\"row\">";
            }
            echo "<div class=\"col rounded border\">".$fila['nombre']."</div>";
            $i = $i + 1;
        }
        echo "</div></br>";
        
        paginador($total, $registosPorPagina, $pagina, "cargarBusqueda");
    }
}else{
    $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina']: 1; //la pagina actual si es cualquier cosa es la primera sino la que sigue
    $registosPorPagina = 18; //cantidad de registros por pagina
    $inicio = ($pagina>0)?(($pagina * $registosPorPagina)- $registosPorPagina): 0;//la pagina inicio para la divicion de del paginador
    
    $sql = "SELECT * FROM materia LIMIT $inicio, $registosPorPagina";
    $consulta = new CONSULTA();
    $filas = $consulta->getConsulta("SELECT * FROM materia LIMIT $inicio, $registosPorPagina");
    $total = $consulta->getConsulta("SELECT * FROM materia ");
    
    $i = 0;
    
    foreach($filas as $fila){
        if($i % 3 == 0){
            echo "
            </div>
            <div class=\"row\">";
        }
        echo "<div class=\"col rounded border\">".$fila['nombre']."</div>";
        $i = $i + 1;
    }
    echo "</div></br>";
    
    paginador($total, $registosPorPagina, $pagina, "cargar");
}


function paginador($total, $registosPorPagina, $pagina, $funcion){
    $contador = count($total);
    $paginas = intval($contador/$registosPorPagina);


    echo "<nav class=\"Page navigation example d-flex justify-content-center\" >
          <ul class=\"pagination\">";
            //para mostrar el prev
    		if ($pagina == 1) {
    			echo "<li class=\"page-item disabled\"><a class=\"page-link\">-</></li>";
    		}
    		else{
    			$numero = $pagina - 1;
                echo "
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"#\" aria-label=\"Previous\" onclick=\"".$funcion."(".$numero.",".$registosPorPagina.")\">
                        <span aria-hidden=\"true\">&laquo;</span>
                    </a>
                </li>";
            }
            
            //para mostrar el resto de paginas

            if ($pagina <= 3) {
                if ($paginas > 3) {
                    for($i = 1; $i <= 3; $i++){
                        if ($i == $pagina) {
                            echo "<li class=\"page-item active\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.",".$registosPorPagina.")\">".$i."</span></a></li>";
                        }else{
                            echo "<li class=\"page-item\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.")\">".$i."</span></a></li>";
                        }
                    }
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" role=\"button\">...</a></li>";
                }else{
                    for($i = 1; $i <= $paginas; $i++){
                        if ($i == $pagina) {
                            echo "<li class=\"page-item active\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.",".$registosPorPagina.")\"><span>".$i."</span></a></li>";
                        }else{
                            echo "<li class=\"page-item\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.")\">".$i."</span></a></li>";
                        }
                    }
                }
                
            }else{
                if ($pagina > $paginas - 3) {
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" role=\"button\">...</a></li>";

                    for($i = $paginas - 2 ; $i<= $paginas; $i++){
                        if ($i == $pagina) {
                            echo "<li class=\"page-item active\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.")\">".$i."</span></a></li>";
                        }else{
                            echo "<li class=\"page-item\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.")\">".$i."</span></a></li>";
                        }                    }
                }else{
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" role=\"button\">...</a></li>";
                    for($i = $pagina - 1 ; $i <= $pagina + 1; $i++){
                        if ($i == $pagina) {
                            echo "<li class=\"page-item active\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.")\">".$i."</span></a></li>";
                        }else{
                            echo "<li class=\"page-item\" id=\"".$i."\"><a class=\"page-link\" href=\"#\" role=\"button\" onclick=\"".$funcion."(".$i.")\">".$i."</span></a></li>";
                        }                    }
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"#\" role=\"button\">...</a></li>";
                }
            }
            //para mostrar el next
    		if ($pagina == $paginas) {
    			echo "<li class=\"page-item\"><a class=\"page-link\">-</a></li>";
    		}
    		else{
    			$numero = $pagina + 1;
                echo "
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"#\" aria-label=\"Previous\" onclick=\"".$funcion."(".$i.")\">
                        <span aria-hidden=\"true\">&raquo;</span>
                    </a>
                </li>";
    		}
        	echo "</ul>
        </nav>";
}
?>