<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }

	


	$remision="";
	$nuevocliente="";
	//$idcliente=$_POST['cbx_cliente'];

	//echo "$idcliente";

	$idcliente=$_POST['idcliente'];
	$nomcliente=$_POST['nomcliente'];

	if (!empty($_POST['remision']))
		$remision=$_POST['remision'];
	if (!empty($_POST['nuevocliente']))
		$nuevocliente=$_POST['nuevocliente'];
		
	$ajuste=0;
	

    $idproducto0=0; $peso0=0; $valor0=0; $subtotal0=0;	
	$idproducto1=0; $peso1=0; $valor1=0; $subtotal1=0;
    $idproducto2=0; $peso2=0; $valor2=0; $subtotal2=0;
    $idproducto3=0; $peso3=0; $valor3=0; $subtotal3=0;
    $idproducto4=0; $peso4=0; $valor4=0; $subtotal4=0;
    $idproducto5=0; $peso5=0; $valor5=0; $subtotal5=0;
    $idproducto6=0; $peso6=0; $valor6=0; $subtotal6=0;
    $idproducto7=0; $peso7=0; $valor7=0; $subtotal7=0;
    $idproducto8=0; $peso8=0; $valor8=0; $subtotal8=0;
    $idproducto9=0; $peso9=0; $valor9=0; $subtotal9=0;
    $idproductoA=0; $pesoA=0; $valorA=0; $subtotalA=0;
    $idproductoB=0; $pesoB=0; $valorB=0; $subtotalB=0;

	$subtotalS1=0; $subtotalS2=0; $subtotalS3=0; $subtotalS4=0;
	$subtotalS5=0; $subtotalS6=0; $subtotalS7=0;
	$subtotalA1=0; $subtotalA2=0; $subtotalA3=0;

	$pesoS1=0; $pesoS2=0; $pesoS3=0; $pesoS4=0;
	$pesoS5=0; $pesoS6=0; $pesoS7=0; 

	$art1=0; $art2=0; $art3=0;


	//echo $_POST['idproducto0'];
    if (!empty($_POST['peso0'])){ 
	    $idproducto0=$_POST['idproducto0'];
		$descripcion0=$_POST['descripcion0'];
		$peso0=$_POST['peso0'];
		$valor0=$_POST['valor_venta0'];
		$subtotal0=$peso0*$valor0;
	}
	
	if (!empty($_POST['peso1'])){ 
	    $idproducto1=$_POST['idproducto1'];
		$descripcion1=$_POST['descripcion1'];
		$peso1=$_POST['peso1'];
		$valor1=$_POST['valor_venta1'];
		$subtotal1=$peso1*$valor1;
	}

    if (!empty($_POST['peso2'])){ 
	    $idproducto2=$_POST['idproducto2'];
		$descripcion2=$_POST['descripcion2'];
		$peso2=$_POST['peso2'];
		$valor2=$_POST['valor_venta2'];
		$subtotal2=$peso2*$valor2;
	}

    if (!empty($_POST['peso3'])){ 
	    $idproducto3=$_POST['idproducto3'];
		$descripcion3=$_POST['descripcion3'];
		$peso3=$_POST['peso3'];
		$valor3=$_POST['valor_venta3'];
		$subtotal3=$peso3*$valor3;
	}

    if (!empty($_POST['peso4'])){ 
	    $idproducto4=$_POST['idproducto4'];
		$descripcion4=$_POST['descripcion4'];
		$peso4=$_POST['peso4'];
		$valor4=$_POST['valor_venta4'];
		$subtotal4=$peso4*$valor4;
	}

    if (!empty($_POST['peso5'])){ 
	    $idproducto5=$_POST['idproducto5'];
		$descripcion5=$_POST['descripcion5'];
		$peso5=$_POST['peso5'];
		$valor5=$_POST['valor_venta5'];
		$subtotal5=$peso5*$valor5;
	}

    if (!empty($_POST['peso6'])){ 
	    $idproducto6=$_POST['idproducto6'];
		$descripcion6=$_POST['descripcion6'];
		$peso6=$_POST['peso6'];
		$valor6=$_POST['valor_venta6'];
		$subtotal6=$peso6*$valor6;
	}

     if (!empty($_POST['peso7'])){ 
	    $idproducto7=$_POST['idproducto7'];
		$descripcion7=$_POST['descripcion7'];
		$peso7=$_POST['peso7'];
		$valor7=$_POST['valor_venta7'];
		$subtotal7=$peso7*$valor7;
	}

    if (!empty($_POST['peso8'])){ 
	    $idproducto8=$_POST['idproducto8'];
		$descripcion8=$_POST['descripcion8'];
		$peso8=$_POST['peso8'];
		$valor8=$_POST['valor_venta8'];
		$subtotal8=$peso8*$valor8;
	}

     if (!empty($_POST['peso9'])){ 
	    $idproducto9=$_POST['idproducto9'];
		$descripcion9=$_POST['descripcion9'];
		$peso9=$_POST['peso9'];
		$valor9=$_POST['valor_venta9'];
		$subtotal9=$peso9*$valor9;
	}

    if (!empty($_POST['pesoA'])){ 
	    $idproductoA=$_POST['idproductoA'];
		$descripcionA=$_POST['descripcionA'];
		$pesoA=$_POST['pesoA'];
		$valorA=$_POST['valor_ventaA'];
		$subtotalA=$pesoA*$valorA;
	}

    if (!empty($_POST['pesoB'])){ 
	    $idproductoB=$_POST['idproductoB'];
		$descripcionB=$_POST['descripcionB'];
		$pesoB=$_POST['pesoB'];
		$valorB=$_POST['valor_ventaB'];
		$subtotalB=$pesoB*$valorB;
	}

    
     if (!empty($_POST['pesoS1'])){ 
	    $idS1=$_POST['idS1'];
		$descripcionS1=$_POST['descripcionS1'];
		$pesoS1=$_POST['pesoS1'];
		$valorS1=$_POST['valor_ventaS1'];
		$subtotalS1=$pesoS1*$valorS1;
	}

    if (!empty($_POST['pesoS2'])){ 
	    $idS2=$_POST['idS2'];
		$descripcionS2=$_POST['descripcionS2'];
		$pesoS2=$_POST['pesoS2'];
		$valorS2=$_POST['valor_ventaS2'];
		$subtotalS2=$pesoS2*$valorS2;
	}

     if (!empty($_POST['pesoS3'])){ 
	    $idS3=$_POST['idS3'];
		$descripcionS3=$_POST['descripcionS3'];
		$pesoS3=$_POST['pesoS3'];
		$valorS3=$_POST['valor_ventaS3'];
		$subtotalS3=$pesoS3*$valorS3;
	}

    if (!empty($_POST['pesoS4'])){ 
	    $idS4=$_POST['idS4'];
		$descripcionS4=$_POST['descripcionS4'];
		$pesoS4=$_POST['pesoS4'];
		$valorS4=$_POST['valor_ventaS4'];
		$subtotalS4=$pesoS4*$valorS4;
	}

    if (!empty($_POST['pesoS5'])){ 
	    $idS5=$_POST['idS5'];
		$descripcionS5=$_POST['descripcionS5'];
		$pesoS5=$_POST['pesoS5'];
		$valorS5=$_POST['valor_ventaS5'];
		$subtotalS5=$pesoS5*$valorS5;
	}

     if (!empty($_POST['pesoS6'])){ 
	    $idS6=$_POST['idS6'];
		$descripcionS6=$_POST['descripcionS6'];
		$pesoS6=$_POST['pesoS6'];
		$valorS6=$_POST['valor_ventaS6'];
		$subtotalS6=$pesoS6*$valorS6;
	}

    if (!empty($_POST['pesoS7'])){ 
	    $idS7=$_POST['idS7'];
		$descripcionS7=$_POST['descripcionS7'];
		$pesoS7=$_POST['pesoS7'];
		$valorS7=$_POST['valor_ventaS7'];
		$subtotalS7=$pesoS7*$valorS7;
	}

    if (!empty($_POST['valor_ventaA1'])){ 
	    $art1=$_POST['art1'];
		$descripcionA1=$_POST['descripcionA1'];
		$valorA1=$_POST['valor_ventaA1'];
		$subtotalA1=$valorA1;
	}

    if (!empty($_POST['valor_ventaA2'])){ 
	    $art2=$_POST['art2'];
		$descripcionA2=$_POST['descripcionA2'];
		$valorA2=$_POST['valor_ventaA2'];
		$subtotalA2=$valorA2;
	}

	if (!empty($_POST['valor_ventaA3'])){ 
	    $art3=$_POST['art3'];
		$descripcionA3=$_POST['descripcionA3'];
		$valorA3=$_POST['valor_ventaA3'];
		$subtotalA3=$valorA3;
	}


	

	$total=$subtotal0+$subtotal1+$subtotal2+$subtotal3+$subtotal4+$subtotal5+$subtotal6+$subtotal7+$subtotal8+$subtotal9+$subtotalA+$subtotalB+
           $subtotalS1+$subtotalS2+$subtotalS3+$subtotalS4+$subtotalS5+$subtotalS6+$subtotalS7+$subtotalA1+$subtotalA2+$subtotalA3;
	$total=round($total);
	$modulo=($total%100);

	echo $modulo;

	if ($modulo>0 && $modulo<25 ){ 
		$ajuste=-$modulo;
		$total=$total+($ajuste);
		
	}
	if ($modulo>=25 && $modulo<51 ){ 
		$ajuste=50-$modulo;
		if ($ajuste!=0 ){ 
			$total=$total+($ajuste);
		}
	}
	if ($modulo>50 && $modulo<76 ){ 
		$ajuste=$modulo-50;
		$total=$total-($ajuste);
		$ajuste=-$ajuste;	
	}
	if ($modulo>75 && $modulo<101 ){ 
		$ajuste=100-$modulo;
		if ($ajuste!=0 ){ 
			$total=$total+($ajuste);
		}
	}

	$total2=number_format($total, 0, ",", ".");
	
	
		
	
	
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Calcular Venta</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Calcular Venta</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="Vender.php" method="POST">
					

					<div class="wd100">
						<h4>Nombre del Cliente</h4>
					</div>

					<tr>
					<?php
						if($nuevocliente==""){
					?>
							<td colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>"></td>
							<td colspan="1"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nomcliente; ?>"></td>
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

						<?php
						}else{

							$query_insert=mysqli_query($conexion, "INSERT INTO cliente(nit, nombrec, telefono, direccion, tipo_cliente)
                                    VALUES ('0','$nuevocliente', '0', 'No tiene','temporal')");
							$inicio=mysqli_query($conexion, "select MAX(idcliente) from cliente");
							$inicio1= mysqli_fetch_array($inicio);
							$controlcliente=$inicio1[0];
						?>



						<th colspan="1"><input type="hidden" name="idcliente" id="idcliente" value="<?php echo $controlcliente; ?>"></th>
						<td colspan="2"><input type="text" name="nomcliente" id="nomcliente" readonly="readonly" value="<?php echo $nuevocliente; ?>"></td>
						<?php
						if($remision!=""){?>
						<div class="wd50">
							<h4>Remisión</h4>
						</div>
						<td colspan="1"><input type="text" name="remision" id="remision" readonly="readonly" value="<?php echo $remision; ?>"></td>
						<?php
						}
						}
						?>
					</tr>
					
					
					
					

					<div class="wd100">
						<h4>Detalle de la Venta</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="1">Peso</th>
					<th colspan="2">Valor de Venta</th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


				<?php

                if($peso0 >0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $idproducto0; ?>">
						<td colspan="1">
							<input type="text" name="descripcion0" id="descripcion0" readonly="readonly" value="<?php echo $descripcion0; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso0" id="peso0" readonly="readonly" value="<?php echo $peso0; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor0" id="valor0"  readonly="readonly" value="<?php echo $valor0; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal0" id="subtotal0" value="<?php echo $subtotal0; ?>">
						</td>
					</tr>
					<?php
					}
					
				if($peso1 >0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $idproducto1; ?>">
						<td colspan="1">
							<input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso1" id="peso1" readonly="readonly" value="<?php echo $peso1; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor1" id="valor1"  readonly="readonly" value="<?php echo $valor1; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal1" id="subtotal1" value="<?php echo $subtotal1; ?>">
						</td>
					</tr>
					<?php
					}
					if($peso2 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto2" id="idproducto2" value="<?php echo $idproducto2; ?>">
							
							<td colspan="1">
								<input type="text" name="descripcion2" id="descripcion2" readonly="readonly" value="<?php echo $descripcion2; ?>">
							</td>
							
							<td colspan="1">
								<input type="number" name="peso2" id="peso2" readonly="readonly" value="<?php echo $peso2; ?>">
							</td>
							<td colspan="2">
								<input type="number" name="valor2" id="valor2" readonly="readonly" value="<?php echo $valor2; ?>">
							</td>
							<td colspan="2">
								<input type="number" name="subtotal2" id="subtotal2"  value="<?php echo $subtotal2; ?>">
							</td>
						</tr>
						<?php
						
					}
					if($peso3>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto3" id="idproducto3" value="<?php echo $idproducto3; ?>">
						<td colspan="1">
							<input type="text" name="descripcion3" id="descripcion3" readonly="readonly" value="<?php echo $descripcion3; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso3" id="peso3" readonly="readonly" value="<?php echo $peso3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor3" id="valor3"  readonly="readonly" value="<?php echo $valor3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal3" id="subtotal3"  value="<?php echo $subtotal3; ?>">
						</td>
					</tr>
					<?php
                    }
					if($peso4>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto4" id="idproducto4" value="<?php echo $idproducto4; ?>">
						<td colspan="1">
							<input type="text" name="descripcion4" id="descripcion4" readonly="readonly" value="<?php echo $descripcion4; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso4" id="peso4" readonly="readonly" value="<?php echo $peso4; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor4" id="valor4"  readonly="readonly" value="<?php echo $valor4; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal4" id="subtotal4"  value="<?php echo $subtotal4; ?>">
						</td>
					</tr>
                    <?php
                    }
					if($peso5>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto5" id="idproducto5" value="<?php echo $idproducto5; ?>">
						<td colspan="1">
							<input type="text" name="descripcion5" id="descripcion5 readonly="readonly" value="<?php echo $descripcion5; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso5" id="peso5" readonly="readonly" value="<?php echo $peso5; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor5" id="valor5"  readonly="readonly" value="<?php echo $valor5; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal5" id="subtotal5"  value="<?php echo $subtotal5; ?>">
						</td>
					</tr>
                    <?php
                    }
					if($peso6>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto6" id="idproducto6" value="<?php echo $idproducto6; ?>">
						<td colspan="1">
							<input type="text" name="descripcion6" id="descripcion6" readonly="readonly" value="<?php echo $descripcion6; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso6" id="peso6" readonly="readonly" value="<?php echo $peso6; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor6" id="valor6"  readonly="readonly" value="<?php echo $valor6; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal6" id="subtotal6"  value="<?php echo $subtotal6; ?>">
						</td>
					</tr>
                    <?php                    
                     }
					 if($peso7>0)
					 {
					 ?>
					 <tr>
						 <input type="hidden" name="idproducto7" id="idproducto7" value="<?php echo $idproducto7; ?>">
						 <td colspan="1">
							 <input type="text" name="descripcion7" id="descripcion7" readonly="readonly" value="<?php echo $descripcion7; ?>">
						 </td>
						 
						 <td colspan="1">
							 <input type="number" name="peso7" id="peso7" readonly="readonly" value="<?php echo $peso7; ?>">
						 </td>
						 <td colspan="2">
							 <input type="number" name="valor7" id="valor7"  readonly="readonly" value="<?php echo $valor7; ?>">
						 </td>
						 <td colspan="2">
							 <input type="number" name="subtotal7" id="subtotal7"  value="<?php echo $subtotal7; ?>">
						 </td>
					 </tr>
					 <?php
 
                    }

                    if($peso8>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto8" id="idproducto8" value="<?php echo $idproducto8; ?>">
						<td colspan="1">
							<input type="text" name="descripcion8" id="descripcion8" readonly="readonly" value="<?php echo $descripcion8; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="peso8" id="peso8" readonly="readonly" value="<?php echo $peso8; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valor8" id="valor8"  readonly="readonly" value="<?php echo $valor8; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotal8" id="subtotal8"  value="<?php echo $subtotal8; ?>">
						</td>
					</tr>
                    <?php
                    }
                    if($peso9>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idproducto9" id="idproducto9" value="<?php echo $idproducto9; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcion9" id="descripcion9" readonly="readonly" value="<?php echo $descripcion9; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="peso9" id="peso9" readonly="readonly" value="<?php echo $peso9; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valor9" id="valor9"  readonly="readonly" value="<?php echo $valor9; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotal9" id="subtotal9"  value="<?php echo $subtotal9; ?>">
                        </td>
                    </tr>
                    <?php

                    }
                    if($pesoA>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproductoA" id="idproductoA" value="<?php echo $idproductoA; ?>">
						<td colspan="1">
							<input type="text" name="descripcionA" id="descripcionA" readonly="readonly" value="<?php echo $descripcionA; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoA" id="pesoA" readonly="readonly" value="<?php echo $pesoA; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorA" id="valorA"  readonly="readonly" value="<?php echo $valorA; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalA" id="subtotalA"  value="<?php echo $subtotalA; ?>">
						</td>
					</tr>
                    <?php
                    }
                     if($pesoB>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproductoB" id="idproductoB" value="<?php echo $idproductoB; ?>">
						<td colspan="1">
							<input type="text" name="descripcionB" id="descripcionB" readonly="readonly" value="<?php echo $descripcionB; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoB" id="pesoB" readonly="readonly" value="<?php echo $pesoB; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorB" id="valorB"  readonly="readonly" value="<?php echo $valorB; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalB" id="subtotalB"  value="<?php echo $subtotalB; ?>">
						</td>
					</tr>
                    <?php
                    }
                    
					//subproductos
					if($pesoS1>0)
					{
					?>
					<tr>
						<input type="hidden" name="idS1" id="idS1" value="<?php echo $idS1; ?>">
						<td colspan="1">
							<input type="text" name="descripcionS1" id="descripcionS1" readonly="readonly" value="<?php echo $descripcionS1; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoS1" id="pesoS1" readonly="readonly" value="<?php echo $pesoS1; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorS1" id="valorS1"  readonly="readonly" value="<?php echo $valorS1; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalS1" id="subtotalS1"  value="<?php echo $subtotalS1; ?>">
						</td>
					</tr>
                    <?php
                    }
                    if($pesoS2>0)
					{
					?>
					<tr>
						<input type="hidden" name="idS2" id="idS2" value="<?php echo $idS2; ?>">
						<td colspan="1">
							<input type="text" name="descripcionS2" id="descripcionS2" readonly="readonly" value="<?php echo $descripcionS2; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoS2" id="pesoS2" readonly="readonly" value="<?php echo $pesoS2; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorS2" id="valorS2"  readonly="readonly" value="<?php echo $valorS2; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalS2" id="subtotalS2"  value="<?php echo $subtotalS2; ?>">
						</td>
					</tr>
                    <?php
                    }
					if($pesoS3>0)
					{
					?>
					<tr>
						<input type="hidden" name="idS3" id="idS3" value="<?php echo $idS3; ?>">
						<td colspan="1">
							<input type="text" name="descripcionS3" id="descripcionS3" readonly="readonly" value="<?php echo $descripcionS3; ?>">
						</td>
						
						<td colspan="1">
							<input type="number" name="pesoS3" id="pesoS3" readonly="readonly" value="<?php echo $pesoS3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="valorS3" id="valorS3"  readonly="readonly" value="<?php echo $valorS3; ?>">
						</td>
						<td colspan="2">
							<input type="number" name="subtotalS3" id="subtotalS3"  value="<?php echo $subtotalS3; ?>">
						</td>
					</tr>
                    <?php
                    }
                    if($pesoS4>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS4" id="idS4" value="<?php echo $idS4; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS4" id="descripcionS4" readonly="readonly" value="<?php echo $descripcionS4; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS4" id="pesoS4" readonly="readonly" value="<?php echo $pesoS4; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS4" id="valorS4"  readonly="readonly" value="<?php echo $valorS4; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS4" id="subtotalS4"  value="<?php echo $subtotalS4; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($pesoS5>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS5" id="idS5" value="<?php echo $idS5; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS5" id="descripcionS5" readonly="readonly" value="<?php echo $descripcionS5; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS5" id="pesoS5" readonly="readonly" value="<?php echo $pesoS5; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS5" id="valorS5"  readonly="readonly" value="<?php echo $valorS5; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS5" id="subtotalS5"  value="<?php echo $subtotalS5; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($pesoS6>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS6" id="idS6" value="<?php echo $idS6; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS6" id="descripcionS6" readonly="readonly" value="<?php echo $descripcionS6; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS6" id="pesoS6" readonly="readonly" value="<?php echo $pesoS6; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS6" id="valorS6"  readonly="readonly" value="<?php echo $valorS6; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS6" id="subtotalS6"  value="<?php echo $subtotalS6; ?>">
                        </td>
                    </tr>
                    <?php
                    }
					if($pesoS7>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="idS7" id="idS7" value="<?php echo $idS7; ?>">
                        <td colspan="1">
                            <input type="text" name="descripcionS7" id="descripcionS7" readonly="readonly" value="<?php echo $descripcionS7; ?>">
                        </td>
                        
                        <td colspan="1">
                            <input type="number" name="pesoS7" id="pesoS7" readonly="readonly" value="<?php echo $pesoS7; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="valorS7" id="valorS7"  readonly="readonly" value="<?php echo $valorS7; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalS7" id="subtotalS7"  value="<?php echo $subtotalS7; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($art1>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="art1" id="art1" value="<?php echo $art1; ?>">
                        <td colspan="2">
                            <input type="text" name="descripcionA1" id="descripcionA1" readonly="readonly" value="<?php echo $descripcionA1; ?>">
                        </td>
                        
                        
                        <td colspan="2">
                            <input type="number" name="valorA1" id="valorA1"  readonly="readonly" value="<?php echo $valorA1; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalA1" id="subtotalA1" readonly="readonly"  value="<?php echo $subtotalA1; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($art2>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="art2" id="art2" value="<?php echo $art2; ?>">
                        <td colspan="2">
                            <input type="text" name="descripcionA2" id="descripcionA2" readonly="readonly" value="<?php echo $descripcionA2; ?>">
                        </td>
                        
                        
                        <td colspan="2">
                            <input type="number" name="valorA2" id="valorA2"  readonly="readonly" value="<?php echo $valorA2; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalA2" id="subtotalA2" readonly="readonly"  value="<?php echo $subtotalA2; ?>">
                        </td>
                    </tr>
                    <?php
                    }
                    if($art3>0)
                    {
                    ?>
                    <tr>
                        <input type="hidden" name="art3" id="art3" value="<?php echo $art3; ?>">
                        <td colspan="2">
                            <input type="text" name="descripcionA3" id="descripcionA3" readonly="readonly" value="<?php echo $descripcionA3; ?>">
                        </td>
                        
                        
                        <td colspan="2">
                            <input type="number" name="valorA3" id="valorA3"  readonly="readonly" value="<?php echo $valorA3; ?>">
                        </td>
                        <td colspan="2">
                            <input type="number" name="subtotalA3" id="subtotalA3" readonly="readonly"  value="<?php echo $subtotalA3; ?>">
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
					<td colspan="3">
							<label><h1><?php echo "Total a Cobrar   $".$total2; ?></h1></label>
					</td>
				</tr>














				
				

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Vender"></div>
				
					<label class="content-input">
						<input type="checkbox" name="credito" id="credito" value=2>Crédito
						<i></i>
					</label>

					
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Venta" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
