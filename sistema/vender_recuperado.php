<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	if($_SESSION['rol']<1)
    {
		header('location:../');
    }

	$iduser=$_SESSION['idUser'];

	$tipo="";
	$bandera=0;

	$numerofacturav=0;
	
	$idcliente=$_POST['cbx_cliente'];
	
	
	$consultaCli=mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente='$idcliente'");
	$resultadoC=mysqli_num_rows($consultaCli);
	
		while($data=mysqli_fetch_array($consultaCli)){
			$nit=$data["nit"];
			$nomcliente=$data["nombrec"];
		}





	$total=$_POST['valor1'];

	date_default_timezone_set('America/Bogota');
    $fechaactual2 = Date('Y-m-d H:i:s', time());
	
	
	//SE GENERA FACTURA
	if (!empty($_POST['credito'])){ 
		$tipo=2;

		//echo $tipo."sipi";

		

		//SE GENERA FACTURA CREDITO
		$query_factura=mysqli_query($conexion, "INSERT INTO facturaV (fecha, usuario, codcliente, ajuste, totalfactura, tipofactura)
		VALUES ('$fechaactual2','$iduser','$idcliente', 0 , '$total', '$tipo')");
		$bandera=1;

		//ultima factura
		$numfactura=mysqli_query($conexion, "SELECT MAX(nofacturav) from facturaV");
		$numfactura1= mysqli_fetch_array($numfactura);
		$numerofacturav=$numfactura1[0];

	}else{ 
		//SE GENERA FACTURA
		$query_factura=mysqli_query($conexion, "INSERT INTO facturaV (fecha,usuario, codcliente, ajuste, totalfactura)
                                VALUES ('$fechaactual2','$iduser','$idcliente', 0 , '$total')");
								
		//ultima factura
		$numfactura=mysqli_query($conexion, "SELECT MAX(nofacturav) from facturaV");
		$numfactura1= mysqli_fetch_array($numfactura);
		$numerofacturav=$numfactura1[0];

		//SE MODIFICA EL INGRESO
		$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "SELECT ingresos from cuadre WHERE idcuadre='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);

		$ingresos= $datoinicio["ingresos"];
		$ingresos=$ingresos+$total;
		$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET ingresos=$ingresos WHERE idcuadre='$controlinicial'"); 
	}




	//variables
	$idproducto1=0; $descripcion1=""; $peso1=0; $valor1=0; $subtotal1=0;
	
	

	//DATOS DEL PRODUCTO 1
	if (!empty($_POST['codrecuperado1'])){
		$codrecuperado=$_POST['codrecuperado1'];

		date_default_timezone_set('America/Bogota');
		$fechaactual2 = Date('Y-m-d H:i:s', time());
		

		//los articulos vendidos quedan en estatus 2
		$inicio1=mysqli_query($conexion,"UPDATE recuperado SET fechaventa_recuperado='$fechaactual2',
								precioventa_recuperado=$total, 
								idcliente=$idcliente, nofactura=$numerofacturav, estatus=2
								WHERE codrecuperado=$codrecuperado");
		//se consulta el articulo
		$query=mysqli_query($conexion,"SELECT descripcion_recuperado, peso_recuperado, precioventa_recuperado 
		FROM recuperado WHERE codrecuperado=$codrecuperado ");

		$result =mysqli_num_rows($query);

		if($result > 0){
				while($data=mysqli_fetch_array($query)){
					$descripcion1=$data['descripcion_recuperado'];
					
				}

		//se agrega detalle de la factura producto 1
		$query_producto1 = mysqli_query($conexion, "INSERT INTO detallefacturaV (nofacturav, 
							nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofacturav','$descripcion1', 1 , '$total','$total')");
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
	<title>Vender</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Recibo de Venta</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="Vender.php" method="POST">
					

					<div class="wd100">
						<h4>Nombre del Cliente</h4>
					</div>

					<tr>
						<th colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></th>
						<td colspan="2"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nomcliente; ?>"></td>
						
					</tr>
					
					
					
					

					<div class="wd100">
						<h4>Detalle de la Venta</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="2">Valor Venta</th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


	 			<tr>
				 	<input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $prod1; ?>">
					<td colspan="1">
						<input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
					</td>
					
					
					<td colspan="2">
						<input type="text" name="valor1" id="valor1" readonly="readonly" value="<?php echo $total; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal1" id="subtotal1" readonly="readonly" value="<?php echo $total; ?>">
					</td>
				</tr>
				

				


				

				
			</tbody>
		</table>	

					
					<center><a href='facturaV_pdf.php' target="_blank" class="btn_imp">Imprimir Recibo</a></center>

                    
				
					
					<div class="wd30"><input type="button" onclick=" location.href='nueva_venta.php'" target="_blank" 
					                value="Realizar Otra Venta" name="boton" class="btn_procesar"  /></div>


		

			</form>
		</div>
			

		
	</section>
		
</body>
</html>
