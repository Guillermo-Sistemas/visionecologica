<?php
    session_start();
    $iduser=$_SESSION['idUser'];
    include "../conexion.php";
    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['valor']) )
        {
            
            $alert='<p class="msg_error">El Gasto debe de tener un Valor.</p>';
        }else{
            $idgasto=$_POST['idgasto'];
            $tipogasto=$_POST['gasto'];
            $tercero=$_POST['tercero'];
            $valor2=$_POST['valor'];
            $nota2=$_POST['nota'];

            //se recupera el valor actual de egresos en el cuadre
            $inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
            $inicio1= mysqli_fetch_array($inicio);
            $controlinicial=$inicio1[0];

            $inicio2=mysqli_query($conexion, "select egresos from cajamayor WHERE idcaja='$controlinicial'");
            $datoinicio=mysqli_fetch_array($inicio2);
            $egresos= $datoinicio["egresos"];

            //se recupera el valor actual del gasto
            $gastoactual2=mysqli_query($conexion, "select valorgastom from gastomayor WHERE idgastom='$idgasto'");
            $gastoactual3=mysqli_fetch_array($gastoactual2);
            $gastoactual= $gastoactual3["valorgastom"];

            
            //al valor de los egresos se le resta el actual y se le suma el modificado y se modifica el valor en el cuadre
            $egresos=$egresos-$gastoactual+$valor2;

            //echo $egresos."/".$gastoactual."/".$valor2;

            $queryegreso=mysqli_query($conexion, "UPDATE cajamayor
                            SET egresos=$egresos WHERE idcaja=$controlinicial");
                

            //se modifica el gasto
            $query_gasto=mysqli_query($conexion, "UPDATE gastomayor SET idtipogastom=$tipogasto, idcliente=$tercero, 
                        valorgastom=$valor2, notam='$nota2', idusuario=$iduser, estatus=3  WHERE idgastom=$idgasto");
                           

                        if( $queryegreso && $query_gasto){
                            $alert='<p class="msg_error">Gasto Actualizado Correctamente. </p>';
                        }else{
                            $alert='<p class="msg_error">Error al Actualizar el Gasto. </p>';
                        }
        }
    }
    

    if(empty($_GET['id']))
    {
    
    }
    $idgasto=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT * FROM
                    gasto WHERE idgasto=$idgasto");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_gastomayor.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            $idgas = $data['idgasto' ];
            $gasto = $data['idtipogasto' ];
            $cliente = $data['idcliente' ];
            $valor = $data['valorgasto' ];
            $nota = $data['nota' ];
        }

        $querygasto=mysqli_query($conexion, "select nombregasto from tipo_gasto WHERE idtipogasto='$gasto'");
		$datogasto=mysqli_fetch_array($querygasto);
		$gasto= $datogasto["nombregasto"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Actualizar Gasto Mayor</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Actualizar Gasto Mayor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="idgasto" value="<?php echo $idgasto; ?>">
                
                <?php
                    $query_gasto=mysqli_query($conexion, "SELECT * FROM tipo_gasto ORDER BY nombregasto ASC");
                    $result_gasto=mysqli_num_rows($query_gasto);
                ?>
                
                <label for="gasto">Gasto</label>
                <select name="gasto" id="gasto">
                <?php
                    if($result_gasto > 0){
                        while($gasto=mysqli_fetch_array($query_gasto)){ 
                ?>
                    <option value="<?php echo $gasto["idtipogasto"]; ?>"><?php echo $gasto["nombregasto"]; ?></option>
                <?php
                    }
                }
                ?>
                </select>
                


                <label for="nombre">Tercero</label>
                
                <select name="tercero" id="tercero">
                    <?php
                        $query_tercero=mysqli_query($conexion, "SELECT * FROM cliente ORDER BY nombrec ASC");
                        $result_tercero=mysqli_num_rows($query_tercero);
                        if($result_tercero > 0){
                            while($tercero=mysqli_fetch_array($query_tercero)){ 
                        
                    ?>
                        <option value="<?php echo $tercero["idcliente"]; ?>"><?php echo $tercero["nombrec"]; ?></option>
                    <?php
                        }

                        mysqli_close($conexion);
                    }
                    ?>
                    </select>
                


                <label for="valor">Valor</label>
                <input type="number" name="valor" id="valor" 
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                 placeholder="VALOR" value="<?php echo $valor; ?>">
                <label for="nota">Nota</label>
                <input type="text" name="nota" id="nota" placeholder="NOTA" value="<?php echo $nota; ?>">
                
                
                </select>
                
                <input type="submit" value="Actualizar Gasto" class="btn_save">
                <input type="button" onclick=" location.href='listar_gasto.php' " value="Cancelar" name="boton" class="btn_cancelado"  /> 
            </form>
        </div>
			
	</section>

</body>
</html>
