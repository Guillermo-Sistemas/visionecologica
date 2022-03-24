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
        }elseif($tipogasto=$_POST['gasto']==26){
            $alert='<p class="msg_error">No se Puede Actualizar un gasto a tipo Prestamo, debe ser Eliminado y 
                    se debe volver a Registrar el Gasto.</p>';

                    
        }else{
            $idgasto=$_POST['idgasto'];
            $tipogasto=$_POST['gasto'];
            $tercero=$_POST['tercero'];
            $valor2=$_POST['valor'];
            $nota2=$_POST['nota'];
            
            $procedencia=$_POST['procedencia'];

            

            if($_POST['fechareal']){

                
                            
                $dia=substr( $_POST['fechareal'], 3, 2 );
                $mes=substr( $_POST['fechareal'], 0, 2 );
                $ano=substr( $_POST['fechareal'], 6, 4 );
                $fechareal=$ano."-".$mes."-".$dia;

                echo $_POST['fechareal']."/////////////".$fechareal;

            }else{  
                date_default_timezone_set('America/Bogota');
                $fechareal = Date('Y-m-d');
               
            }
            
            //se recupera el valor actual de egresos en el cuadre
            $inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
            $inicio1= mysqli_fetch_array($inicio);
            $controlinicial=$inicio1[0];

            $inicio2=mysqli_query($conexion, "select egresos from cajamayor WHERE idcaja='$controlinicial'");
            $datoinicio=mysqli_fetch_array($inicio2);
            $egresos= $datoinicio["egresos"];

            //se recupera el valor actual del gasto
            $gastoactual2=mysqli_query($conexion, "select valorgasto from gasto WHERE idgasto='$idgasto'");
            $gastoactual3=mysqli_fetch_array($gastoactual2);
            $gastoactual= $gastoactual3["valorgasto"];

            //al valor de los egresos se le resta el actual y se le suma el modificado y se modifica el valor en el cuadre
            $egresos=$egresos-$gastoactual+$valor2;
            $queryegreso=mysqli_query($conexion, "UPDATE cajamayor
                            SET egresos=$egresos WHERE idcaja=$controlinicial");
                

            //se modifica el gasto
            $query_gasto=mysqli_query($conexion, "UPDATE gasto SET idtipogasto=$tipogasto, idcliente=$tercero, 
                        valorgasto=$valor2, nota='$nota2', IDUSUARIO=$iduser, estatus=3
                        , procedencia=$procedencia, fechareal='$fechareal'  WHERE idgasto=$idgasto");
                           

                        if( $queryegreso && $query_gasto){
                            $alert='<p class="msg_error">Gasto Actualizado Correctamente. </p>';
                        }else{
                            $alert='<p class="msg_error">Error al Actualizar el Gasto. </p>';
                        }
        }//fin del else
    }
    

    if(empty($_GET['id']))
    {
    
    }
    $idgasto=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT * FROM
                    gasto WHERE idgasto=$idgasto");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_gasto.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            //$idgas = $data['idgasto' ];
            $gastoorig = $data['idtipogasto' ];
            $clienteorig = $data['idcliente' ];
            $valororig = $data['valorgasto' ];
            $notaorig = $data['nota' ];
            $procedencia = $data['procedencia' ];
        }

        if($procedencia==1){
            $procedencianombre="Efectivo";
        }elseif($procedencia==2){
            $procedencianombre="Efectivo Caja Mayor";
        }else{
            $procedencianombre="Consignación";
        }

        $querygasto=mysqli_query($conexion, "select nombregasto from tipo_gasto WHERE idtipogasto='$gastoorig'");
		$datogasto=mysqli_fetch_array($querygasto);
		$gastonombre= $datogasto["nombregasto"];

        $querynombre=mysqli_query($conexion, "select nombrec from cliente WHERE idcliente='$clienteorig'");
		$datonombre=mysqli_fetch_array($querynombre);
		$clientenombre= $datonombre["nombrec"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Actualizar Gasto Caja Mayor</title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
    <link rel="stylesheet" type="text/css" href="css/tcal.css" />
    <script type="text/javascript" src="js/tcal.js"></script> 
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Actualizar Gasto Caja Mayor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="idgasto" value="<?php echo $idgasto; ?>">
                
                <label for="gasto">Gasto</label>
                <select name="gasto" id="gasto">
                <?php
                    $query_gasto=mysqli_query($conexion, "SELECT * FROM tipo_gasto ORDER BY nombregasto ASC");
                    $result_gasto=mysqli_num_rows($query_gasto);
            
                    if($result_gasto > 0){
                        while($gasto=mysqli_fetch_array($query_gasto)){ 
                            
                ?>
                    <option value="<?php echo $gastoorig; ?>"SELECTED><?php echo $gastonombre; ?></option>
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
                        <option value="<?php echo $clienteorig; ?>"SELECTED><?php echo $clientenombre; ?></option>
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
                 placeholder="VALOR" value="<?php echo $valororig; ?>">

                 <label for="valor">Fecha de Pago</label>
                <input type="text" name="fechareal" id="fechareal" class="tcal" placeholder="Fecha de Pago Gasto">


                <label for="nota">Nota</label>
                <input type="text" name="nota" id="nota" placeholder="NOTA" value="<?php echo $notaorig; ?>">
                
                <label for="procedencia">Procedencia</label>
                        <select name="procedencia" id="procedencia" value="1">  
                                <option value="2">Efectivo Caja Mayor</option>
                                <option value="3">Consignación</option>
                         </select>
                
                <input type="submit" value="Actualizar Gasto" class="btn_save">
                <input type="button" onclick=" location.href='listar_gastomayor.php' " value="Cancelar" name="boton" class="btn_cancelado"  /> 
            </form>
        </div>
			
	</section>

</body>
</html>
