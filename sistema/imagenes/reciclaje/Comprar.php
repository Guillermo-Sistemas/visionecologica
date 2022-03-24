<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 


	//$idcliente=$_POST['cbx_cliente'];

	//echo "$idcliente";

	$nit="";
	$nombre="";
	$telefono="";
	$direccion="";

	$peso1=0;
	$peso2=0;
	$peso3=0;
	$peso4=0;
	$peso5=0;
	$peso6=0;
	$peso7=0;
	$peso8=0;

	$subtotal1=0;
	$subtotal2=0;
	$subtotal3=0;
	$subtotal4=0;
	$subtotal5=0;
	$subtotal6=0;
	$subtotal7=0;
	$subtotal8=0;

	if (!empty($_POST['total'])){ 
		//$prod1=$_POST['descripcion1'];
			$total=$_POST['total'];


			/*$query7=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion7'");
			$result7=mysqli_num_rows($query7);
			$valor7=mysqli_fetch_array($query7);
		
			$temporal7=$valor7[0];
			
			  $temporal7=$temporal7+$peso7;
		
			$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal7 WHERE descripcion='$descripcion7'");*/


			$cuadre=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
            $bandercuadre= mysqli_fetch_array($cuadre);
    		$controlcuadre=$bandercuadre[0];

			echo"$controlcuadre";


			$query7=mysqli_query($conexion, "SELECT egresos FROM cuadre WHERE idcuadre=$controlcuadre");
			$result7=mysqli_num_rows($query7);
			$valor7=mysqli_fetch_array($query7);
		
			$temporal7=$valor7[0];
			
			  $temporal7=$temporal7+$total;
		
			$consulta3=mysqli_query($conexion,"UPDATE cuadre SET egresos=$temporal7 WHERE idcuadre=$controlcuadre");

	}


	if (!empty($_POST['peso1'])){ 
	//$prod1=$_POST['descripcion1'];
		$peso1=$_POST['peso1'];
		$descripcion1=$_POST['descripcion1'];
		$valor_compra1=$_POST['valor_compra1'];
		$subtotal1=$_POST['subtotal1'];

	//dede aca
		//echo"$total";
		//echo"$descripcion1";
		//echo"$peso1";

	$query=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion1'");
	$result=mysqli_num_rows($query);
	$valor=mysqli_fetch_array($query);

	$temporal=$valor[0];
    
  	$temporal=$temporal+$peso1;

	$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal WHERE descripcion='$descripcion1'");  

    /*$consulta4="select MAX(idcuadre) from cuadre";
    $resultado4=mysqli_query($conexion,$consulta4);
    mysqli_data_seek ($resultado4, 0);
    $banderabase= mysqli_fetch_array($resultado4);
    $controlbase=$banderabase[0];
    
     $consulta5="SELECT egresos FROM cuadre WHERE idcuadre='$controlbase'";
    $resultado5=mysqli_query($conexion,$consulta5);
    mysqli_data_seek ($resultado5, 0);
    $valor= mysqli_fetch_array($resultado5);
    $temporal=$valor[0];
    
    $compra=$temporal+$subpagar1;
    
    $consulta6="UPDATE bases SET compra_diaria='$compra' WHERE id_base='$controlbase'";
    $resultado6=mysqli_query($conexion,$consulta6);





	hasta aca*/


	}

	if (!empty($_POST['peso2'])){
		$peso2=$_POST['peso2'];
		$descripcion2=$_POST['descripcion2'];
		$valor_compra2=$_POST['valor_compra2'];
		$subtotal2=$_POST['subtotal2'];

		$query2=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion2'");
		$result2=mysqli_num_rows($query2);
		$valor2=mysqli_fetch_array($query2);
	
		$temporal2=$valor2[0];
		
		  $temporal2=$temporal2+$peso2;
	
		$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal2 WHERE descripcion='$descripcion2'");
	}

	if (!empty($_POST['peso3'])){ 
		//$prod1=$_POST['descripcion1'];
			$peso3=$_POST['peso3'];
			$descripcion3=$_POST['descripcion3'];
			$valor_compra3=$_POST['valor_compra3'];
			$subtotal3=$_POST['subtotal3'];

			$query3=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion3'");
			$result3=mysqli_num_rows($query3);
			$valor3=mysqli_fetch_array($query3);
		
			$temporal3=$valor3[0];
			
			  $temporal3=$temporal3+$peso3;
		
			$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal3 WHERE descripcion='$descripcion3'");
	}
	
	if (!empty($_POST['peso4'])){
			$peso4=$_POST['peso4'];
			$descripcion4=$_POST['descripcion4'];
			$valor_compra4=$_POST['valor_compra4'];
			$subtotal4=$_POST['subtotal4'];

			$query4=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion4'");
			$result4=mysqli_num_rows($query4);
			$valor4=mysqli_fetch_array($query4);
		
			$temporal4=$valor4[0];
			
			  $temporal4=$temporal4+$peso4;
		
			$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal4 WHERE descripcion='$descripcion4'");
	}



	if (!empty($_POST['peso5'])){ 
		//$prod1=$_POST['descripcion1'];
			$peso5=$_POST['peso5'];
			$descripcion5=$_POST['descripcion5'];
			$valor_compra5=$_POST['valor_compra5'];
			$subtotal5=$_POST['subtotal5'];

			$query5=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion5'");
			$result5=mysqli_num_rows($query5);
			$valor5=mysqli_fetch_array($query5);
		
			$temporal5=$valor5[0];
			
			  $temporal5=$temporal5+$peso5;
		
			$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal5 WHERE descripcion='$descripcion5'");
		}
	
		if (!empty($_POST['peso6'])){
			$peso6=$_POST['peso6'];
			$descripcion6=$_POST['descripcion6'];
			$valor_compra6=$_POST['valor_compra6'];
			$subtotal6=$_POST['subtotal6'];

			$query6=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion6'");
			$result6=mysqli_num_rows($query6);
			$valor6=mysqli_fetch_array($query6);
		
			$temporal6=$valor6[0];
			
			  $temporal6=$temporal6+$peso6;
		
			$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal6 WHERE descripcion='$descripcion6'");
		}
	
		if (!empty($_POST['peso7'])){ 
			//$prod1=$_POST['descripcion1'];
				$peso7=$_POST['peso7'];
				$descripcion7=$_POST['descripcion7'];
				$valor_compra7=$_POST['valor_compra7'];
				$subtotal7=$_POST['subtotal7'];

				$query7=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion7'");
				$result7=mysqli_num_rows($query7);
				$valor7=mysqli_fetch_array($query7);
			
				$temporal7=$valor7[0];
				
				  $temporal7=$temporal7+$peso7;
			
				$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal7 WHERE descripcion='$descripcion7'");
		}
		
		if (!empty($_POST['peso8'])){
				$peso8=$_POST['peso8'];
				$descripcion8=$_POST['descripcion8'];
				$valor_compra8=$_POST['valor_compra8'];
				$subtotal8=$_POST['subtotal8'];

				$query8=mysqli_query($conexion, "SELECT existencia FROM producto WHERE descripcion='$descripcion8'");
				$result8=mysqli_num_rows($query8);
				$valor8=mysqli_fetch_array($query8);
			
				$temporal8=$valor8[0];
				
				  $temporal8=$temporal8+$peso8;
			
				$consulta3=mysqli_query($conexion,"UPDATE producto SET existencia=$temporal8 WHERE descripcion='$descripcion8'");
		}



	/*
	$prod2=$_POST['cbx_prod2'];
	$peso2=$_POST['peso2'];
	$descripcion2="";
	$valor_compra2=0;

	$prod3=$_POST['cbx_prod3'];
	$peso3=$_POST['peso3'];
	$descripcion3="";
	$valor_compra3=0;

	$prod4=$_POST['cbx_prod4'];
	$peso4=$_POST['peso4'];
	$descripcion4="";
	$valor_compra4=0;

	$prod5=$_POST['cbx_prod5'];
	$peso5=$_POST['peso5'];
	$descripcion5="";
	$valor_compra5=0;

	$prod6=$_POST['cbx_prod6'];
	$peso6=$_POST['peso6'];
	$descripcion6="";
	$valor_compra6=0;

	$prod7=$_POST['cbx_prod7'];
	$peso7=$_POST['peso7'];
	$descripcion7="";
	$valor_compra7=0;

	$prod8=$_POST['cbx_prod8'];
	$peso8=$_POST['peso8'];
	$descripcion8="";
	$valor_compra8=0;

	//echo "$prod1";

	
	
//DATOS DEL CLIENTE
	$consultaCli=mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente='$idcliente'");
	$resultadoC=mysqli_num_rows($consultaCli);
	
		while($data=mysqli_fetch_array($consultaCli)){
			$nit=$data["nit"];
			$nombre=$data["nombre"];
			$telefono=$data["telefono"];
			$direccion=$data["direccion"];

			
		}

//COMPRA 1

$consulta1=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod1'");
$resultado1=mysqli_num_rows($consulta1);
	
		while($data=mysqli_fetch_array($consulta1)){
			$descripcion1=$data["descripcion"];
			$valor_compra1=$data["precio_compra"];
		}




$consulta2=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod2'");
$resultado2=mysqli_num_rows($consulta2);
		
		while($data=mysqli_fetch_array($consulta2)){
			$descripcion2=$data["descripcion"];
			$valor_compra2=$data["precio_compra"];
		}

$consulta3=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod3'");
$resultado3=mysqli_num_rows($consulta3);
			
				while($data=mysqli_fetch_array($consulta3)){
					$descripcion3=$data["descripcion"];
					$valor_compra3=$data["precio_compra"];
				}
		
$consulta4=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod4'");
$resultado4=mysqli_num_rows($consulta4);
				
				while($data=mysqli_fetch_array($consulta4)){
					$descripcion4=$data["descripcion"];
					$valor_compra4=$data["precio_compra"];
				}

$consulta5=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod5'");
$resultado5=mysqli_num_rows($consulta5);
					
						while($data=mysqli_fetch_array($consulta5)){
							$descripcion5=$data["descripcion"];
							$valor_compra5=$data["precio_compra"];
						}
				
$consulta6=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod6'");
$resultado6=mysqli_num_rows($consulta6);
						
						while($data=mysqli_fetch_array($consulta6)){
							$descripcion6=$data["descripcion"];
							$valor_compra6=$data["precio_compra"];
						}
				
$consulta7=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod7'");
$resultado7=mysqli_num_rows($consulta7);
							
						while($data=mysqli_fetch_array($consulta7)){
									$descripcion7=$data["descripcion"];
									$valor_compra7=$data["precio_compra"];
						}
						
$consulta8=mysqli_query($conexion,"SELECT descripcion, precio_compra FROM producto WHERE codproducto='$prod8'");
$resultado8=mysqli_num_rows($consulta8);
								
						while($data=mysqli_fetch_array($consulta8)){
									$descripcion8=$data["descripcion"];
									$valor_compra8=$data["precio_compra"];
						}
	
*/	
		
	
	
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Compra</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>FACTURA DE COMPRA</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="crear_factura.php" method="POST">
					<input type="hidden" name="action" value="addCliente">
					<input type="hidden" id="idcliente" name="idcliente" value="" required>
					<div class="wd20">
						<h4>Datos del Cliente</h4>
					</div>

					<?php
					if($nit==0 || $nit==999)
					{
					?>
						<div class="wd50">
							<label><h1>Nombre</h1></label>	
							<label><h2><?php echo "$nombre"; ?></h2></label>
								
						</div>
	
					<?php
					}else{
					?>
						<div class="wd20">
							<label><h1>NIT</h1></label>	
							<label><h2><?php echo "$nit"; ?></h2></label>
								
						</div>

						<div class="wd20">
							<label><h1>Nombre</h1></label>	
							<label><h2><?php echo "$nombre"; ?></h2></label>
								
						</div>

						<div class="wd20">
							<label><h1>Dirección</h1></label>	
							<label><h2><?php echo "$direccion"; ?></h2></label>
								
						</div>
						<div class="wd20">
							<label><h1>Teléfono</h1></label>	
							<label><h2><?php echo "$telefono"; ?></h2></label>
								
						</div>
					<?php
					}
					?>
					
					
					
					

					<div class="wd100">
						<h4>DETALLE DE COMPRA</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="2">Descripción</th>
					<th colspan="2">Cantidad en Kilos</th>
					<th colspan="2">Valor de Compra por Kilo</th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


				<?php
					if($peso1 >0)
					{
				?>
	 			<tr>
					<td colspan="2">
						<input type="text" name="descripcion1" id="descripcion1" value="<?php echo $descripcion1; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso1" id="peso1" value="<?php echo $peso1; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra1" id="valor_compra1" value="<?php echo $valor_compra1; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal1" id="subtotal1" value="<?php echo $subtotal1; ?>">
					</td>
				</tr>
				<?php
				}
				?>


				

				<?php
					if($peso2 >0)
					{
				?>
				<tr>				
					<td colspan="2">
						<input type="text" name="descripcion2" id="descripcion2" value="<?php echo $descripcion2; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso2" id="peso2" value="<?php echo $peso2; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra2" id="valor_compra2" value="<?php echo $valor_compra2; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal2" id="subtotal2" value="<?php echo $subtotal2; ?>">
					</td>
				</tr>
				<?php
				}
				?>
				
				<?php
					if($peso3 >0)
					{
				?>
				<tr>
					<td colspan="2">
						<input type="text" name="descripcion3" id="descripcion3" value="<?php echo $descripcion3; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso3" id="peso3" value="<?php echo $peso3; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra3" id="valor_compra3" value="<?php echo $valor_compra3; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal3" id="subtotal3" value="<?php echo $subtotal3; ?>">
					</td>
				</tr>
				<?php
				}
				?>

				<?php
					if($peso4 >0)
					{
				?>
				<tr>				
					<td colspan="2">
						<input type="text" name="descripcion4" id="descripcion4" value="<?php echo $descripcion4; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso4" id="peso4" value="<?php echo $peso4; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra4" id="valor_compra4" value="<?php echo $valor_compra4; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal4" id="subtotal4" value="<?php echo $subtotal4; ?>">
					</td>
				</tr>
				<?php
				}
				?>


				<?php
					if($peso5 >0)
					{
				?>
				<tr>
					<td colspan="2">
						<input type="text" name="descripcion5" id="descripcion5" value="<?php echo $descripcion5; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso5" id="peso5" value="<?php echo $peso5; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra5" id="valor_compra5" value="<?php echo $valor_compra5; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal5" id="subtotal5" value="<?php echo $subtotal5; ?>">
					</td>
				</tr>
				<?php
				}
				?>

				<?php
					if($peso6 >0)
					{
				?>
				<tr>				
					<td colspan="2">
						<input type="text" name="descripcion6" id="descripcion6" value="<?php echo $descripcion6; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso6" id="peso6" value="<?php echo $peso6; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra6" id="valor_compra6" value="<?php echo $valor_compra6; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal6" id="subtotal6" value="<?php echo $subtotal6; ?>">
					</td>
				</tr>
				<?php
				}
				?>
				
				<?php
					if($peso7 >0)
					{
				?>
				<tr>
					<td colspan="2">
						<input type="text" name="descripcion7" id="descripcion7" value="<?php echo $descripcion7; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso7" id="peso7" value="<?php echo $peso7; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra7" id="valor_compra7" value="<?php echo $valor_compra7; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal7" id="subtotal7" value="<?php echo $subtotal7; ?>">
					</td>
				</tr>
				<?php
				}
				?>

				<?php
					if($peso8 >0)
					{
				?>
				<tr>				
					<td colspan="2">
						<input type="text" name="descripcion8" id="descripcion8" value="<?php echo $descripcion8; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="peso8" id="peso8" value="<?php echo $peso8; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="valor_compra8" id="valor_compra8" value="<?php echo $valor_compra8; ?>">
					</td>
					<td colspan="2">
						<input type="text" name="subtotal8" id="subtotal8" value="<?php echo $subtotal8; ?>">
					</td>
				</tr>
				<?php
				}
				?>

				-->



				<tr>				
					<td colspan="4">
					<label><h1>TOTAL PAGADO</h1></label>
					</td>
					<td colspan="4">
						<h1><input type="text" name="total" id="total" value="<?php echo $total; ?>"></h1>
					</td>
				</tr>

				


				

				
			</tbody>
		</table>	
					
					<div class="wd30"><input type="submit" class="btn_procesar" value="Imprimir"></div>
				
					<div class="wd30"><input type="" href="nueva_compra.php" class="btn_anular" value="Realizar Otra Compra"></div>
					

		

			</form>

			

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>