<?php
	session_start();
	$iduser=$_SESSION['idUser'];
	include "../conexion.php";

	if(!empty($_POST))
	{
		$idgasto=$_POST['idgasto'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
		//no se borra el gasto se le pone estatus cero (0)
		$query_delete=mysqli_query($conexion,"UPDATE gastomayor SET IDUSUARIO=$iduser, estatus=0  WHERE idgastom=$idgasto");

		//se consulta el valor del gasto que se elimino
		$query_gasto=mysqli_query($conexion,"SELECT valorgastom FROM gastomayor WHERE idgastom=$idgasto");
		$resultgasto =mysqli_fetch_array($query_gasto);
					$gasto= $resultgasto["valorgastom"];

		//se consulta el valor actual de los egresos en el cuadre
		//se recupera el valor actual de egresos en el cuadre
		$inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "select egresos from cajamayor WHERE idcaja='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);
		$egresos= $datoinicio["egresos"];
			//al valor actual de los egresos se le resta el valor del gasto eliminado
			$egresos=$egresos-$gasto;

			//se modifica el valor de los egresos
			$queryegreso=mysqli_query($conexion, "UPDATE cajamayor
                            SET egresos=$egresos WHERE idcaja=$controlinicial");



                if($query_delete && $queryegreso){
					header("location: listar_gastomayor.php");
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

		
		
		$query=mysqli_query($conexion,"SELECT * FROM gastomayor WHERE idgastom=$idgasto");
                $result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$idtipo=$data['idtipogastom'];
						$tercero=$data['idcliente'];
						$valor=$data['valorgastom'];
					}

					echo $tercero;

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
				<h2>¿Está Seguro de Eliminar el Gasto de Caja Mayor <span><?php echo $gasto; ?>  </h2>
				
				<p>Del Cliente:    <span><?php echo $cliente; ?></span></p>
				<p>Por Valor de:  <span><?php echo $valor; ?></span></p>
				

				<form method="post" action="">
					<input type="hidden" name="idgasto" value="<?php echo $idgasto; ?>">
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