<?php
	include "../conexion.php";

	session_start();

	if(!empty($_POST))
	{
		$codproducto=$_POST['codproducto'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");

		$query_delete=mysqli_query($conexion,"UPDATE producto SET estatus=0 WHERE codproducto=$codproducto");

                if($query_delete){
					header("location: listar_producto.php");
				}else{
					echo "Error al Eliminar";
				}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_producto.php");
	}else{
		include "../conexion.php";
		$codproducto=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT p.descripcion, p.existencia
										FROM producto p 
										WHERE codproducto=$codproducto");
                $result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						
						$descripcion=$data['descripcion'];
						$existencia=$data['existencia'];
						

					}
				}else{
					
					header("location: listar_producto.php");
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
	<title>Eliminar Prodcuto</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">


				<?php
					if ($existencia!=0 ){
						if ($existencia>0 ){
						?>

					<h2>El Siguiente Producto no se puede Eliminar</h2>
					<p>Descripción:<span><?php echo $descripcion; ?></span></p>
					<p>Cantidad en Existencia:<span><?php echo $existencia; ?></span></p>
					<h2>Debido a que hay existencia</h2>
				

					<form method="post" action="">

					<input type="hidden" name="codproducto" value="<?php echo $codproducto; ?>">
					<a href="listar_producto.php" class="btn_cancel">Cancelar</a>
									
						
					</form>


						<?php
						}else{
						?>

					<h2>El siguiente Producto se debe de ajustar en los Inventarios</h2>
					<p>Descripción:<span><?php echo $descripcion; ?></span></p>
					<p>Cantidad en Existencia:<span><?php echo $existencia; ?></span></p>
					<h2>Ya que Refleja cantidad negativa</h2>
				

					<form method="post" action="">

					<input type="hidden" name="codproducto" value="<?php echo $codproducto; ?>">
					<a href="listar_producto.php" class="btn_cancel">Cancelar</a>
					<input type="" href="listar_producto.php" value="Aceptar" class="btn_ok"></a>
					</form>

						<?php
						}

					 }else{
					?>

				<h2>¿Está Seguro de Eliminar el Siguiente Producto?</h2>
					<p>Descripción:<span><?php echo $descripcion; ?></span></p>
					<p>Cantidad en Existencia:<span><?php echo $existencia; ?></span></p>
				

					<form method="post" action="">

					<input type="hidden" name="codproducto" value="<?php echo $codproducto; ?>">
					<a href="listar_producto.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
						
						
					</form>
			</div>	
			
			
	</section>


					<?php
					  }

				?>


				
		<?php
			include "include/footer.php";
		?>
</body>
</html>