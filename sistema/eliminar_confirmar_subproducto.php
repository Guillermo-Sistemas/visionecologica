<?php
	include "../conexion.php";

	session_start();

	if(!empty($_POST))
	{
		$codsubproducto=$_POST['codsubproducto'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");

		$query_delete=mysqli_query($conexion,"UPDATE subproducto SET estatus_subpro=0 WHERE codsubproducto=$codsubproducto");

                if($query_delete){
					header("location: listar_subproducto.php");
				}else{
					echo "Error al Eliminar";
				}
	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_subproducto.php");
	}else{
		include "../conexion.php";
		$codsubproducto=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT s.codsubproducto, p.descripcion, s.nombre_subpro FROM
                                        subproducto s INNER JOIN producto p ON s.codproducto=p.codproducto WHERE codsubproducto=$codsubproducto");
                
                $result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$codsubpro=$data['codsubproducto'];
						$descripcion=$data['nombre_subpro'];
						$producto=$data['descripcion'];
						

					}
				}else{
					
					header("location: listar_subproducto.php");
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
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">


				
									

					<h2>¿Está Seguro de Eliminar el Siguiente Subproducto?</h2>
					<p>Descripción:<span><?php echo $descripcion; ?></span></p>
                    <p>Del Producto:<span><?php echo $producto; ?></span></p>
					
				

					<form method="post" action="">

					<input type="hidden" name="codsubproducto" value="<?php echo $codsubproducto; ?>">
					<a href="listar_subproducto.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
						
						
					</form>
			</div>	
			
			
	</section>


					


				
		<?php
			include "include/footer.php";
		?>
</body>
</html>
