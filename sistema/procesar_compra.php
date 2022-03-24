<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	$nit=0; $nombre=""; $telefono=0; $direccion= "No Tiene"; $remision="";
	
	$idcliente=$_POST['id_cliente'];

	if($_POST['remision']){
		$remision=$_POST['remision'];
	}

	

	$consultaCli=mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente='$idcliente'");
	$resultadoC=mysqli_num_rows($consultaCli);
	
		while($data=mysqli_fetch_array($consultaCli)){
			$nit=$data["nit"];
			$nombre=$data["nombrec"];
			$telefono=$data["telefono"];
			$direccion=$data["direccion"];
		}
	
	$peso01=0; $peso02=0; $peso03=0; $total_peso0=0; $cantidades0="";
	$peso11=0; $peso12=0; $peso13=0; $total_peso1=0; $cantidades1="";
    $peso21=0; $peso22=0; $peso23=0; $total_peso2=0; $cantidades2="";
    $peso31=0; $peso32=0; $peso33=0; $total_peso3=0; $cantidades3="";
    $peso41=0; $peso42=0; $peso43=0; $total_peso4=0; $cantidades4="";
    $peso51=0; $peso52=0; $peso53=0; $total_peso5=0; $cantidades5="";   
    $peso61=0; $peso62=0; $peso63=0; $total_peso6=0; $cantidades6="";
    $peso71=0; $peso72=0; $peso73=0; $total_peso7=0; $cantidades7="";
    $peso81=0; $peso82=0; $peso83=0; $total_peso8=0; $cantidades8="";
    $peso91=0; $peso92=0; $peso93=0; $total_peso9=0; $cantidades9="";
    $pesoA1=0; $pesoA2=0; $pesoA3=0; $total_pesoA=0; $cantidadesA="";
    $pesoB1=0; $pesoB2=0; $pesoB3=0; $total_pesoB=0; $cantidadesB="";
	//echo "$idcliente";

	
	//captura del cero producto
	$prod0=$_POST['cbx_prod0'];
		if($_POST['peso01']){ 
			$peso01=$_POST['peso01'];
			$cantidades0=$peso01;
			$total_peso0=$peso01;
		}
		if($_POST['peso02']){ 
			$peso02=$_POST['peso02'];
			$cantidades0=$cantidades0."+".$peso02;
			$total_peso0=$total_peso0+$peso02;
		}
		if($_POST['peso03']){ 
			$peso03=$_POST['peso03'];
			$cantidades0=$cantidades0."+".$peso03;
			$total_peso0=$total_peso0+$peso03;
		}
	$descripcion0="";
	$valor_compra0=0;

	//captura del primer producto
	$prod1=$_POST['cbx_prod1'];
		if($_POST['peso11']){ 
			$peso11=$_POST['peso11'];
			$cantidades1=$peso11;
			$total_peso1=$peso11;
		}
		if($_POST['peso12']){ 
			$peso12=$_POST['peso12'];
			$cantidades1=$cantidades1."+".$peso12;
			$total_peso1=$total_peso1+$peso12;
		}
		if($_POST['peso13']){ 
			$peso13=$_POST['peso13'];
			$cantidades1=$cantidades1."+".$peso13;
			$total_peso1=$total_peso1+$peso13;
		}
	$descripcion1="";
	$valor_compra1=0;

//captura del segundo producto
	$prod2=$_POST['cbx_prod2'];
		if($_POST['peso21']){ 
			$peso21=$_POST['peso21'];
			$cantidades2=$peso21;
			$total_peso2=$peso21;
		}
		if($_POST['peso22']){ 
			$peso22=$_POST['peso22'];
			$cantidades2=$cantidades2."+".$peso22;
			$total_peso2=$total_peso2+$peso22;
		}
		if($_POST['peso23']){ 
			$peso23=$_POST['peso23'];
			$cantidades2=$cantidades2."+".$peso23;
			$total_peso2=$total_peso2+$peso23;
		}
	$descripcion2="";
	$valor_compra2=0;

    //captura del tercer producto
	    $prod3=$_POST['cbx_prod3'];
		    if($_POST['peso31']){ 
			    $peso31=$_POST['peso31'];
			    $cantidades3=$peso31;
			    $total_peso3=$peso31;
		    }
		    if($_POST['peso32']){ 
			    $peso32=$_POST['peso32'];
			    $cantidades3=$cantidades3."+".$peso32;
			    $total_peso3=$total_peso3+$peso32;
		    }
		    if($_POST['peso33']){ 
			    $peso33=$_POST['peso33'];
			    $cantidades3=$cantidades3."+".$peso33;
			    $total_peso3=$total_peso3+$peso33;
		    }
	    $descripcion3="";
	    $valor_compra3=0;

    //captura del cuarto producto
	        $prod4=$_POST['cbx_prod4'];
		        if($_POST['peso41']){ 
			        $peso41=$_POST['peso41'];
			        $cantidades4=$peso41;
			        $total_peso4=$peso41;
		        }
		        if($_POST['peso42']){ 
			        $peso42=$_POST['peso42'];
			        $cantidades4=$cantidades4."+".$peso42;
			        $total_peso4=$total_peso4+$peso42;
		        }
		        if($_POST['peso43']){ 
			        $peso43=$_POST['peso43'];
			        $cantidades4=$cantidades4."+".$peso43;
			        $total_peso4=$total_peso4+$peso43;
		        }
	        $descripcion4="";
	        $valor_compra4=0;

    //captura del quinto producto
	        $prod5=$_POST['cbx_prod5'];
		        if($_POST['peso51']){ 
			        $peso51=$_POST['peso51'];
			        $cantidades5=$peso51;
			        $total_peso5=$peso51;
		        }
		        if($_POST['peso52']){ 
			        $peso52=$_POST['peso52'];
			        $cantidades5=$cantidades5."+".$peso52;
			        $total_peso5=$total_peso5+$peso52;
		        }
		        if($_POST['peso53']){ 
			        $peso53=$_POST['peso53'];
			        $cantidades5=$cantidades5."+".$peso53;
			        $total_peso5=$total_peso5+$peso53;
		        }
	        $descripcion5="";
	        $valor_compra5=0;

    //captura del sexto producto
	        $prod6=$_POST['cbx_prod6'];
		        if($_POST['peso61']){ 
			        $peso61=$_POST['peso61'];
			        $cantidades6=$peso61;
			        $total_peso6=$peso61;
		        }
		        if($_POST['peso62']){ 
			        $peso62=$_POST['peso62'];
			        $cantidades6=$cantidades6."+".$peso62;
			        $total_peso6=$total_peso6+$peso62;
		        }
		        if($_POST['peso63']){ 
			        $peso63=$_POST['peso63'];
			        $cantidades6=$cantidades6."+".$peso63;
			        $total_peso6=$total_peso6+$peso63;
		        }
	        $descripcion6="";
	        $valor_compra6=0;


    //captura del septimo producto
	        $prod7=$_POST['cbx_prod7'];
		        if($_POST['peso71']){ 
			        $peso71=$_POST['peso71'];

			        $cantidades7=$peso71;
			        $total_peso7=$peso71;
		        }
		        if($_POST['peso72']){ 
			        $peso72=$_POST['peso72'];
			        $cantidades7=$cantidades7."+".$peso72;
			        $total_peso7=$total_peso7+$peso72;
		        }
		        if($_POST['peso73']){ 
			        $peso73=$_POST['peso73'];
			        $cantidades7=$cantidades7."+".$peso73;
			        $total_peso7=$total_peso7+$peso73;
		        }
	        $descripcion7="";
	        $valor_compra7=0;


    //captura del octavo producto
	        $prod8=$_POST['cbx_prod8'];
		        if($_POST['peso81']){ 
			        $peso81=$_POST['peso81'];

			        $cantidades8=$peso81;
			        $total_peso8=$peso81;
		        }
		        if($_POST['peso82']){ 
			        $peso82=$_POST['peso82'];
			        $cantidades8=$cantidades8."+".$peso82;
			        $total_peso8=$total_peso8+$peso82;
		        }
		        if($_POST['peso83']){ 
			        $peso83=$_POST['peso83'];
			        $cantidades8=$cantidades8."+".$peso83;
			        $total_peso8=$total_peso8+$peso83;
		        }
	        $descripcion8="";
	        $valor_compra8=0;

    //captura del noveno producto
	        $prod9=$_POST['cbx_prod9'];
		        if($_POST['peso91']){ 
			        $peso91=$_POST['peso91'];

			        $cantidades9=$peso91;
			        $total_peso9=$peso91;
		        }
		        if($_POST['peso92']){ 
			        $peso92=$_POST['peso92'];
			        $cantidades9=$cantidades9."+".$peso92;
			        $total_peso9=$total_peso9+$peso92;
		        }
		        if($_POST['peso93']){ 
			        $peso93=$_POST['peso93'];
			        $cantidades9=$cantidades9."+".$peso93;
			        $total_peso9=$total_peso9+$peso93;
		        }
	        $descripcion9="";
	        $valor_compra9=0;

    //captura del A producto
	        $prodA=$_POST['cbx_prodA'];
		        if($_POST['pesoA1']){ 
			        $pesoA1=$_POST['pesoA1'];

			        $cantidadesA=$pesoA1;
			        $total_pesoA=$pesoA1;
		        }
		        if($_POST['pesoA2']){ 
			        $pesoA2=$_POST['pesoA2'];
			        $cantidadesA=$cantidadesA."+".$pesoA2;
			        $total_pesoA=$total_pesoA+$pesoA2;
		        }
		        if($_POST['pesoA3']){ 
			        $pesoA3=$_POST['pesoA3'];
			        $cantidadesA=$cantidadesA."+".$pesoA3;
			        $total_pesoA=$total_pesoA+$pesoA3;
		        }
	        $descripcionA="";
	        $valor_compraA=0;

     //captura del B producto
	        $prodB=$_POST['cbx_prodB'];
		        if($_POST['pesoB1']){ 
			        $pesoB1=$_POST['pesoB1'];

			        $cantidadesB=$pesoB1;
			        $total_pesoB=$pesoB1;
		        }
		        if($_POST['pesoB2']){ 
			        $pesoB2=$_POST['pesoB2'];
			        $cantidadesB=$cantidadesB."+".$pesoB2;
			        $total_pesoB=$total_pesoB+$pesoB2;
		        }
		        if($_POST['pesoB3']){ 
			        $pesoB3=$_POST['pesoB3'];
			        $cantidadesB=$cantidadesB."+".$pesoB3;
			        $total_pesoB=$total_pesoB+$pesoB3;
		        }
	        $descripcionB="";
	        $valor_compraB=0;

	
	
//consulta cero producto
$consulta0=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod0'");
$resultado0=mysqli_num_rows($consulta0);
	
		while($data=mysqli_fetch_array($consulta0)){
			$descripcion0=$data["descripcion"];
			$valor_compra0=$data["precio_compra"];
		}

//consulta primer producto
$consulta1=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod1'");
$resultado1=mysqli_num_rows($consulta1);
	
		while($data=mysqli_fetch_array($consulta1)){
			$descripcion1=$data["descripcion"];
			$valor_compra1=$data["precio_compra"];
		}

//consulta segundo producto
$consulta2=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod2'");
$resultado2=mysqli_num_rows($consulta2);
	
		while($data=mysqli_fetch_array($consulta2)){
			$descripcion2=$data["descripcion"];
			$valor_compra2=$data["precio_compra"];
		}

//consulta tercer producto
$consulta3=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod3'");
$resultado3=mysqli_num_rows($consulta3);
	
		while($data=mysqli_fetch_array($consulta3)){
			$descripcion3=$data["descripcion"];
			$valor_compra3=$data["precio_compra"];
		}

//consulta cuarto producto
$consulta4=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod4'");
$resultado4=mysqli_num_rows($consulta4);
	
		while($data=mysqli_fetch_array($consulta4)){
			$descripcion4=$data["descripcion"];
			$valor_compra4=$data["precio_compra"];
		}

//consulta quinto producto
$consulta5=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod5'");
$resultado5=mysqli_num_rows($consulta5);
	
		while($data=mysqli_fetch_array($consulta5)){
			$descripcion5=$data["descripcion"];
			$valor_compra5=$data["precio_compra"];
		}

//consulta sexto producto
$consulta6=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod6'");
$resultado6=mysqli_num_rows($consulta6);
	
		while($data=mysqli_fetch_array($consulta6)){
			$descripcion6=$data["descripcion"];
			$valor_compra6=$data["precio_compra"];
		}

//consulta septimo producto
$consulta7=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod7'");
$resultado7=mysqli_num_rows($consulta7);
	
		while($data=mysqli_fetch_array($consulta7)){
			$descripcion7=$data["descripcion"];
			$valor_compra7=$data["precio_compra"];
		}

//consulta octavo producto
$consulta8=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod8'");
$resultado8=mysqli_num_rows($consulta8);
	
		while($data=mysqli_fetch_array($consulta8)){
			$descripcion8=$data["descripcion"];
			$valor_compra8=$data["precio_compra"];
		}

//consulta noveno producto
$consulta9=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod9'");
$resultado9=mysqli_num_rows($consulta9);
	
		while($data=mysqli_fetch_array($consulta9)){
			$descripcion9=$data["descripcion"];
			$valor_compra9=$data["precio_compra"];
		}

//consulta A producto
$consultaA=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prodA'");
$resultadoA=mysqli_num_rows($consultaA);
	
		while($data=mysqli_fetch_array($consultaA)){
			$descripcionA=$data["descripcion"];
			$valor_compraA=$data["precio_compra"];
		}

//consulta B producto
$consultaB=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prodB'");
$resultadoB=mysqli_num_rows($consultaB);
	
		while($data=mysqli_fetch_array($consultaB)){
			$descripcionB=$data["descripcion"];
			$valor_compraB=$data["precio_compra"];
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
	<title>Procesar Compra</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Procesar Compra</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="calcular_Compra.php" method="POST">
			
			
					<div class="wd50">
						<h4>Nombre del Cliente</h4>
					</div>
					

					<tr>
						<td colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></td>
						<td colspan="1"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nombre; ?>"></td>
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


					<tr>
						
						<div class="wd50">
							<h4>Nuevo Cliente</h4>
						</div>
						<td colspan="1"><input type="text" name="nuevocliente" id="nuevocliente"  ></td>
						
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
					if($peso01 >0 || $peso02 || $peso03)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $prod0; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion0" id="descripcion0" readonly="readonly" value="<?php echo $descripcion0; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades0" id="cantidades0" readonly="readonly" value="<?php echo $cantidades0; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso0" id="total_peso0" readonly="readonly" value="<?php echo $total_peso0; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra0" id="valor_compra0" value="<?php echo $valor_compra0; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal0" id="subtotal0" readonly="readonly" value="<?php echo $total_peso0*$valor_compra0; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                    <?php
					if($peso11 >0 || $peso12 || $peso13)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $prod1; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades1" id="cantidades1" readonly="readonly" value="<?php echo $cantidades1; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso1" id="total_peso1" readonly="readonly" value="<?php echo $total_peso1; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra1" id="valor_compra1" value="<?php echo $valor_compra1; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal1" id="subtotal1" readonly="readonly" value="<?php echo $total_peso1*$valor_compra1; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso21 >0 || $peso22 || $peso23)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto2" id="idproducto2" value="<?php echo $prod2; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion2" id="descripcion2" readonly="readonly" value="<?php echo $descripcion2; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades2" id="cantidades2" readonly="readonly" value="<?php echo $cantidades2; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso2" id="total_peso2" readonly="readonly" value="<?php echo $total_peso2; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra2" id="valor_compra2" value="<?php echo $valor_compra2; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal2" id="subtotal2" readonly="readonly" value="<?php echo $total_peso2*$valor_compra2; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                    <?php
					if($peso31 >0 || $peso32 || $peso33)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto3" id="idproducto3" value="<?php echo $prod3; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion3" id="descripcion3" readonly="readonly" value="<?php echo $descripcion3; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades3" id="cantidades3" readonly="readonly" value="<?php echo $cantidades3; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso3" id="total_peso3" readonly="readonly" value="<?php echo $total_peso3; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra3" id="valor_compra3" value="<?php echo $valor_compra3; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal3" id="subtotal3" readonly="readonly" value="<?php echo $total_peso3*$valor_compra3; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso41 >0 || $peso42 || $peso43)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto4" id="idproducto4" value="<?php echo $prod4; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion4" id="descripcion4" readonly="readonly" value="<?php echo $descripcion4; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades4" id="cantidades4" readonly="readonly" value="<?php echo $cantidades4; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso4" id="total_peso4" readonly="readonly" value="<?php echo $total_peso4; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra4" id="valor_compra4" value="<?php echo $valor_compra4; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal4" id="subtotal4" readonly="readonly" value="<?php echo $total_peso4*$valor_compra4; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                     <?php
					if($peso51 >0 || $peso52 || $peso53)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto5" id="idproducto5" value="<?php echo $prod5; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion5" id="descripcion5" readonly="readonly" value="<?php echo $descripcion5; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades5" id="cantidades5" readonly="readonly" value="<?php echo $cantidades5; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso5" id="total_peso5" readonly="readonly" value="<?php echo $total_peso5; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra5" id="valor_compra5" value="<?php echo $valor_compra5; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal5" id="subtotal5" readonly="readonly" value="<?php echo $total_peso5*$valor_compra5; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                     <?php
					if($peso61 >0 || $peso62 || $peso63)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto6" id="idproducto6" value="<?php echo $prod6; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion6" id="descripcion6" readonly="readonly" value="<?php echo $descripcion6; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades6" id="cantidades6" readonly="readonly" value="<?php echo $cantidades6; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso6" id="total_peso6" readonly="readonly" value="<?php echo $total_peso6; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra6" id="valor_compra6" value="<?php echo $valor_compra6; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal6" id="subtotal6" readonly="readonly" value="<?php echo $total_peso6*$valor_compra6; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso71 >0 || $peso72 || $peso73)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto7" id="idproducto7" value="<?php echo $prod7; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion7" id="descripcion7" readonly="readonly" value="<?php echo $descripcion7; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades7" id="cantidades7" readonly="readonly" value="<?php echo $cantidades7; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso7" id="total_peso7" readonly="readonly" value="<?php echo $total_peso7; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra7" id="valor_compra7" value="<?php echo $valor_compra7; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal7" id="subtotal7" readonly="readonly" value="<?php echo $total_peso7*$valor_compra7; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                     <?php
					if($peso81 >0 || $peso82 || $peso83)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto8" id="idproducto8" value="<?php echo $prod8; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion8" id="descripcion8" readonly="readonly" value="<?php echo $descripcion8; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades8" id="cantidades8" readonly="readonly" value="<?php echo $cantidades8; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso8" id="total_peso8" readonly="readonly" value="<?php echo $total_peso8; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra8" id="valor_compra8" value="<?php echo $valor_compra8; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal8" id="subtotal8" readonly="readonly" value="<?php echo $total_peso8*$valor_compra8; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso91 >0 || $peso92 || $peso93)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto9" id="idproducto9" value="<?php echo $prod9; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion9" id="descripcion9" readonly="readonly" value="<?php echo $descripcion9; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidades9" id="cantidades9" readonly="readonly" value="<?php echo $cantidades9; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_peso9" id="total_peso9" readonly="readonly" value="<?php echo $total_peso9; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compra9" id="valor_compra9" value="<?php echo $valor_compra9; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal9" id="subtotal9" readonly="readonly" value="<?php echo $total_peso9*$valor_compra9; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>



                    <?php
					if($pesoA1 >0 || $pesoA2 || $pesoA3)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproductoA" id="idproductoA" value="<?php echo $prodA; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionA" id="descripcionA" readonly="readonly" value="<?php echo $descripcionA; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidadesA" id="cantidadesA" readonly="readonly" value="<?php echo $cantidadesA; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_pesoA" id="total_pesoA" readonly="readonly" value="<?php echo $total_pesoA; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compraA" id="valor_compraA" value="<?php echo $valor_compraA; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalA" id="subtotalA" readonly="readonly" value="<?php echo $total_pesoA*$valor_compraA; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                     <?php
					if($pesoB1 >0 || $pesoB2 || $pesoB3)
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproductoB" id="idproductoB" value="<?php echo $prodB; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionB" id="descripcionB" readonly="readonly" value="<?php echo $descripcionB; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="cantidadesB" id="cantidadesB" readonly="readonly" value="<?php echo $cantidadesB; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="total_pesoB" id="total_pesoB" readonly="readonly" value="<?php echo $total_pesoB; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_compraB" id="valor_compraB" value="<?php echo $valor_compraB; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalB" id="subtotalB" readonly="readonly" value="<?php echo $total_pesoB*$valor_compraB; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

				

				

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Calcular Compra"></div>
				
					<div class="wd30"><input type="reset" class="btn_limpiar" value="Recuperar Valores de Compra"></div>
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Compra" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
