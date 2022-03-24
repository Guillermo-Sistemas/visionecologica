<?php
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$codrecuperado=$_POST['codrecuperado'];

		$query=mysqli_query($conexion,"SELECT precioventa_recuperado,nofactura
										FROM recuperado codrecuperado=$codrecuperado ");
		
        $result =mysqli_num_rows($query);
		

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$precio=$data['precioventa_recuperado'];
						$numfactura=$data['nofactura'];
					}
				}
		//se elimina la factura poniendole estatus 0
		$query_delete=mysqli_query($conexion,"UPDATE facturaV SET estatus=0
					  WHERE nofacturav=$numfactura");
		
		//SE MODIFICA EL INGRESO
		$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "SELECT ingresos from cuadre WHERE idcuadre='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);

		$ingresos= $datoinicio["ingresos"];
		$ingresos=$ingresos-$precio;
		$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET ingresos=$ingresos WHERE idcuadre='$controlinicial'");

		//se pone el articulo en estatus 1

		$query_delete=mysqli_query($conexion,"UPDATE recuperado SET estatus=1
									 WHERE codrecuperado=$codrecuperado");
		        if($query_delete){
					header("location: listar_recuperado.php");
				}else{
					echo "Error al Eliminar la Venta";
				}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_venta.php");
	}else{
		include "../conexion.php";
		$codrecuperado=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT r.descripcion_recuperado, r.peso_recuperado, r.precioventa_recuperado,
										r.fechaventa_recuperado, c.nombre, r.nofactura
										FROM recuperado r INNER JOIN cliente c 
										ON r.idcliente=c.idcliente WHERE r.codrecuperado=$codrecuperado ");
		
        $result =mysqli_num_rows($query);
		

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$articulo=$data['descripcion_recuperado'];
						$peso=$data['peso_recuperado'];
						$precio=$data['precioventa_recuperado'];
						$fecha=$data['fechaventa_recuperado'];
						$numfactura=$data['nofactura'];
						$nombre=$data['nombre'];
					}

					
				}else{
					header("location: articulos_vendidos.php");
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
	<title>Anular Compra</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">
				<h2>¿Está Seguro de Anular el Siguiente Recibo de Venta?</h2>
                <p>Número de Recibo: <span><?php echo $numfactura; ?></span></p>
				<p>Cliente: <span><?php echo $nombre ; ?></span></p>
				<p>Artículo: <span><?php echo $articulo ; ?></span></p>
				<p>Peso: <span><?php echo $peso ; ?></span></p>
				<p>Valor Cobrado: <span><?php echo "$".$precio; ?></span></p>
				<p>Vendido el: <span><?php echo $fecha ; ?></span></p>
				

				<form method="post" action="">
					<input type="hidden" name="codrecuperado" value="<?php echo $codrecuperado; ?>">
					<a href="listar_venta.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
				</form>
			</div>	
			
			
	</section>
		<?php
			include "include/footer.php";
		?>
</body>
</html>
