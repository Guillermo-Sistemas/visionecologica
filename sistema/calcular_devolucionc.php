<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();


	//$idcliente=$_POST['cbx_cliente'];

	//echo "$idcliente";
	
	$nuevocliente="";

	$idcliente=$_POST['idcliente'];
	$nomcliente=$_POST['nomcliente'];

	$motivo=$_POST['motivo'];
	
	
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
		$peso0=$_POST['total_peso0'];
		$valor0=$_POST['valor_compra0'];
		$subtotal0=$peso0*$valor0;
	}

	if (!empty($_POST['total_peso1'])){ 
	    $idproducto1=$_POST['idproducto1'];
		$descripcion1=$_POST['descripcion1'];
		$peso1=$_POST['total_peso1'];
		$valor1=$_POST['valor_compra1'];
		$subtotal1=$peso1*$valor1;
	}

    if (!empty($_POST['total_peso2'])){ 
	    $idproducto2=$_POST['idproducto2'];
		$descripcion2=$_POST['descripcion2'];
		$peso2=$_POST['total_peso2'];
		$valor2=$_POST['valor_compra2'];
		$subtotal2=$peso2*$valor2;
	}

    if (!empty($_POST['total_peso3'])){ 
	    $idproducto3=$_POST['idproducto3'];
		$descripcion3=$_POST['descripcion3'];
		$peso3=$_POST['total_peso3'];
		$valor3=$_POST['valor_compra3'];
		$subtotal3=$peso3*$valor3;
	}

    if (!empty($_POST['total_peso4'])){ 
	    $idproducto4=$_POST['idproducto4'];
		$descripcion4=$_POST['descripcion4'];
		$peso4=$_POST['total_peso4'];
		$valor4=$_POST['valor_compra4'];
		$subtotal4=$peso4*$valor4;
	}

    if (!empty($_POST['total_peso5'])){ 
	    $idproducto5=$_POST['idproducto5'];
		$descripcion5=$_POST['descripcion5'];
		$peso5=$_POST['total_peso5'];
		$valor5=$_POST['valor_compra5'];
		$subtotal5=$peso5*$valor5;
	}

    
	

	$total=$subtotal0+$subtotal1+$subtotal2+$subtotal3+$subtotal4+$subtotal5;
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
	<title>Calcular Devolución</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Calcular Devolución de Compra</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="Devolverc.php"
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
						}
						?>



						
						
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
						<input type="hidden" name="idproducto0" id="idproducto0" value="<?php echo $idproducto0; ?>">
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
							<input type="text" name="subtotal0" id="subtotal0"  readonly="readonly" value="<?php echo $subtotal0; ?>">
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
							<input type="text" name="peso1" id="peso1" readonly="readonly" value="<?php echo $peso1; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="valor1" id="valor1" readonly="readonly" value="<?php echo $valor1; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="subtotal1" id="subtotal1" readonly="readonly"  value="<?php echo $subtotal1; ?>">
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
								<input type="text" name="peso2" id="peso2" readonly="readonly" value="<?php echo $peso2; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="valor2" id="valor2" value="<?php echo $valor2; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="subtotal2" id="subtotal2" readonly="readonly"  value="<?php echo $subtotal2; ?>">
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
							<input type="text" name="peso3" id="peso3" readonly="readonly" value="<?php echo $peso3; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="valor3" id="valor3" readonly="readonly" value="<?php echo $valor3; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="subtotal3" id="subtotal3" readonly="readonly"  value="<?php echo $subtotal3; ?>">
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
							<input type="text" name="peso4" id="peso4" readonly="readonly" value="<?php echo $peso4; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="valor4" id="valor4" readonly="readonly" value="<?php echo $valor4; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="subtotal4" id="subtotal4" readonly="readonly"  value="<?php echo $subtotal4; ?>">
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
							<input type="text" name="peso5" id="peso5" readonly="readonly" value="<?php echo $peso5; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="valor5" id="valor5" readonly="readonly" value="<?php echo $valor5; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="subtotal5" id="subtotal5" readonly="readonly"  value="<?php echo $subtotal5; ?>">
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
					</td>

					
					<td colspan="1">
						</td>
					<td colspan="1">
						</td>

					</tr>
                   


				
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
							<label><h1><?php echo "Total a Recibir   $".$total; ?></h1></label>
					</td>
				</tr>

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Ejecutar Devolución"></div>

					
				
					
					<div class="wd30"><input type="button" onclick="ConfirmDemo()"  
					                value="Cancelar Devolución" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		

	<script type="text/javascript">
     function confirmation() 
     {
		 
        if(confirm("Esta Seguro de Realizar la Devolución por Valor de <?php echo $total2; ?>?"))
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
var mensaje = confirm("¿Desea Cancelar la Devolución?");
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
	window.location.href='registro_devolucionc.php';
}
//Detectamos si el usuario denegó el mensaje
else {
	return false;
}
}
</script>




</body>
</html>
