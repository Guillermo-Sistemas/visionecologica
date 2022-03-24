<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

    if($_SESSION['rol']<1)
    {
	header('location:../');
    }

	$nit=0; $nombre=""; $remision="";

	if($_POST['remision']){
		$remision=$_POST['remision'];
	}
	
	$idcliente=$_POST['cbx_cliente'];

	$consultaCli=mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente='$idcliente'");
	$resultadoC=mysqli_num_rows($consultaCli);
	
		while($data=mysqli_fetch_array($consultaCli)){
			$nit=$data["nit"];
			$nombre=$data["nombrec"];
		}
	
	$peso0=0;$peso1=0;$peso2=0;$peso3=0;$peso4=0;$peso5=0;
	$peso6=0;$peso7=0;$peso8=0;$peso9=0;$pesoA=0;$pesoB=0;

	$pesoS0=0;$pesoS1=0;$pesoS2=0;$pesoS3=0;
	$pesoS4=0;$pesoS5=0;$pesoS6=0;$pesoS7=0;

	$art1=0; $art2=0; $art3=0;
	//echo "$idcliente";

	//captura del cero producto
	$prod0=$_POST['cbx_prod0'];
		if($_POST['peso0']){ 
			$peso0=$_POST['peso0'];
		}
	$descripcion0="";
	$valor_venta0=0;

	//captura del primer producto
	$prod1=$_POST['cbx_prod1'];
		if($_POST['peso1']){ 
			$peso1=$_POST['peso1'];
		}
	$descripcion1="";
	$valor_venta1=0;

    //captura del segundo producto
	$prod2=$_POST['cbx_prod2'];
		if($_POST['peso2']){ 
			$peso2=$_POST['peso2'];
		}
	$descripcion2="";
	$valor_venta2=0;

 //captura del tercer producto
	$prod3=$_POST['cbx_prod3'];
		if($_POST['peso3']){ 
			$peso3=$_POST['peso3'];
		}
	$descripcion3="";
	$valor_venta3=0;

//captura del cuarto producto
	$prod4=$_POST['cbx_prod4'];
		if($_POST['peso4']){ 
			$peso4=$_POST['peso4'];
		}
	$descripcion4="";
	$valor_venta4=0;

//captura del quinto producto

	$prod5=$_POST['cbx_prod5'];
		if($_POST['peso5']){ 
			$peso5=$_POST['peso5'];
		}
	$descripcion5="";
	$valor_venta5=0;


//captura del sexto producto
	$prod6=$_POST['cbx_prod6'];
		if($_POST['peso6']){ 
			$peso6=$_POST['peso6'];
		}
	$descripcion6="";
	$valor_venta6=0;

//captura del septimo producto
	$prod7=$_POST['cbx_prod7'];
		if($_POST['peso7']){ 
			$peso7=$_POST['peso7'];
		}
	$descripcion7="";
	$valor_venta7=0;

//captura del octavo producto
	$prod8=$_POST['cbx_prod8'];
		if($_POST['peso8']){ 
			$peso8=$_POST['peso8'];
		}
	$descripcion8="";
	$valor_venta8=0;
	
//captura del noveno producto
$prod9=$_POST['cbx_prod9'];
if($_POST['peso9']){ 
	$peso9=$_POST['peso9'];
}
$descripcion9="";
$valor_venta9=0;

//captura del A producto
$prodA=$_POST['cbx_prodA'];
if($_POST['pesoA']){ 
	$pesoA=$_POST['pesoA'];
}
$descripcionA="";
$valor_ventaA=0;

//captura del B producto
$prodB=$_POST['cbx_prodB'];
if($_POST['pesoB']){ 
	$pesoB=$_POST['pesoB'];
}
$descripcionB="";
$valor_ventaB=0;

//captura del SUBproducto 1
if(!empty($_POST['cbx_sub1'])){
	$sub1=$_POST['cbx_sub1'];
	if($_POST['pesoS1']){ 
		$pesoS1=$_POST['pesoS1'];
	}
	$descripcionS1="";
	$valor_ventaS1=0;
}

//captura del SUBproducto 2
if(!empty($_POST['cbx_sub2'])){
	$sub2=$_POST['cbx_sub2'];
	if($_POST['pesoS2']){ 
		$pesoS2=$_POST['pesoS2'];
	}
	$descripcionS2="";
	$valor_ventaS2=0;
}


//captura del SUBproducto 3
if(!empty($_POST['cbx_sub3'])){
	$sub3=$_POST['cbx_sub3'];
	if($_POST['pesoS3']){ 
		$pesoS3=$_POST['pesoS3'];
	}
	$descripcionS3="";
	$valor_ventaS3=0;
}

//captura del SUBproducto 4
if(!empty($_POST['cbx_sub4'])){
	$sub4=$_POST['cbx_sub4'];
	if($_POST['pesoS4']){ 
		$pesoS4=$_POST['pesoS4'];
	}
	$descripcionS4="";
	$valor_ventaS4=0;
}

//captura del SUBproducto 5
if(!empty($_POST['cbx_sub5'])){
	$sub5=$_POST['cbx_sub5'];
	if($_POST['pesoS5']){ 
		$pesoS5=$_POST['pesoS5'];
	}
	$descripcionS5="";
	$valor_ventaS5=0;
}

//captura del SUBproducto 6
if(!empty($_POST['cbx_sub6'])){
	$sub6=$_POST['cbx_sub6'];
	if($_POST['pesoS6']){ 
		$pesoS6=$_POST['pesoS6'];
	}
	$descripcionS6="";
	$valor_ventaS6=0;
}

//captura del SUBproducto 7
if(!empty($_POST['cbx_sub7'])){
	$sub7=$_POST['cbx_sub7'];
	if($_POST['pesoS7']){ 
		$pesoS7=$_POST['pesoS7'];
	}
	$descripcionS7="";
	$valor_ventaS7=0;
}

//captura del articulo 1


if(!empty($_POST['cbx_art1'])){ 
	$art1=$_POST['cbx_art1'];
}
$descripcionA1="";
$valor_ventaA1=0;

//captura del articulo 2
if(!empty($_POST['cbx_art2'])){  
	$art2=$_POST['cbx_art2'];
}
$descripcionA2="";
$valor_ventaA2=0;

//captura del articulo 3
if(!empty($_POST['cbx_art3'])){  
	$art3=$_POST['cbx_art3'];
}
$descripcionA3="";
$valor_ventaA3=0;




		


//consulta CERO producto
$consulta0=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod0'");
$resultado0=mysqli_num_rows($consulta0);
	
		while($data=mysqli_fetch_array($consulta0)){
			$descripcion0=$data["descripcion"];
			$valor_venta0=$data["precio_venta"];
		}

//consulta primer producto
$consulta1=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod1'");
$resultado1=mysqli_num_rows($consulta1);
	
		while($data=mysqli_fetch_array($consulta1)){
			$descripcion1=$data["descripcion"];
			$valor_venta1=$data["precio_venta"];
		}

//consulta segundo producto
$consulta2=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod2'");
$resultado2=mysqli_num_rows($consulta2);
	
		while($data=mysqli_fetch_array($consulta2)){
			$descripcion2=$data["descripcion"];
			$valor_venta2=$data["precio_venta"];
		}

//consulta tercer producto
$consulta3=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod3'");
$resultado3=mysqli_num_rows($consulta3);
	
		while($data=mysqli_fetch_array($consulta3)){
			$descripcion3=$data["descripcion"];
			$valor_venta3=$data["precio_venta"];
		}

//consulta cuarto producto
$consulta4=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod4'");
$resultado4=mysqli_num_rows($consulta4);
	
		while($data=mysqli_fetch_array($consulta4)){
			$descripcion4=$data["descripcion"];
			$valor_venta4=$data["precio_venta"];
		}

//consulta QUINto producto
$consulta5=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod5'");
$resultado5=mysqli_num_rows($consulta5);
	
		while($data=mysqli_fetch_array($consulta5)){
			$descripcion5=$data["descripcion"];
			$valor_venta5=$data["precio_venta"];
		}

//consulta SEXTO producto
$consulta6=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod6'");
$resultado6=mysqli_num_rows($consulta6);
	
		while($data=mysqli_fetch_array($consulta6)){
			$descripcion6=$data["descripcion"];
			$valor_venta6=$data["precio_venta"];
		}

//consulta SEPTIMO producto
$consulta7=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod7'");
$resultado7=mysqli_num_rows($consulta7);
	
		while($data=mysqli_fetch_array($consulta7)){
			$descripcion7=$data["descripcion"];
			$valor_venta7=$data["precio_venta"];
		}

//consulta OCTAVO producto
$consulta8=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod8'");
$resultado8=mysqli_num_rows($consulta8);
	
		while($data=mysqli_fetch_array($consulta8)){
			$descripcion8=$data["descripcion"];
			$valor_venta8=$data["precio_venta"];
		}

//consulta NOVENO producto
$consulta9=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prod9'");
$resultado9=mysqli_num_rows($consulta9);
	
		while($data=mysqli_fetch_array($consulta9)){
			$descripcion9=$data["descripcion"];
			$valor_venta9=$data["precio_venta"];
		}

//consulta A producto
$consultaA=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prodA'");
$resultadoA=mysqli_num_rows($consultaA);
	
		while($data=mysqli_fetch_array($consultaA)){
			$descripcionA=$data["descripcion"];
			$valor_ventaA=$data["precio_venta"];
		}
//consulta A producto
$consultaB=mysqli_query($conexion,"SELECT descripcion, precio_venta FROM producto WHERE codproducto='$prodB'");
$resultadoB=mysqli_num_rows($consultaB);
	
		while($data=mysqli_fetch_array($consultaB)){
			$descripcionB=$data["descripcion"];
			$valor_ventaB=$data["precio_venta"];
		}


//consulta SUBproducto 1
$consultaS1=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub1'");
$resultadoS1=mysqli_num_rows($consultaS1);
	
		while($data=mysqli_fetch_array($consultaS1)){
			$descripcionS1=$data["nombre_subpro"];
			$valor_ventaS1=$data["precioventa_subpro"];
		}

//consulta SUBproducto 2
$consultaS2=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub2'");
$resultadoS2=mysqli_num_rows($consultaS2);
	
		while($data=mysqli_fetch_array($consultaS2)){
			$descripcionS2=$data["nombre_subpro"];
			$valor_ventaS2=$data["precioventa_subpro"];
		}

//consulta SUBproducto 3
$consultaS3=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub3'");
$resultadoS3=mysqli_num_rows($consultaS3);
	
		while($data=mysqli_fetch_array($consultaS3)){
			$descripcionS3=$data["nombre_subpro"];
			$valor_ventaS3=$data["precioventa_subpro"];
		}

//consulta SUBproducto 4
$consultaS4=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub4'");
$resultadoS4=mysqli_num_rows($consultaS4);
	
		while($data=mysqli_fetch_array($consultaS4)){
			$descripcionS4=$data["nombre_subpro"];
			$valor_ventaS4=$data["precioventa_subpro"];
		}

//consulta SUBproducto 5
$consultaS5=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub5'");
$resultadoS5=mysqli_num_rows($consultaS5);
	
		while($data=mysqli_fetch_array($consultaS5)){
			$descripcionS5=$data["nombre_subpro"];
			$valor_ventaS5=$data["precioventa_subpro"];
		}

//consulta SUBproducto 6
$consultaS6=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub6'");
$resultadoS6=mysqli_num_rows($consultaS6);
	
		while($data=mysqli_fetch_array($consultaS6)){
			$descripcionS6=$data["nombre_subpro"];
			$valor_ventaS6=$data["precioventa_subpro"];
		}

//consulta SUBproducto 7
$consultaS7=mysqli_query($conexion,"SELECT nombre_subpro, precioventa_subpro FROM subproducto WHERE codsubproducto='$sub7'");
$resultadoS7=mysqli_num_rows($consultaS7);
	
		while($data=mysqli_fetch_array($consultaS7)){
			$descripcionS7=$data["nombre_subpro"];
			$valor_ventaS7=$data["precioventa_subpro"];
		}

//consulta ARTICULO 1
$consultaA1=mysqli_query($conexion,"SELECT descripcion_recuperado, precioventa_recuperado FROM recuperado WHERE codrecuperado='$art1'");
$resultadoA1=mysqli_num_rows($consultaA1);
	
		while($data=mysqli_fetch_array($consultaA1)){
			$descripcionA1=$data["descripcion_recuperado"];
			$valor_ventaA1=$data["precioventa_recuperado"];
		}

//consulta ARTICULO 2
$consultaA2=mysqli_query($conexion,"SELECT descripcion_recuperado, precioventa_recuperado FROM recuperado WHERE codrecuperado='$art2'");
$resultadoA2=mysqli_num_rows($consultaA2);
	
		while($data=mysqli_fetch_array($consultaA2)){
			$descripcionA2=$data["descripcion_recuperado"];
			$valor_ventaA2=$data["precioventa_recuperado"];
		}

//consulta ARTICULO 3
$consultaA3=mysqli_query($conexion,"SELECT descripcion_recuperado, precioventa_recuperado FROM recuperado WHERE codrecuperado='$art3'");
$resultadoA3=mysqli_num_rows($consultaA3);
    
        while($data=mysqli_fetch_array($consultaA3)){
            $descripcionA3=$data["descripcion_recuperado"];
            $valor_ventaA3=$data["precioventa_recuperado"];
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
	<title>Procesar Venta</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Procesar Venta</h1>
		</div>
			
		
			

			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="calcular_venta.php" method="POST">
			
			
					<div class="wd100">
						<h4>Nombre del Cliente</h4>
					</div>

					<tr>
						<th colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></th>
						<td colspan="2"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nombre; ?>"></td>
						
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
						<h4>Detalle de la Venta</h4>
					</div>


					



			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="1">Peso</th>
					<th colspan="2">Valor de Venta </th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


				   <?php
				   if($peso0 >0)

				  // echo $art1;
				   
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
							   <input type="number" min="0" name="valor_venta0" id="valor_venta0" value="<?php echo $valor_venta0; ?>">
						   </td>
						   <td colspan="2">
							   <input type="text" name="subtotal0" id="subtotal0" readonly="readonly" value="<?php echo $peso0*$valor_venta0; ?>">
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
								<input type="number" min="0" name="valor_venta1" id="valor_venta1" value="<?php echo $valor_venta1; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal1" id="subtotal1" readonly="readonly" value="<?php echo $peso1*$valor_venta1; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso2 >0 )
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
								<input type="number" min="0" name="valor_venta2" id="valor_venta2" value="<?php echo $valor_venta2; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal2" id="subtotal2" readonly="readonly" value="<?php echo $peso2*$valor_venta2; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                    <?php
					if($peso3 >0 )
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
								<input type="number" min="0" name="valor_venta3" id="valor_venta3" value="<?php echo $valor_venta3; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal3" id="subtotal3" readonly="readonly" value="<?php echo $peso3*$valor_venta3; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso4 >0 )
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
								<input type="number" min="0" name="valor_venta4" id="valor_venta4" value="<?php echo $valor_venta4; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal4" id="subtotal4" readonly="readonly" value="<?php echo $peso4*$valor_venta4; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                     <?php
					if($peso5 >0 )
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
								<input type="number" min="0" name="valor_venta5" id="valor_venta5" value="<?php echo $valor_venta5; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal5" id="subtotal5" readonly="readonly" value="<?php echo $peso5*$valor_venta5; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>


                     <?php
					if($peso6 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto6" id="idproducto6" value="<?php echo $prod6; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion6" id="descripcion6" readonly="readonly" value="<?php echo $descripcion6; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="peso6" id="peso6" readonly="readonly" value="<?php echo $peso6; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_venta6" id="valor_venta6" value="<?php echo $valor_venta6; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal6" id="subtotal6" readonly="readonly" value="<?php echo $peso6*$valor_venta6; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso7 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto7" id="idproducto7" value="<?php echo $prod7; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion7" id="descripcion7" readonly="readonly" value="<?php echo $descripcion7; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="peso7" id="peso7" readonly="readonly" value="<?php echo $peso7; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_venta7" id="valor_venta7" value="<?php echo $valor_venta7; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal7" id="subtotal7" readonly="readonly" value="<?php echo $peso7*$valor_venta7; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

                    <?php
					if($peso8 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto8" id="idproducto8" value="<?php echo $prod8; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion8" id="descripcion8" readonly="readonly" value="<?php echo $descripcion8; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="peso8" id="peso8" readonly="readonly" value="<?php echo $peso8; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_venta8" id="valor_venta8" value="<?php echo $valor_venta8; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal8" id="subtotal8" readonly="readonly" value="<?php echo $peso8*$valor_venta8; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>
					<?php
					if($peso9 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto9" id="idproducto9" value="<?php echo $prod9; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion9" id="descripcion9" readonly="readonly" value="<?php echo $descripcion9; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="peso9" id="peso9" readonly="readonly" value="<?php echo $peso9; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_venta9" id="valor_venta9" value="<?php echo $valor_venta9; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal9" id="subtotal9" readonly="readonly" value="<?php echo $peso9*$valor_venta9; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>
					<?php
					if($pesoA >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproductoA" id="idproductoA" value="<?php echo $prodA; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionA" id="descripcionA" readonly="readonly" value="<?php echo $descripcionA; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="pesoA" id="pesoA" readonly="readonly" value="<?php echo $pesoA; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_ventaA" id="valor_ventaA" value="<?php echo $valor_ventaA; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalA" id="subtotalA" readonly="readonly" value="<?php echo $pesoA*$valor_ventaA; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>
					<?php
					if($pesoB >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproductoB" id="idproductoB" value="<?php echo $prodB; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionB" id="descripcionB" readonly="readonly" value="<?php echo $descripcionB; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="pesoB" id="pesoB" readonly="readonly" value="<?php echo $pesoB; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_ventaB" id="valor_ventaB" value="<?php echo $valor_ventaB; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalB" id="subtotalB" readonly="readonly" value="<?php echo $pesoB*$valor_ventaB; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>
					<?php
					if($pesoS1 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idS1" id="idS1" value="<?php echo $sub1; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionS1" id="descripcionS1" readonly="readonly" value="<?php echo $descripcionS1; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="pesoS1" id="pesoS1" readonly="readonly" value="<?php echo $pesoS1; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_ventaS1" id="valor_ventaS1" value="<?php echo $valor_ventaS1; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalS1" id="subtotalS1" readonly="readonly" value="<?php echo $pesoS1*$valor_ventaS1; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

					<?php
					if($pesoS2 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idS2" id="idS2" value="<?php echo $sub2; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionS2" id="descripcionS2" readonly="readonly" value="<?php echo $descripcionS2; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="pesoS2" id="pesoS2" readonly="readonly" value="<?php echo $pesoS2; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_ventaS2" id="valor_ventaS2" value="<?php echo $valor_ventaS2; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalS2" id="subtotalS2" readonly="readonly" value="<?php echo $pesoS2*$valor_ventaS2; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

					<?php
					if($pesoS3 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idS3" id="idS3" value="<?php echo $sub3; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionS3" id="descripcionS3" readonly="readonly" value="<?php echo $descripcionS3; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="pesoS3" id="pesoS3" readonly="readonly" value="<?php echo $pesoS3; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_ventaS3" id="valor_ventaS3" value="<?php echo $valor_ventaS3; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalS3" id="subtotalS3" readonly="readonly" value="<?php echo $pesoS3*$valor_ventaS3; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

<?php
					if($pesoS4 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idS4" id="idS4" value="<?php echo $sub4; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcionS4" id="descripcionS4" readonly="readonly" value="<?php echo $descripcionS4; ?>">
							</td>
							
							<td colspan="1">
								<input type="text" name="pesoS4" id="pesoS4" readonly="readonly" value="<?php echo $pesoS4; ?>">
							</td>
							<td colspan="2">
								<input type="number" min="0" name="valor_ventaS4" id="valor_ventaS4" value="<?php echo $valor_ventaS4; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotalS4" id="subtotalS4" readonly="readonly" value="<?php echo $pesoS4*$valor_ventaS4; ?>">
							</td>
						</tr>
						<?php
						
					}
					?>

					<?php
                    if($pesoS5 >0 )
                    {
                    
                        ?>
                        <tr>
                            
                            <input type="hidden" name="idS5" id="idS5" value="<?php echo $sub5; ?>">
                            
                            <td colspan="1">
                                <input type="text" name="descripcionS5" id="descripcionS5" readonly="readonly" value="<?php echo $descripcionS5; ?>">
                            </td>
                            
                            <td colspan="1">
                                <input type="text" name="pesoS5" id="pesoS5" readonly="readonly" value="<?php echo $pesoS5; ?>">
                            </td>
                            <td colspan="2">
                                <input type="number" min="0" name="valor_ventaS5" id="valor_ventaS5" value="<?php echo $valor_ventaS5; ?>">
                            </td>
                            <td colspan="2">
                                <input type="text" name="subtotalS5" id="subtotalS5" readonly="readonly" value="<?php echo $pesoS5*$valor_ventaS5; ?>">
                            </td>
                        </tr>
                        <?php
						}
						?>

					<?php
                    if($pesoS6 >0 )
                    {
                    
                        ?>
                        <tr>
                            
                            <input type="hidden" name="idS6" id="idS6" value="<?php echo $sub6; ?>">
                            
                            <td colspan="1">
                                <input type="text" name="descripcionS6" id="descripcionS6" readonly="readonly" value="<?php echo $descripcionS6; ?>">
                            </td>
                            
                            <td colspan="1">
                                <input type="text" name="pesoS6" id="pesoS6" readonly="readonly" value="<?php echo $pesoS6; ?>">
                            </td>
                            <td colspan="2">
                                <input type="number" min="0" name="valor_ventaS6" id="valor_ventaS6" value="<?php echo $valor_ventaS6; ?>">
                            </td>
                            <td colspan="2">
                                <input type="text" name="subtotalS6" id="subtotalS6" readonly="readonly" value="<?php echo $pesoS6*$valor_ventaS6; ?>">
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

					<?php
                    if($pesoS7 >0 )
                    {
                    
                        ?>
                        <tr>
                            
                            <input type="hidden" name="idS7" id="idS7" value="<?php echo $sub7; ?>">
                            
                            <td colspan="1">
                                <input type="text" name="descripcionS7" id="descripcionS7" readonly="readonly" value="<?php echo $descripcionS7; ?>">
                            </td>
                            
                            <td colspan="1">
                                <input type="text" name="pesoS7" id="pesoS7" readonly="readonly" value="<?php echo $pesoS7; ?>">
                            </td>
                            <td colspan="2">
                                <input type="number" min="0" name="valor_ventaS7" id="valor_ventaS7" value="<?php echo $valor_ventaS7; ?>">
                            </td>
                            <td colspan="2">
                                <input type="text" name="subtotalS7" id="subtotalS7" readonly="readonly" value="<?php echo $pesoS7*$valor_ventaS7; ?>">
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

					<?php

						

                    if($art1>0 && $art1!=$art2 && $art1!=$art3 )
                    {
                    
                        ?>
                        <tr>
                            
                            <input type="hidden" name="art1" id="art1" value="<?php echo $art1; ?>">
                            
                            <td colspan="2">
                                <input type="text" name="descripcionA1" id="descripcionA1" readonly="readonly" value="<?php echo $descripcionA1; ?>">
                            </td>
                            
                            
                            <td colspan="2">
                                <input type="number" min="0" name="valor_ventaA1" id="valor_ventaA1" value="<?php echo $valor_ventaA1; ?>">
                            </td>
                            <td colspan="2">
                                <input type="text" name="subtotalA1" id="subtotalA1" readonly="readonly" value="<?php echo $valor_ventaA1; ?>">
                            </td>
                            
                        </tr>

                        <?php

                        }
                        ?>

<?php
                    if($art2>0 && $art1!=$art2 && $art2!=$art3   )
                    {
                    
                        ?>
                        <tr>
                            
                            <input type="hidden" name="art2" id="art2" value="<?php echo $art2; ?>">
                            
                            <td colspan="2">
                                <input type="text" name="descripcionA2" id="descripcionA2" readonly="readonly" value="<?php echo $descripcionA2; ?>">
                            </td>
                            
                            
                            <td colspan="2">
                                <input type="number" min="0" name="valor_ventaA2" id="valor_ventaA2" value="<?php echo $valor_ventaA2; ?>">
                            </td>
							<td colspan="2">
                                <input type="text" name="subtotalA2" id="subtotalA2" readonly="readonly" value="<?php echo $valor_ventaA2; ?>">
                            </td>
                            
                        </tr>
                        <?php
                        }
                        ?>
					<?php
					if($art3>0 && $art1!=$art3 && $art2!=$art3   )
                    {
                    
                        ?>
                        <tr>
                            
                            <input type="hidden" name="art3" id="art3" value="<?php echo $art3; ?>">
                            
                            <td colspan="2">
                                <input type="text" name="descripcionA3" id="descripcionA3" readonly="readonly" value="<?php echo $descripcionA3; ?>">
                            </td>
                            
                            
                            <td colspan="2">
                                <input type="number" min="0" name="valor_ventaA3" id="valor_ventaA3" value="<?php echo $valor_ventaA3; ?>">
                            </td>
							<td colspan="2">
                                <input type="text" name="subtotalA3" id="subtotalA3" readonly="readonly" value="<?php echo $valor_ventaA3; ?>">
                            </td>
                            
                        </tr>
                        <?php
                        }
                        ?>


						



				

				

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Calcular Venta"></div>
				
					<div class="wd30"><input type="reset" class="btn_limpiar" value="Recuperar Valores de Venta"></div>
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Venta" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
