<?php
	include "../conexion.php";

	session_start();

	if(!empty($_POST))
	{
		$codrecuperado=$_POST['codrecuperado'];

		date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
		//el producto se elimina dandole estatus = cero

		

		$query_delete=mysqli_query($conexion,"UPDATE recuperado SET fechaventa_recuperado='$fechaactual2', estatus=0
									 WHERE codrecuperado=$codrecuperado");

		//se recupera el peso y el cod del producto del articulo eliminado
		$query=mysqli_query($conexion,"SELECT codproducto, peso_recuperado FROM recuperado 
										WHERE codrecuperado=$codrecuperado ");
		
		$result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$codproducto=$data['codproducto'];
						$peso=$data['peso_recuperado'];
					}
				}

		//se reestablece el peso al producto del cual se elimino el producto

		$inicio1=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$codproducto'");
                    $datoinicio1=mysqli_fetch_array($inicio1);

                    $existencia1= $datoinicio1["existencia"];
                    $existencia1=$existencia1+$peso;
                    $query_existencia1=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia1 WHERE codproducto='$codproducto'");

                    



		
                
				$result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$descripcion=$data['descripcion_recuperado'];
						$producto=$data['descripcion'];
						$peso=$data['peso_recuperado'];
						$precio=$data['precioventa_recuperado'];
					}
				}

                if($inicio1){
					header("location: articulos_eliminados.php");
				}else{
					echo "Error al Eliminar";
				}
	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_recuperado.php");
	}else{
		include "../conexion.php";
		$codrecuperado=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT r.descripcion_recuperado, r.fecha_recuperado, p.descripcion, 
							r.peso_recuperado, r.precioventa_recuperado FROM recuperado r INNER JOIN producto p 
							ON r.codproducto=p.codproducto WHERE r.codrecuperado=$codrecuperado ");
                
				$result =mysqli_num_rows($query);


				//date_default_timezone_set('America/Bogota');
                //$fechaactual2 = Date('Y-m-d H:i:s', time());


                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$descripcion=$data['descripcion_recuperado'];
						$producto=$data['descripcion'];
						$peso=$data['peso_recuperado'];
						$precio=$data['precioventa_recuperado'];
						

					}
				}else{
					
					header("location: listar_recuperado.php");
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
	<title>Eliminar Artículo</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">


				
									

					<h2>¿Está Seguro de Eliminar el Siguiente Artículo?</h2>
					<p>Descripción:<span><?php echo $descripcion; ?></span></p>
                    <p>Del Producto:<span><?php echo $producto; ?></span></p>
					<p>Peso:<span><?php echo $peso; ?></span></p>
					<p>Precio de Venta:<span><?php echo $precio; ?></span></p>
					
				

					<form method="post" action="">

					<input type="hidden" name="codrecuperado" value="<?php echo $codrecuperado; ?>">
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
