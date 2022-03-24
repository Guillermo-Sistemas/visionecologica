<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	$nit=0; $nombre=""; $telefono=0; $direccion= "No Tiene";
	
	$idcliente=$_POST['id_cliente'];

	$motivo=$_POST['motivo'];

	
	

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
    

	
	//captura del cero producto
	$prod0=$_POST['cbx_prod0'];
		if($_POST['peso01']){ 
			$peso01=$_POST['peso01'];
			$cantidades0=$peso01;
			$total_peso0=$peso01;
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
		
	$descripcion1="";
	$valor_compra1=0;

//captura del segundo producto
	$prod2=$_POST['cbx_prod2'];
		if($_POST['peso21']){ 
			$peso21=$_POST['peso21'];
			$cantidades2=$peso21;
			$total_peso2=$peso21;
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
		    
	    $descripcion3="";
	    $valor_compra3=0;

    //captura del cuarto producto
	        $prod4=$_POST['cbx_prod4'];
		        if($_POST['peso41']){ 
			        $peso41=$_POST['peso41'];
			        $cantidades4=$peso41;
			        $total_peso4=$peso41;
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
		        
	        $descripcion5="";
	        $valor_compra5=0;

    

	
	
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




						
mysqli_close($conexion);
	
	
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Procesar Devolución</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Procesar Devolución de Compra</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="calcular_devolucionc.php" method="POST">
			
			
					<div class="wd50">
						<h4>Nombre del Cliente</h4>
					</div>
					

					<tr>
						<td colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></td>
						<td colspan="1"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nombre; ?>"></td>
						
					</tr>


					<tr>
						
						<div class="wd50">
							<h4>Nuevo Cliente</h4>
						</div>
						<td colspan="1"><input type="text" name="nuevocliente" id="nuevocliente"  ></td>
						
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
					if($peso01 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $prod0; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion0" id="descripcion0" readonly="readonly" value="<?php echo $descripcion0; ?>">
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
					if($peso11 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $prod1; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
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
					if($peso21 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto2" id="idproducto2" value="<?php echo $prod2; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion2" id="descripcion2" readonly="readonly" value="<?php echo $descripcion2; ?>">
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
					if($peso31 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto3" id="idproducto3" value="<?php echo $prod3; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion3" id="descripcion3" readonly="readonly" value="<?php echo $descripcion3; ?>">
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
					if($peso41 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto4" id="idproducto4" value="<?php echo $prod4; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion4" id="descripcion4" readonly="readonly" value="<?php echo $descripcion4; ?>">
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
					if($peso51 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto5" id="idproducto5" value="<?php echo $prod5; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion5" id="descripcion5" readonly="readonly" value="<?php echo $descripcion5; ?>">
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

						<tr>

							<td colspan="1"><label for="motivo">Motivo de Devolución</label></td>
							<td colspan="3">
								<input type="text" name="motivo" id="motivo" readonly="readonly" value="<?php echo $motivo; ?>">
							</td>
							<td colspan="1">
								</td>
							<td colspan="1">
								</td>

						</tr>


                     

				

				

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Calcular Devolución"></div>
				
					<div class="wd30"><input type="reset" class="btn_limpiar" value="Recuperar Valores de Devolución"></div>
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Devolución" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
