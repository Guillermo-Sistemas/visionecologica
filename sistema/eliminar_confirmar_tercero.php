<?php
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$idcliente=$_POST['idcliente'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");

		$query_delete=mysqli_query($conexion,
			"UPDATE cliente SET estatus=0 WHERE idcliente=$idcliente");
			

                if($query_delete){
					header("location: listar_tercero.php");
				}else{
					echo "Error al Eliminar";
				}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_tercero.php");
	}else{
		include "../conexion.php";
		$idcliente=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT c.nit, c.nombrec
										FROM cliente c  
										WHERE idcliente=$idcliente");
                $result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$nit=$data['nit'];
						$nombre=$data['nombrec'];
					}
				}else{
					header("location: listar_tercero.php");
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
	<title>Eliminar Tercero</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">
				<h2>¿Está Seguro de Eliminar el Siguiente Tercero?</h2>
				<p>NIT:<span><?php echo $nit; ?></span></p>
				<p>Nombre:<span><?php echo $nombre; ?></span></p>
				

				<form method="post" action="">
					<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
					<a href="listar_tercero.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
				</form>
			</div>	
			
			
	</section>
		<?php
			include "include/footer.php";
		?>
</body>
</html>