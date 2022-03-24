<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();


	//$idcliente=$_POST['cbx_cliente'];

	//echo "$idcliente";
	$remision="";
	$nuevocliente="";

	$idcliente=$_POST['idcliente'];
	$nomcliente=$_POST['nomcliente'];
	
	if (!empty($_POST['remision']))
		$remision=$_POST['remision'];
	if (!empty($_POST['nuevocliente']))
		$nuevocliente=$_POST['nuevocliente'];

	$ajuste=0;
	

	$idproducto0=0; $cantidades0=""; $peso0=0; $valor0=0; $subtotal0=0;
	$idproducto1=0; $cantidades1=""; $peso1=0; $valor1=0; $subtotal1=0;
    $idproducto2=0; $cantidades2=""; $peso2=0; $valor2=0; $subtotal2=0;
    $idproducto3=0; $cantidades3=""; $peso3=0; $valor3=0; $subtotal3=0;
    $idproducto4=0; $cantidades4=""; $peso4=0; $valor4=0; $subtotal4=0;
    $idproducto5=0; $cantidades5=""; $peso5=0; $valor5=0; $subtotal5=0;
    $idproducto6=0; $cantidades6=""; $peso6=0; $valor6=0; $subtotal6=0;
    $idproducto7=0; $cantidades7=""; $peso7=0; $valor7=0; $subtotal7=0;
    $idproducto8=0; $cantidades8=""; $peso8=0; $valor8=0; $subtotal8=0;
    $idproducto9=0; $cantidades9=""; $peso9=0; $valor9=0; $subtotal9=0;
    $idproductoA=0; $cantidadesA=""; $pesoA=0; $valorA=0; $subtotalA=0;
    $idproductoB=0; $cantidadesB=""; $pesoB=0; $valorB=0; $subtotalB=0;
	//echo $_POST['idproducto0'];

	if (!empty($_POST['total_peso0'])){ 
	    $idproducto0=$_POST['idproducto0'];
		$descripcion0=$_POST['descripcion0'];
		$cantidades0=$_POST['cantidades0'];
		$peso0=$_POST['total_peso0'];
		$valor0=$_POST['valor_compra0'];
		$subtotal0=$peso0*$valor0;
	}

	if (!empty($_POST['total_peso1'])){ 
	    $idproducto1=$_POST['idproducto1'];
		$descripcion1=$_POST['descripcion1'];
		$cantidades1=$_POST['cantidades1'];
		$peso1=$_POST['total_peso1'];
		$valor1=$_POST['valor_compra1'];
		$subtotal1=$peso1*$valor1;
	}

    if (!empty($_POST['total_peso2'])){ 
	    $idproducto2=$_POST['idproducto2'];
		$descripcion2=$_POST['descripcion2'];
		$cantidades2=$_POST['cantidades2'];
		$peso2=$_POST['total_peso2'];
		$valor2=$_POST['valor_compra2'];
		$subtotal2=$peso2*$valor2;
	}

    if (!empty($_POST['total_peso3'])){ 
	    $idproducto3=$_POST['idproducto3'];
		$descripcion3=$_POST['descripcion3'];
		$cantidades3=$_POST['cantidades3'];
		$peso3=$_POST['total_peso3'];
		$valor3=$_POST['valor_compra3'];
		$subtotal3=$peso3*$valor3;
	}

    if (!empty($_POST['total_peso4'])){ 
	    $idproducto4=$_POST['idproducto4'];
		$descripcion4=$_POST['descripcion4'];
		$cantidades4=$_POST['cantidades4'];
		$peso4=$_POST['total_peso4'];
		$valor4=$_POST['valor_compra4'];
		$subtotal4=$peso4*$valor4;
	}

    if (!empty($_POST['total_peso5'])){ 
	    $idproducto5=$_POST['idproducto5'];
		$descripcion5=$_POST['descripcion5'];
		$cantidades5=$_POST['cantidades5'];
		$peso5=$_POST['total_peso5'];
		$valor5=$_POST['valor_compra5'];
		$subtotal5=$peso5*$valor5;
	}

    if (!empty($_POST['total_peso6'])){ 
	    $idproducto6=$_POST['idproducto6'];
		$descripcion6=$_POST['descripcion6'];
		$cantidades6=$_POST['cantidades6'];
		$peso6=$_POST['total_peso6'];
		$valor6=$_POST['valor_compra6'];
		$subtotal6=$peso6*$valor6;
	}

     if (!empty($_POST['total_peso7'])){ 
	    $idproducto7=$_POST['idproducto7'];
		$descripcion7=$_POST['descripcion7'];
		$cantidades7=$_POST['cantidades7'];
		$peso7=$_POST['total_peso7'];
		$valor7=$_POST['valor_compra7'];
		$subtotal7=$peso7*$valor7;
	}

     if (!empty($_POST['total_peso8'])){ 
	    $idproducto8=$_POST['idproducto8'];
		$descripcion8=$_POST['descripcion8'];
		$cantidades8=$_POST['cantidades8'];
		$peso8=$_POST['total_peso8'];
		$valor8=$_POST['valor_compra8'];
		$subtotal8=$peso8*$valor8;
	}

    if (!empty($_POST['total_peso9'])){ 
	    $idproducto9=$_POST['idproducto9'];
		$descripcion9=$_POST['descripcion9'];
		$cantidades9=$_POST['cantidades9'];
		$peso9=$_POST['total_peso9'];
		$valor9=$_POST['valor_compra9'];
		$subtotal9=$peso9*$valor9;
	}

    if (!empty($_POST['total_pesoA'])){ 
	    $idproductoA=$_POST['idproductoA'];
		$descripcionA=$_POST['descripcionA'];
		$cantidadesA=$_POST['cantidadesA'];
		$pesoA=$_POST['total_pesoA'];
		$valorA=$_POST['valor_compraA'];
		$subtotalA=$pesoA*$valorA;
	}

    if (!empty($_POST['total_pesoB'])){ 
	    $idproductoB=$_POST['idproductoB'];
		$descripcionB=$_POST['descripcionB'];
		$cantidadesB=$_POST['cantidadesB'];
		$pesoB=$_POST['total_pesoB'];
		$valorB=$_POST['valor_compraB'];
		$subtotalB=$pesoB*$valorB;
	}

	

	$total=$subtotal0+$subtotal1+$subtotal2+$subtotal3+$subtotal4+$subtotal5+$subtotal6+$subtotal7+$subtotal8+$subtotal9+$subtotalA+$subtotalB;
    $total=round($total);

	$modulo=$total%100;

	//echo $modulo;

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
	
	
	
		
	
	
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Calcular Compra</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Calcular Compra</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="Comprar.php"
						onsubmit="return confirmation()" method="POST">
					

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
						<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $idproducto0; ?>">
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
						<input type="hidden" name="idproducto1" id="idproducto1" value="<?php echo $idproducto1; ?>">
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
					if($peso2 >0 )
					{
					
						?>
						<tr>
							
							<input type="hidden" name="idproducto2" id="idproducto2" value="<?php echo $idproducto2; ?>">
							
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
								<input type="text" name="valor2" id="valor2" value="<?php echo $valor2; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal2" id="subtotal2" readonly="readonly" value="<?php echo $subtotal2; ?>">
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
					if($peso4>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto4" id="idproducto4" value="<?php echo $idproducto4; ?>">
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
					if($peso5>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto5" id="idproducto5" value="<?php echo $idproducto5; ?>">
						<td colspan="1">
							<input type="text" name="descripcion5" id="descripcion5 readonly="readonly" value="<?php echo $descripcion5; ?>">
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
					if($peso6>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto6" id="idproducto6" value="<?php echo $idproducto6; ?>">
						<td colspan="1">
							<input type="text" name="descripcion6" id="descripcion6 readonly="readonly" value="<?php echo $descripcion6; ?>">
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
                    if($peso7>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto7" id="idproducto7" value="<?php echo $idproducto7; ?>">
						<td colspan="1">
							<input type="text" name="descripcion7" id="descripcion7 readonly="readonly" value="<?php echo $descripcion7; ?>">
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
                    if($peso8>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto8" id="idproducto8" value="<?php echo $idproducto8; ?>">
						<td colspan="1">
							<input type="text" name="descripcion8" id="descripcion8 readonly="readonly" value="<?php echo $descripcion8; ?>">
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
                    if($peso9>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproducto9" id="idproducto9" value="<?php echo $idproducto9; ?>">
						<td colspan="1">
							<input type="text" name="descripcion9" id="descripcion9 readonly="readonly" value="<?php echo $descripcion9; ?>">
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
                    if($pesoA>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproductoA" id="idproductoA" value="<?php echo $idproductoA; ?>">
						<td colspan="1">
							<input type="text" name="descripcionA" id="descripcionA readonly="readonly" value="<?php echo $descripcionA; ?>">
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
                    if($pesoB>0)
					{
					?>
					<tr>
						<input type="hidden" name="idproductoB" id="idproductoB" value="<?php echo $idproductoB; ?>">
						<td colspan="1">
							<input type="text" name="descripcionB" id="descripcionB readonly="readonly" value="<?php echo $descripcionB; ?>">
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
					<td colspan="3">
							<label><h1><?php echo "Total a Pagar   $".$total; ?></h1></label>
					</td>
				</tr>

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="COMPRAR"></div>

					<label class="content-input">
						<input type="checkbox" name="credito" id="credito" value=2>Crédito
						<i></i>
					</label>
				
					
					<div class="wd30"><input type="button" onclick="ConfirmDemo()"  
					                value="Cancelar Compra" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		

	<script type="text/javascript">
     function confirmation() 
     {
        if(confirm("Esta Seguro de Realizar la Compra por Valor de <?php echo $total; ?>?"))
	{
	   return true;
	}
	else
	{
	   return false;
	}
     }
    </script>


<script type="text/javascript">
function ConfirmDemo() {
//Ingresamos un mensaje a mostrar
var mensaje = confirm("¿Desea Cancelar la Compra?");
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
	window.location.href='nueva_compra.php';
}
//Detectamos si el usuario denegó el mensaje
else {
	return false;
}
}
</script>




</body>
</html>
