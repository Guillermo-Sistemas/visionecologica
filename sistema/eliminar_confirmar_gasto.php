<?php
	session_start();
	$iduser=$_SESSION['idUser'];
	include "../conexion.php";

	$empleado="";
	$gasto=0;

	if(!empty($_POST))
	{
		$idgasto=$_POST['idgasto'];
		$procedencia=$_POST['procedencia'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
		//no se borra el gasto se le pone estatus cero (0)
		$query_delete=mysqli_query($conexion,"UPDATE gasto SET IDUSUARIO=$iduser, estatus=0  WHERE idgasto=$idgasto");

		//se consulta el valor del gasto que se elimino
		$query_gasto=mysqli_query($conexion,"SELECT idtipogasto, idcliente, valorgasto FROM gasto WHERE idgasto=$idgasto");
		$resultgasto =mysqli_fetch_array($query_gasto);
					$tipogasto= $resultgasto["idtipogasto"];
					$gasto= $resultgasto["valorgasto"];
					$empleado= $resultgasto["idcliente"];

		 //si el gasto es en efectivo de la caja general********************
			if ($procedencia==1){
				//se consulta el valor actual de los egresos en el cuadre
				$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
				$inicio1= mysqli_fetch_array($inicio);
				$controlinicial=$inicio1[0];

				$inicio2=mysqli_query($conexion, "select egresos from cuadre WHERE idcuadre='$controlinicial'");
				$datoinicio=mysqli_fetch_array($inicio2);
				$egresos= $datoinicio["egresos"];
				//al valor actual de los egresos se le resta el valor del gasto eliminado
				$egresos=$egresos-$gasto;

				//se modifica el valor de los egresos
				$queryegreso=mysqli_query($conexion, "UPDATE cuadre
								SET egresos=$egresos WHERE idcuadre=$controlinicial");
			}else{
				$inicioMayor=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
                        $inicioMayor1= mysqli_fetch_array($inicioMayor);
                        $controlMayor=$inicioMayor1[0];

				$inicioMayor=mysqli_query($conexion, "select egresos, bancosale 
							from cajamayor WHERE idcaja='$controlMayor'");
				$datoinicioMayor=mysqli_fetch_array($inicioMayor);
				$egresosMayor= $datoinicioMayor["egresos"];
				$bancoSale= $datoinicioMayor["bancosale"];

				if ($procedencia==2){//si el gasto es efectivo de caja Mayor
					$egresosMayor=$egresosMayor-$gasto;
					$queryegreso=mysqli_query($conexion, "UPDATE cajamayor
					SET egresos=$egresosMayor WHERE idcaja=$controlMayor");;
				}else{//si el gasto es consignacion
					$bancoSale=$bancoSale-$gasto;
					$querySale=mysqli_query($conexion, "UPDATE cajamayor
					SET bancosale=$bancoSale WHERE idcaja=$controlMayor");;
				}
			}//fin ********************************************************

		

			//SI EL GASTO ES UN PRESTAMO SE MODIFICA
			echo "ojo".$idgasto;
			if($tipogasto==26){

				

				$totpres=mysqli_query($conexion, "select id, total from prestamo WHERE id_empleado='$empleado'");
				$datototal=mysqli_fetch_array($totpres);
				//$id= $datototal["id"];
				$total= $datototal["total"];
				
				

				$total=$total-$gasto;
	
				//se modifica el valor total del prestamo
				$queryegreso=mysqli_query($conexion, "UPDATE prestamo
								SET total=$total WHERE id_empleado='$empleado'");

				//se modifica el estado del detalle
				$querydet=mysqli_query($conexion, "UPDATE detalleprestamo
				SET estatusdetalleprestamo=0 WHERE id_gasto='$idgasto'");
			}// fin de gasto prestamo




                if($query_delete){
					header("location: listar_gasto.php");
				}else{
					echo "Error al Eliminar el Gasto";
				}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_gasto.php");
	}else{
		include "../conexion.php";
		$idgasto=$_REQUEST['id'];

		
		
		$query=mysqli_query($conexion,"SELECT * FROM gasto WHERE idgasto=$idgasto");
                $result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$idtipo=$data['idtipogasto'];
						$tercero=$data['idcliente'];
						$valor=$data['valorgasto'];
						$procedencia=$data['procedencia'];
					}

					if($procedencia==1){
						$procedencianombre="Efectivo";
					}elseif($procedencia==2){
						$procedencianombre="Efectivo Caja Mayor";
					}else{
						$procedencianombre="Consignación";
					}

					$querygasto=mysqli_query($conexion,"SELECT nombregasto FROM tipo_gasto WHERE idtipogasto=$idtipo");
                	$resultgasto =mysqli_fetch_array($querygasto);
					$gasto= $resultgasto["nombregasto"];

					$querycliente=mysqli_query($conexion,"SELECT nombrec FROM cliente WHERE idcliente=$tercero");
                	$resultcliente =mysqli_fetch_array($querycliente);
					$cliente= $resultcliente["nombrec"];

				}else{
					header("location: listar_gasto.php");
				}
			}
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Eliminar Gasto</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">
				<h2>¿Está Seguro de Eliminar el Gasto <span><?php echo $gasto; ?>  </h2>
				
				<p>Del Cliente:    <span><?php echo $cliente; ?></span></p>
				<p>Por Valor de:  <span><?php echo $valor; ?></span></p>
				<p>Realizado con:  <span><?php echo $procedencianombre; ?></span></p>

				

				<form method="post" action="">
					<input type="hidden" name="idgasto" value="<?php echo $idgasto; ?>">
					<input type="hidden" name="procedencia" value="<?php echo $procedencia; ?>">
					<a href="listar_gasto.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
				</form>
			</div>	
			
			
	</section>
		<?php
			include "include/footer.php";
		?>
</body>
</html>