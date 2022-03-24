<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	if($_SESSION['rol']<1)
   	 {
		header('location:../');
    	}

	$tipo="";
	$bandera=0;
	$numerofactura=0;
	$remision="";
	$idcliente="";
	$nomcliente="";
	$nuevocliente="";

	$iduser=$_SESSION['idUser'];

	//nuevo cliente en calcular compra
	if (!empty($_POST['nuevocliente'])){
		$nuevocliente=$_POST['nuevocliente'];


		$query_insert=mysqli_query($conexion, "INSERT INTO cliente(nit, nombrec, telefono, direccion, tipo_cliente)
                                    VALUES ('0','$nuevocliente', '0', 'No tiene','temporal')");
							$inicio=mysqli_query($conexion, "select MAX(idcliente) from cliente");
							$inicio1= mysqli_fetch_array($inicio);
							$controlcliente=$inicio1[0];

							$idcliente=$controlcliente;
							$nomcliente=$nuevocliente;

	}else{//sin nuevo cliente
		$idcliente=$_POST['idcliente'];
		$nomcliente=$_POST['nomcliente'];
	}

	
	

	

	$total=$_POST['total'];
    $ajuste=$_POST['ajuste'];
	$motivo=$_POST['motivo'];

	$qajuste=0;

	date_default_timezone_set('America/Bogota');
	$fechaactual2 = Date('Y-m-d H:i:s', time());

	//echo $fechaactual2."/".$iduser."/".$idcliente."/".$total."/".$motivo;

	
	//SE GENERA devolucion
		$query_devolucion=mysqli_query($conexion, "INSERT INTO devolucionv (fechadevv, usuario, codcliente, total_devv, motivo)
                                VALUES ('$fechaactual2','$iduser','$idcliente','$total', '$motivo')");
								
		//ultima devolucion
		$numdevolucion=mysqli_query($conexion, "SELECT MAX(nodevolucionv) from devolucionv");
		$numdevolucion1= mysqli_fetch_array($numdevolucion);
		$numerodevolucion=$numdevolucion1[0];



		//SE MODIFICA EL ingreso
		$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "SELECT ingresos from cuadre WHERE idcuadre='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);

		$ingresos= $datoinicio["ingresos"];
		$ingresos=$ingresos-$total;

		

		$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET ingresos=$ingresos WHERE idcuadre='$controlinicial'"); 
	

	
	$total=number_format($total, 0, ",", ".");
		
	

	//variables
	$idproducto0=0; $descripcion0=""; $cantidades0=0; $peso0=0; $valor0=0; $subtotal0=0;
	$idproducto1=0; $descripcion1=""; $cantidades1=0; $peso1=0; $valor1=0; $subtotal1=0;
	$idproducto2=0; $descripcion2=""; $cantidades2=0; $peso2=0; $valor2=0; $subtotal2=0;
	$idproducto3=0; $descripcion3=""; $cantidades3=0; $peso3=0; $valor3=0; $subtotal3=0;
	$idproducto4=0; $descripcion4=""; $cantidades4=0; $peso4=0; $valor4=0; $subtotal4=0;
	$idproducto5=0; $descripcion5=""; $cantidades5=0; $peso5=0; $valor5=0; $subtotal5=0;
	
	
	//DATOS DEL PRODUCTO 0
	if (!empty($_POST['idproducto0'])){
		$idproducto0=$_POST['idproducto0'];
		$descripcion0=$_POST['descripcion0'];
		
		$peso0=$_POST['peso0'];
		$valor0=$_POST['valor0'];
		$subtotal0=$_POST['subtotal0'];
		//se afecta la existencia del producto
		$inicio0=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto0'");
		$datoinicio0=mysqli_fetch_array($inicio0);

		$existencia0= $datoinicio0["existencia"];
		$existencia0=$existencia0+$peso0;
		$query_existencia0=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia0 WHERE codproducto='$idproducto0'");

		//se agrega detalle de la factura producto 0
		$query_producto0 = mysqli_query($conexion, "INSERT INTO detalledevv (nodevolucionv, 
						nomproducto, cantidad, valorkilo,  subtotal)
						VALUES ('$numerodevolucion','$descripcion0'
						,'$peso0', '$valor0','$subtotal0')");
	}

	//DATOS DEL PRODUCTO 1
	if (!empty($_POST['idproducto1'])){
		$idproducto1=$_POST['idproducto1'];
		$descripcion1=$_POST['descripcion1'];
		
		$peso1=$_POST['peso1'];
		$valor1=$_POST['valor1'];
		$subtotal1=$_POST['subtotal1'];

		//se afecta la existencia del producto 1
		$inicio1=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto1'");
		$datoinicio1=mysqli_fetch_array($inicio1);

		$existencia1= $datoinicio1["existencia"];
		$existencia1=$existencia1+$peso1;
		$query_existencia1=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia1 WHERE codproducto='$idproducto1'");

		//se agrega detalle de la factura producto 1
		$query_producto1 = mysqli_query($conexion, "INSERT INTO detalledevv (nodevolucionv, 
										nomproducto, cantidad, valorkilo,  subtotal)
							VALUES ('$numerodevolucion','$descripcion1'
							,'$peso1', '$valor1','$subtotal1')");
	}

    //DATOS DEL PRODUCTO 2
	if (!empty($_POST['idproducto2'])){
		$idproducto2=$_POST['idproducto2'];
		$descripcion2=$_POST['descripcion2'];
		
		$peso2=$_POST['peso2'];
		$valor2=$_POST['valor2'];
		$subtotal2=$_POST['subtotal2'];

		//se afecta la existencia del producto 2
		$inicio2=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto2'");
		$datoinicio2=mysqli_fetch_array($inicio2);

		$existencia2= $datoinicio2["existencia"];
		$existencia2=$existencia2+$peso2;
		$query_existencia2=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia2 WHERE codproducto='$idproducto2'");

		//se agrega detalle de la factura producto 2
		$query_producto2 = mysqli_query($conexion, "INSERT INTO detalledevv (nodevolucionv, 
								nomproducto, cantidad, valorkilo,  subtotal)
						VALUES ('$numerodevolucion','$descripcion2'
						,'$peso2', '$valor2','$subtotal2')");
	}


     //DATOS DEL PRODUCTO 3
	if (!empty($_POST['idproducto3'])){
		$idproducto3=$_POST['idproducto3'];
		$descripcion3=$_POST['descripcion3'];
		
		$peso3=$_POST['peso3'];
		$valor3=$_POST['valor3'];
		$subtotal3=$_POST['subtotal3'];

		//se afecta la existencia del producto 3
		$inicio3=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto3'");
		$datoinicio3=mysqli_fetch_array($inicio3);

		$existencia3= $datoinicio3["existencia"];
		$existencia3=$existencia3+$peso3;
		$query_existencia3=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia3 WHERE codproducto='$idproducto3'");

		 //se agrega detalle de la factura producto 3
		$query_producto3 = mysqli_query($conexion, "INSERT INTO detalledevv (nodevolucionv, 
								nomproducto, cantidad, valorkilo,  subtotal)
						VALUES ('$numerodevolucion','$descripcion3'
						,'$peso3', '$valor3','$subtotal3')");
	}


     //DATOS DEL PRODUCTO 4
	
	 if (!empty($_POST['idproducto4'])){
		$idproducto4=$_POST['idproducto4'];
		$descripcion4=$_POST['descripcion4'];
		
		$peso4=$_POST['peso4'];
		$valor4=$_POST['valor4'];
		$subtotal4=$_POST['subtotal4'];

		//se afecta la existencia del producto 4
		$inicio4=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto4'");
		$datoinicio4=mysqli_fetch_array($inicio4);

		$existencia4= $datoinicio4["existencia"];
		$existencia4=$existencia4+$peso4;
		$query_existencia4=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia4 WHERE codproducto='$idproducto4'");

		 //se agrega detalle de la factura producto 4
		$query_producto4 = mysqli_query($conexion, "INSERT INTO detalledevv (nodevolucionv, 
							nomproducto, cantidad, valorkilo,  subtotal)
					VALUES ('$numerodevolucion','$descripcion4'
					,'$peso4', '$valor4','$subtotal4')");
	}

//DATOS DEL PRODUCTO 5
if (!empty($_POST['idproducto5'])){
	$idproducto5=$_POST['idproducto5'];
	$descripcion5=$_POST['descripcion5'];
	
	$peso5=$_POST['peso5'];
	$valor5=$_POST['valor5'];
	$subtotal5=$_POST['subtotal5'];

	//se afecta la existencia del producto 5
	$inicio5=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto5'");
    $datoinicio5=mysqli_fetch_array($inicio5);

    $existencia5= $datoinicio5["existencia"];
   	$existencia5=$existencia5+$peso5;
	$query_existencia5=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia5 WHERE codproducto='$idproducto5'");

	//se agrega detalle de la factura producto 5
	$query_producto5 = mysqli_query($conexion, "INSERT INTO detalledevv (nodevolucionv, 
									nomproducto, cantidad, valorkilo,  subtotal)
									VALUES ('$numerodevolucion','$descripcion5'
									,'$peso5', '$valor5','$subtotal5')");
}



	




	

	

    

   

   

mysqli_close($conexion);   




    

    


    


?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Devolución</title>
	
</head>

<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Recibo de Devolución</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" >
					

					<div class="wd100">
						<h4>Nombre del Cliente</h4>
					</div>

					<tr>
						<th colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></th>
						<td colspan="2"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nomcliente; ?>"></td>
						
					</tr>
					
					
					
					

					<div class="wd100">
						<h4>Detalle de la Devolución</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="1">Total Kilos</th>
					<th colspan="2">Valor de Compra por Kilo</th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


				<?php
					if($peso0 >0)
					{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $prod0; ?>">
					<td colspan="1">
						<input type="text" name="descripcion0" id="descripcion0" readonly="readonly" value="<?php echo $descripcion0; ?>">
					</td>
					
					<td colspan="1">
						<input type="text" name="peso0" id="peso0" readonly="readonly" value="<?php echo $peso0; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor0" id="valor0" readonly="readonly" value="<?php echo $valor0; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal0" id="subtotal0" readonly="readonly" value="<?php echo $subtotal0; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso1 >0)
					{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $prod1; ?>">
					<td colspan="1">
						<input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
					</td>
					
					<td colspan="1">
						<input type="text" name="peso1" id="peso1" readonly="readonly" value="<?php echo $peso1; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor1" id="valor1" readonly="readonly" value="<?php echo $valor1; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal1" id="subtotal1" readonly="readonly" value="<?php echo $subtotal1; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso2 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto2" id="idproducto2" value="<?php echo $prod2; ?>">
					<td colspan="1">
						<input type="text" name="descripcion2" id="descripcion2" readonly="readonly" value="<?php echo $descripcion2; ?>">
					</td>
					
					<td colspan="1">
						<input type="text" name="peso2" id="peso2" readonly="readonly" value="<?php echo $peso2; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor2" id="valor2" readonly="readonly" value="<?php echo $valor2; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal2" id="subtotal2" readonly="readonly" value="<?php echo $subtotal2; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso3 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto3" id="idproducto3" value="<?php echo $prod3; ?>">
					<td colspan="1">
						<input type="text" name="descripcion3" id="descripcion3" readonly="readonly" value="<?php echo $descripcion3; ?>">
					</td>
					
					<td colspan="1">
						<input type="text" name="peso3" id="peso3" readonly="readonly" value="<?php echo $peso3; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor3" id="valor3" readonly="readonly" value="<?php echo $valor3; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal3" id="subtotal3" readonly="readonly" value="<?php echo $subtotal3; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso4 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto4" id="idproducto4" value="<?php echo $prod4; ?>">
					<td colspan="1">
						<input type="text" name="descripcion4" id="descripcion4" readonly="readonly" value="<?php echo $descripcion4; ?>">
					</td>
					
					<td colspan="1">
						<input type="text" name="peso4" id="peso4" readonly="readonly" value="<?php echo $peso4; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor4" id="valor4" readonly="readonly" value="<?php echo $valor4; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal4" id="subtotal4" readonly="readonly" value="<?php echo $subtotal4; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso5 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto5" id="idproducto5" value="<?php echo $prod5; ?>">
					<td colspan="1">
						<input type="text" name="descripcion5" id="descripcion5" readonly="readonly" value="<?php echo $descripcion5; ?>">
					</td>
					
					<td colspan="1">
						<input type="text" name="peso5" id="peso5" readonly="readonly" value="<?php echo $peso5; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor5" id="valor5" readonly="readonly" value="<?php echo $valor5; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal5" id="subtotal5" readonly="readonly" value="<?php echo $subtotal5; ?>">
					</td>
				</tr>
				<?php
				}
				
				?>
	 			
					
					<td colspan="3">
							<label><h1><?php echo "Ajuste   $".$ajuste; ?></h1></label>
					</td>				
					
					
					<td colspan="3">
							<label><h1><?php echo "Total a Devolver   $".$total; ?></h1></label>
					</td>
					
					
				</tr>

				


				

				
			</tbody>
		</table>	

					
		<div class="wd30"><a href="facturadevv_pdf.php" target="_blank">
		<input type="button" class="btn_imp" value="Imprimir POS" />
		</a></div>

		

					<div class="wd30"><input type="button" onclick=" location.href='registro_devolucionc.php'" target="_blank" 
					                value="Realizar Otra Devolución" name="boton" class="btn_procesar"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
