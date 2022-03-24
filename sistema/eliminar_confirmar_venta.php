<?php
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$numfactura=$_POST['numfacturav'];
		$motivo=$_POST['motivo'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
		//se elimina la factura poniendole estatus 0
		$query_delete=mysqli_query($conexion,"UPDATE facturaV SET estatus=0, motivo='$motivo'
					  WHERE nofacturav=$numfactura");
		//secarga el valor de la factua
		$factura=mysqli_query($conexion, "select totalfactura, tipofactura from facturaV WHERE nofacturav='$numfactura'");
		$factura2=mysqli_fetch_array($factura);

		$totalfactura= $factura2["totalfactura"];
		$tipofact= $factura2["tipofactura"];

		if ($tipofact==1){
			//SE MODIFICA EL INGRESO
			$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
			$inicio1= mysqli_fetch_array($inicio);
			$controlinicial=$inicio1[0];

			$inicio2=mysqli_query($conexion, "SELECT ingresos from cuadre WHERE idcuadre='$controlinicial'");
			$datoinicio=mysqli_fetch_array($inicio2);

			$ingresos= $datoinicio["ingresos"];
			$ingresos=$ingresos-$totalfactura;
			$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET ingresos=$ingresos WHERE idcuadre='$controlinicial'");
		}

		//se buscan las cantidades de producto en detalle para restarlo a las existencias

		$detalle=mysqli_query($conexion, "SELECT cantidad, nomproducto, codproducto from detallefacturaV
								 WHERE nofacturav='$numfactura'");

		WHILE($row=$detalle->fetch_assoc()){

			$descrip=$row['nomproducto'];
			$cod=$row['codproducto'];

			//$subp1=mysqli_query($conexion, "SELECT codproducto from subproducto WHERE nombre_subpros='$descrip'");
			//$subp2=mysqli_fetch_array($subp1);
			//se afecta la existencia del producto que no es subproducto
			if ($cod==0){
				$inicio0=mysqli_query($conexion, "SELECT existencia from producto WHERE descripcion='$descrip'");
				$datoinicio0=mysqli_fetch_array($inicio0);


				//se afecta la existencia del producto
				$existencia0= $datoinicio0["existencia"];
				$cantidad=$row['cantidad'];
				$existencia0=$existencia0+$cantidad;
				$query_existencia0=mysqli_query($conexion, "UPDATE producto SET 
									existencia=$existencia0 WHERE descripcion='$descrip'"); 
			//se afecta la existencia del subproducto en el producto
			}else{ 
				$inicio0=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$cod'");
				$datoinicio0=mysqli_fetch_array($inicio0);


				//se afecta la existencia del producto
				$existencia0= $datoinicio0["existencia"];
				$cantidad=$row['cantidad'];
				$existencia0=$existencia0+$cantidad;
				$query_existencia0=mysqli_query($conexion, "UPDATE producto SET 
									existencia=$existencia0 WHERE codproducto='$cod'");
			}




			
		}


                if($detalle){
					header("location: listar_venta.php");
				}else{
					echo "Error al Eliminar";
				}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_venta.php");
	}else{
		include "../conexion.php";
		$numfactura=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT * FROM facturaV WHERE nofacturav='$numfactura'");
        $result =mysqli_num_rows($query);
		

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$codcliente=$data['codcliente'];
						$valorfactura=$data['totalfactura'];
					}

					//nombre y nit del cliente
					$query_cliente=mysqli_query($conexion, "SELECT nit, nombrec from cliente WHERE idcliente='$codcliente'");
					$query_cliente1= mysqli_fetch_array($query_cliente);

					$nitcliente= $query_cliente1["nit"];
					$nombrecliente= $query_cliente1["nombrec"];
				}else{
					header("location: listar_venta.php");
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
	<title>Anular Venta</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
	<div class="form_register">
			<h1>Anular Venta</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>
			<form method="post" action="" onsubmit="return confirmation()" >
				<h2>¿Está Seguro de Anular el Siguiente Recibo de Venta?</h2>
                <p>Número de Recibo:<span><?php echo $numfactura; ?></span></p>
				<p>Cliente:<span><?php echo $nombrecliente ; ?></span></p>
				<p>NIT:<span><?php echo $nitcliente; ?></span></p>
                <p>Valor Cobrado:<span><?php echo "$".$valorfactura; ?></span></p>
				

				<input type="hidden" name="numfactura" value="<?php echo $numfactura; ?>">
					<label for="motivo">Motivo de Anulación</label>
					<select name="motivo" id="motivo" value="<?php echo $motivo; ?>">  
							<option value="Cliente en Desacuerdo con el Precio">Cliente en Desacuerdo con el Precio</option>
							<option value="Error en el Precio Liquidado">Error en el Precio Liquidado</option>
							<option value="Error de Digitación">Error de Digitación</option>
							<option value="Producto Sucio">Producto Sucio</option>
					</select>


					
					<a href="listar_venta.php" class="btn_cancel">Cancelar</a>

<input type="submit" value="Aceptar" class="btn_ok"></a>

					
				</form>
			</div>	
			
			
	</section>
		
</body>
</html>
