<?php
	session_start();
	include "../conexion.php";

	include "../conexion.php";
		mysqli_set_charset($conexion,'utf8'); 

		$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "select egresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);

			$egresos= $datoinicio["egresos"];
			$controlinicio= $datoinicio["estatus"];

			if($controlinicio==0)
			{

				mysqli_close($conexion);
				echo "<script>
						alert('No Existe un Cuadre Abierto');
						window.location= '../index.php'
					</script>";

			}




	$numfactura=0;
	$motivo="";
	

	if(!empty($_POST))
	{
		$numfactura=$_POST['numfactura'];
		$motivo=$_POST['motivo'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");
		//se elimina la factura poniendole estatus 0
		$query_delete=mysqli_query($conexion,"UPDATE factura SET estatus=0, motivo='$motivo'
					  WHERE nofactura=$numfactura");
		/*/se carga el valor de la factura
		$factura=mysqli_query($conexion, "select abono from factura WHERE nofactura='$numfactura'");
		$factura2=mysqli_fetch_array($factura);

		$totalfactura= $factura2["totalfactura"];
		

		
		//SE MODIFICA EL EGRESO
			$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
			$inicio1= mysqli_fetch_array($inicio);
			$controlinicial=$inicio1[0];

			$inicio2=mysqli_query($conexion, "SELECT egresos from cuadre WHERE idcuadre='$controlinicial'");
			$datoinicio=mysqli_fetch_array($inicio2);

			$egresos= $datoinicio["egresos"];
			$egresos=$egresos-$totalfactura;
			$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET egresos=$egresos WHERE idcuadre='$controlinicial'");	*/
		

		
		


		//se buscan las cantidades de producto en detalle para restarlo a las existencias

		$detalle=mysqli_query($conexion, "SELECT cantidad, nomproducto from detallefactura WHERE nofactura=$numfactura");

		WHILE($row=$detalle->fetch_assoc()){

			//se afecta la existencia del producto
			$descrip=$row['nomproducto'];
			$inicio0=mysqli_query($conexion, "SELECT existencia from producto WHERE descripcion='$descrip'");
			$datoinicio0=mysqli_fetch_array($inicio0);

			$existencia0= $datoinicio0["existencia"];
			$cantidad=$row['cantidad'];
			$existencia0=$existencia0-$cantidad;
			$query_existencia0=mysqli_query($conexion, "UPDATE producto SET 
								existencia=$existencia0 WHERE descripcion='$descrip'");
		}


                if($detalle){
					header("location: listar_compra_anulada.php");
				}else{
					echo "Error al Eliminar";
				}

	}



	if(empty($_REQUEST['id']) )
	{
		header("location: listar_compra.php");
	}else{
		include "../conexion.php";
		$numfactura=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT * FROM factura WHERE nofactura='$numfactura'");
        $result =mysqli_num_rows($query);
		
		$motivo= "Cliente en Desacuerdo con el Precio";

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
					header("location: listar_compra.php");
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
	<title>Anular Compra Crédito</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
		//echo $motivo;
	?>
	
	<section id=container>
	<div class="form_register">
            <h1>Anular Compra Crédito</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>
			<form method="post" action="" onsubmit="return confirmation()" >
				<h2>¿Está Seguro de Anular el Siguiente Recibo de Compra?</h2>
                <p>Número de Recibo:<span><?php echo $numfactura; ?></span></p>
				<p>Cliente:<span><?php echo $nombrecliente ; ?></span></p>
				<p>NIT:<span><?php echo $nitcliente; ?></span></p>
                <p>Valor Pagado:<span><?php echo "$".$valorfactura; ?></span></p>
				
				
				
					<input type="hidden" name="numfactura" value="<?php echo $numfactura; ?>">
					<label for="motivo">Motivo de Anulación</label>
					<select name="motivo" id="motivo" value="<?php echo $motivo; ?>">  
							<option value="Cliente en Desacuerdo con el Precio">Cliente en Desacuerdo con el Precio</option>
							<option value="Error en el Precio Liquidado">Error en el Precio Liquidado</option>
							<option value="Error de Digitación">Error de Digitación</option>
							<option value="Producto Sucio">Producto Sucio</option>
					</select>

					<a href="listar_compra.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
				</form>
			</div>	
	</div>
			
			
	</section>


<script type="text/javascript">
     function confirmation() 
     {
        if(confirm("Esta Seguro de Anular el Recibo de Pago <?php echo $numfactura; ?>?"))
	{
	   return true;
	}
	else
	{
	   return false;
	}
     }
    </script>








		
</body>
</html>
