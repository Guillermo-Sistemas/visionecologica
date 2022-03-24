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

	
	

	if (!empty($_POST['remision']))
		$remision=$_POST['remision'];

	$total=$_POST['total'];
    $ajuste=$_POST['ajuste'];
	$qajuste=0;

	date_default_timezone_set('America/Bogota');
	$fechaactual2 = Date('Y-m-d H:i:s', time());

	if (!empty($_POST['credito'])){ 
		$tipo=2;

		//echo $tipo."sipi";

		//SE GENERA FACTURA CREDITO
		$query_factura=mysqli_query($conexion, "INSERT INTO factura (fecha, usuario, codcliente, ajuste, totalfactura, tipofactura, remision)
		VALUES ('$fechaactual2','$iduser','$idcliente','$ajuste', '$total', '$tipo', '$remision')");
		$bandera=1;

		//ultima factura
		$numfactura=mysqli_query($conexion, "SELECT MAX(nofactura) from factura");
		$numfactura1= mysqli_fetch_array($numfactura);
		$numerofactura=$numfactura1[0];

	}else{ 
	//SE GENERA FACTURA
		$query_factura=mysqli_query($conexion, "INSERT INTO factura (fecha, usuario, codcliente, ajuste, totalfactura, remision)
                                VALUES ('$fechaactual2','$iduser','$idcliente','$ajuste', '$total', '$remision')");
								
		//ultima factura
		$numfactura=mysqli_query($conexion, "SELECT MAX(nofactura) from factura");
		$numfactura1= mysqli_fetch_array($numfactura);
		$numerofactura=$numfactura1[0];



		//SE MODIFICA EL EGRESO
		$inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
		$inicio1= mysqli_fetch_array($inicio);
		$controlinicial=$inicio1[0];

		$inicio2=mysqli_query($conexion, "SELECT egresos, ajuste from cuadre WHERE idcuadre='$controlinicial'");
		$datoinicio=mysqli_fetch_array($inicio2);

		$egresos= $datoinicio["egresos"];
		$egresos=$egresos+$total;

		$qajuste= $datoinicio["ajuste"];
		$qajuste=$qajuste+$ajuste;

		$query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET egresos=$egresos, ajuste=$qajuste WHERE idcuadre='$controlinicial'"); 
	}

	
	$total=number_format($total, 0, ",", ".");
		
	

	//variables
	$idproducto0=0; $descripcion0=""; $cantidades0=0; $peso0=0; $valor0=0; $subtotal0=0;
	$idproducto1=0; $descripcion1=""; $cantidades1=0; $peso1=0; $valor1=0; $subtotal1=0;
	$idproducto2=0; $descripcion2=""; $cantidades2=0; $peso2=0; $valor2=0; $subtotal2=0;
	$idproducto3=0; $descripcion3=""; $cantidades3=0; $peso3=0; $valor3=0; $subtotal3=0;
	$idproducto4=0; $descripcion4=""; $cantidades4=0; $peso4=0; $valor4=0; $subtotal4=0;
	$idproducto5=0; $descripcion5=""; $cantidades5=0; $peso5=0; $valor5=0; $subtotal5=0;
	$idproducto6=0; $descripcion6=""; $cantidades6=0; $peso6=0; $valor6=0; $subtotal6=0;
	$idproducto7=0; $descripcion7=""; $cantidades7=0; $peso7=0; $valor7=0; $subtotal7=0;
    $idproducto8=0; $descripcion8=""; $cantidades8=0; $peso8=0; $valor8=0; $subtotal8=0;
    $idproducto9=0; $descripcion9=""; $cantidades9=0; $peso9=0; $valor9=0; $subtotal9=0;
    $idproductoA=0; $descripcionA=""; $cantidadesA=0; $pesoA=0; $valorA=0; $subtotalA=0;
    $idproductoB=0; $descripcionB=""; $cantidadesB=0; $pesoB=0; $valorB=0; $subtotalB=0;
	
	//DATOS DEL PRODUCTO 0
	if (!empty($_POST['idproducto0'])){
		$idproducto0=$_POST['idproducto0'];
		$descripcion0=$_POST['descripcion0'];
		$cantidades0=$_POST['cantidad0'];
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
		$query_producto0 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
						nomproducto, cantidades, cantidad, valorkilo,  subtotal)
						VALUES ('$numerofactura','$descripcion0', '$cantidades0'
						,'$peso0', '$valor0','$subtotal0')");
	}

	//DATOS DEL PRODUCTO 1
	if (!empty($_POST['idproducto1'])){
		$idproducto1=$_POST['idproducto1'];
		$descripcion1=$_POST['descripcion1'];
		$cantidades1=$_POST['cantidad1'];
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
		$query_producto1 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
							nomproducto, cantidades, cantidad, valorkilo,  subtotal)
							VALUES ('$numerofactura','$descripcion1', '$cantidades1'
							,'$peso1', '$valor1','$subtotal1')");
	}

    //DATOS DEL PRODUCTO 2
	if (!empty($_POST['idproducto2'])){
		$idproducto2=$_POST['idproducto2'];
		$descripcion2=$_POST['descripcion2'];
		$cantidades2=$_POST['cantidad2'];
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
		$query_producto2 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
						nomproducto, cantidades, cantidad, valorkilo,  subtotal)
						VALUES ('$numerofactura','$descripcion2', '$cantidades2'
						,'$peso2', '$valor2','$subtotal2')");
	}


     //DATOS DEL PRODUCTO 3
	if (!empty($_POST['idproducto3'])){
		$idproducto3=$_POST['idproducto3'];
		$descripcion3=$_POST['descripcion3'];
		$cantidades3=$_POST['cantidad3'];
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
		$query_producto3 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
						nomproducto, cantidades, cantidad, valorkilo,  subtotal)
						VALUES ('$numerofactura','$descripcion3', '$cantidades3'
						,'$peso3', '$valor3','$subtotal3')");
	}


     //DATOS DEL PRODUCTO 4
	
	 if (!empty($_POST['idproducto4'])){
		$idproducto4=$_POST['idproducto4'];
		$descripcion4=$_POST['descripcion4'];
		$cantidades4=$_POST['cantidad4'];
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
		$query_producto4 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
					nomproducto, cantidades, cantidad, valorkilo,  subtotal)
					VALUES ('$numerofactura','$descripcion4', '$cantidades4'
					,'$peso4', '$valor4','$subtotal4')");
	}

//DATOS DEL PRODUCTO 5
if (!empty($_POST['idproducto5'])){
	$idproducto5=$_POST['idproducto5'];
	$descripcion5=$_POST['descripcion5'];
	$cantidades5=$_POST['cantidad5'];
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
	$query_producto5 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcion5', '$cantidades5'
									,'$peso5', '$valor5','$subtotal5')");
}


//DATOS DEL PRODUCTO 6
if (!empty($_POST['idproducto6'])){
	$idproducto6=$_POST['idproducto6'];
	$descripcion6=$_POST['descripcion6'];
	$cantidades6=$_POST['cantidad6'];
	$peso6=$_POST['peso6'];
	$valor6=$_POST['valor6'];
	$subtotal6=$_POST['subtotal6'];

	//se afecta la existencia del producto 6
	$inicio6=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto6'");
    $datoinicio6=mysqli_fetch_array($inicio6);

    $existencia6= $datoinicio6["existencia"];
   	$existencia6=$existencia6+$peso6;
	$query_existencia6=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia6 WHERE codproducto='$idproducto6'");

	//se agrega detalle de la factura producto 6
	$query_producto6 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcion6', '$cantidades6'
									,'$peso6', '$valor6','$subtotal6')");
}

//DATOS DEL PRODUCTO 7
if (!empty($_POST['idproducto7'])){
	$idproducto7=$_POST['idproducto7'];
	$descripcion7=$_POST['descripcion7'];
	$cantidades7=$_POST['cantidad7'];
	$peso7=$_POST['peso7'];
	$valor7=$_POST['valor7'];
	$subtotal7=$_POST['subtotal7'];

	//se afecta la existencia del producto 7
	$inicio7=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto7'");
    $datoinicio7=mysqli_fetch_array($inicio7);

    $existencia7= $datoinicio7["existencia"];
   	$existencia7=$existencia7+$peso7;
	$query_existencia7=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia7 WHERE codproducto='$idproducto7'");

	//se agrega detalle de la factura producto 7
	$query_producto7 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcion7', '$cantidades7'
									,'$peso7', '$valor7','$subtotal7')");
}


//DATOS DEL PRODUCTO 8
if (!empty($_POST['idproducto8'])){
	$idproducto8=$_POST['idproducto8'];
	$descripcion8=$_POST['descripcion8'];
	$cantidades8=$_POST['cantidad8'];
	$peso8=$_POST['peso8'];
	$valor8=$_POST['valor8'];
	$subtotal8=$_POST['subtotal8'];

	//se afecta la existencia del producto 8
	$inicio8=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto8'");
    $datoinicio8=mysqli_fetch_array($inicio8);

    $existencia8= $datoinicio8["existencia"];
   	$existencia8=$existencia8+$peso8;
	$query_existencia8=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia8 WHERE codproducto='$idproducto8'");

	//se agrega detalle de la factura producto 8
	$query_producto8 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcion8', '$cantidades8'
									,'$peso8', '$valor8','$subtotal8')");
}


//DATOS DEL PRODUCTO 9
if (!empty($_POST['idproducto9'])){
	$idproducto9=$_POST['idproducto9'];
	$descripcion9=$_POST['descripcion9'];
	$cantidades9=$_POST['cantidad9'];
	$peso9=$_POST['peso9'];
	$valor9=$_POST['valor9'];
	$subtotal9=$_POST['subtotal9'];

	//se afecta la existencia del producto 9
	$inicio9=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproducto9'");
    $datoinicio9=mysqli_fetch_array($inicio9);

    $existencia9= $datoinicio9["existencia"];
   	$existencia9=$existencia9+$peso9;
	$query_existencia9=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia9 WHERE codproducto='$idproducto9'");

	//se agrega detalle de la factura producto 9
	$query_producto9 = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcion9', '$cantidades9'
									,'$peso9', '$valor9','$subtotal9')");
}


//DATOS DEL PRODUCTO A
if (!empty($_POST['idproductoA'])){
	$idproductoA=$_POST['idproductoA'];
	$descripcionA=$_POST['descripcionA'];
	$cantidadesA=$_POST['cantidadA'];
	$pesoA=$_POST['pesoA'];
	$valorA=$_POST['valorA'];
	$subtotalA=$_POST['subtotalA'];

	//se afecta la existencia del producto A
	$inicioA=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoA'");
    $datoinicioA=mysqli_fetch_array($inicioA);

    $existenciaA= $datoinicioA["existencia"];
   	$existenciaA=$existenciaA+$pesoA;
	$query_existenciaA=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaA WHERE codproducto='$idproductoA'");

	//se agrega detalle de la factura producto A
	$query_productoA = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcionA', '$cantidadesA'
									,'$pesoA', '$valorA','$subtotalA')");
}


//DATOS DEL PRODUCTO B
if (!empty($_POST['idproductoB'])){
	$idproductoB=$_POST['idproductoB'];
	$descripcionB=$_POST['descripcionB'];
	$cantidadesB=$_POST['cantidadB'];
	$pesoB=$_POST['pesoB'];
	$valorB=$_POST['valorB'];
	$subtotalB=$_POST['subtotalB'];

	//se afecta la existencia del producto B
	$inicioB=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$idproductoB'");
    $datoinicioB=mysqli_fetch_array($inicioB);

    $existenciaB= $datoinicioB["existencia"];
   	$existenciaB=$existenciaB+$pesoB;
	$query_existenciaB=mysqli_query($conexion, "UPDATE producto SET existencia=$existenciaB WHERE codproducto='$idproductoB'");

	//se agrega detalle de la factura producto B
	$query_productoB = mysqli_query($conexion, "INSERT INTO detallefactura (nofactura, 
									nomproducto, cantidades, cantidad, valorkilo,  subtotal)
									VALUES ('$numerofactura','$descripcionB', '$cantidadesB'
									,'$pesoB', '$valorB','$subtotalB')");
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
	<title>Comprar</title>
	
</head>

<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Recibo de Compra</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" >
					

					<div class="wd100">
						<h4>Nombre del Cliente</h4>
					</div>

					<tr>
						<th colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></th>
						<td colspan="2"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nomcliente; ?>"></td>
						<?php
						if($remision!=""){?>
						<div class="wd50">
							<h4>Remisión</h4>
						</div>
						<td colspan="1"><input type="text" name="remision" id="remision" readonly="readonly" value="<?php echo $remision; ?>"></td>
						<?php
						}
						?>	
					</tr>
					
					
					
					

					<div class="wd100">
						<h4>Detalle de la Compra</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="1">Cantidades</th>
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
						<input type="text" name="cantidad0" id="cantidad0" readonly="readonly" value="<?php echo $cantidades0; ?>">
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
						<input type="text" name="cantidad1" id="cantidad1" readonly="readonly" value="<?php echo $cantidades1; ?>">
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
						<input type="text" name="cantidad2" id="cantidad2" readonly="readonly" value="<?php echo $cantidades2; ?>">
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
						<input type="text" name="cantidad3" id="cantidad3" readonly="readonly" value="<?php echo $cantidades3; ?>">
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
						<input type="text" name="cantidad4" id="cantidad4" readonly="readonly" value="<?php echo $cantidades4; ?>">
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
						<input type="text" name="cantidad5" id="cantidad5" readonly="readonly" value="<?php echo $cantidades5; ?>">
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
				if($peso6 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto6" id="idproducto6" value="<?php echo $prod6; ?>">
					<td colspan="1">
						<input type="text" name="descripcion6" id="descripcion6" readonly="readonly" value="<?php echo $descripcion6; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="cantidad6" id="cantidad6" readonly="readonly" value="<?php echo $cantidades6; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="peso6" id="peso6" readonly="readonly" value="<?php echo $peso6; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor6" id="valor6" readonly="readonly" value="<?php echo $valor6; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal6" id="subtotal6" readonly="readonly" value="<?php echo $subtotal6; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso7 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto7" id="idproducto7" value="<?php echo $prod7; ?>">
					<td colspan="1">
						<input type="text" name="descripcion7" id="descripcion7" readonly="readonly" value="<?php echo $descripcion7; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="cantidad7" id="cantidad7" readonly="readonly" value="<?php echo $cantidades7; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="peso7" id="peso7" readonly="readonly" value="<?php echo $peso7; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor7" id="valor7" readonly="readonly" value="<?php echo $valor7; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal7" id="subtotal7" readonly="readonly" value="<?php echo $subtotal7; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso8 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto8" id="idproducto8" value="<?php echo $prod8; ?>">
					<td colspan="1">
						<input type="text" name="descripcion8" id="descripcion8" readonly="readonly" value="<?php echo $descripcion8; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="cantidad8" id="cantidad8" readonly="readonly" value="<?php echo $cantidades8; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="peso8" id="peso8" readonly="readonly" value="<?php echo $peso8; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor8" id="valor8" readonly="readonly" value="<?php echo $valor8; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal8" id="subtotal8" readonly="readonly" value="<?php echo $subtotal8; ?>">
					</td>
				</tr>
				<?php
				}
				if($peso9 >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproducto9" id="idproducto9" value="<?php echo $prod9; ?>">
					<td colspan="1">
						<input type="text" name="descripcion9" id="descripcion9" readonly="readonly" value="<?php echo $descripcion9; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="cantidad9" id="cantidad9" readonly="readonly" value="<?php echo $cantidades9; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="peso9" id="peso9" readonly="readonly" value="<?php echo $peso9; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor9" id="valor9" readonly="readonly" value="<?php echo $valor9; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal9" id="subtotal9" readonly="readonly" value="<?php echo $subtotal9; ?>">
					</td>
				</tr>
				<?php
				}
				if($pesoA >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproductoA" id="idproductoA" value="<?php echo $prodA; ?>">
					<td colspan="1">
						<input type="text" name="descripcionA" id="descripcionA" readonly="readonly" value="<?php echo $descripcionA; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="cantidadA" id="cantidadA" readonly="readonly" value="<?php echo $cantidadesA; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="pesoA" id="pesoA" readonly="readonly" value="<?php echo $pesoA; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valorA" id="valorA" readonly="readonly" value="<?php echo $valorA; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotalA" id="subtotalA" readonly="readonly" value="<?php echo $subtotalA; ?>">
					</td>
				</tr>
				<?php
				}
				if($pesoA >0)
				{
				?>
	 			<tr>
				 	<input type="hidden" name="idproductoB" id="idproductoB" value="<?php echo $prodB; ?>">
					<td colspan="1">
						<input type="text" name="descripcionB" id="descripcionB" readonly="readonly" value="<?php echo $descripcionB; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="cantidadB" id="cantidadB" readonly="readonly" value="<?php echo $cantidadesB; ?>">
					</td>
					<td colspan="1">
						<input type="text" name="pesoB" id="pesoB" readonly="readonly" value="<?php echo $pesoB; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valorB" id="valorB" readonly="readonly" value="<?php echo $valorB; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotalB" id="subtotalB" readonly="readonly" value="<?php echo $subtotalB; ?>">
					</td>
				</tr>
				<?php
				}
				?>


				
				<tr>
					<td colspan="1">
						<h1><input type="hidden" name="total" id="total" readonly="readonly" value="<?php echo $total; ?>"></h1>
					</td>
					<td colspan="1">
						<h1><input type="hidden" name="ajuste" id="ajuste" readonly="readonly" value="<?php echo $ajuste; ?>"></h1>
					</td>
				</tr>
				<tr>
					
					<td colspan="3">
							<label><h1><?php echo "Ajuste   $".$ajuste; ?></h1></label>
					</td>				
					
					<?php
					if ($bandera==1){ 
					?>
					<td colspan="3">
							<label><h1><?php echo "Compra a Crédito   $".$total; ?></h1></label>
					</td>
					<?php
					}else{
					?>
					<td colspan="3">
							<label><h1><?php echo "Total a Pagar   $".$total; ?></h1></label>
					</td>
					<?php
					}
					?>
					
				</tr>

				


				

				
			</tbody>
		</table>	

					
		<div class="wd30"><a href="factura_pdf.php" target="_blank">
		<input type="button" class="btn_imp" value="Imprimir POS" />
		</a></div>

		<div class="wd30"><a href="factura2_pdf.php" target="_blank">
		<input type="button" class="btn_imp2" value="Imprimir Recibo" />
		</a></div>

					<div class="wd30"><input type="button" onclick=" location.href='nueva_compra.php'" target="_blank" 
					                value="Realizar Otra Compra" name="boton" class="btn_procesar"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
