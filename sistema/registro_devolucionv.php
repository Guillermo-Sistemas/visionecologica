<?php

include "../conexion.php";
mysqli_set_charset($conexion,'utf8'); 

$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
$inicio1= mysqli_fetch_array($inicio);
$controlinicial=$inicio1[0];

$inicio2=mysqli_query($conexion, "select ingresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
$datoinicio=mysqli_fetch_array($inicio2);

    $ingresos= $datoinicio["ingresos"];
    $controlinicio= $datoinicio["estatus"];

    if($controlinicio==0)
    {

        mysqli_close($conexion);
        echo "<script>
                alert('No Existe un Cuadre Abierto');
                window.location= '../index.php'
            </script>";

    }else{

session_start();
	//mysqli_close();

	

	$consultaCli="SELECT * FROM cliente WHERE tipo_cliente!='temporal'";
	$resultadoC=mysqli_query($conexion, $consultaCli);
	
	$consultaPro="SELECT codproducto, descripcion FROM producto";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 
	$resultadoP1=mysqli_query($conexion, $consultaPro); 
	$resultadoP2=mysqli_query($conexion, $consultaPro);
	$resultadoP3=mysqli_query($conexion, $consultaPro); 
	$resultadoP4=mysqli_query($conexion, $consultaPro);
	$resultadoP5=mysqli_query($conexion, $consultaPro); 
	 
	
	$motivo="Otros";
    

	mysqli_close($conexion);

?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Devolución Venta</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="container">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Registrar Devolución de Venta</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="procesar_devolucionv.php" method="POST">
					
					<div class="wd20">
						<h4>Datos del Cliente</h4>
					</div>
					<div class="wd20">
						<label>Nombre</label>	
							<select id="id_cliente" name="id_cliente">
								<?php 
									WHILE($row=$resultadoC->fetch_assoc()){  
								?>
								<option value="<?php echo $row['idcliente']; ?>"><?php echo $row['nombrec']; ?></option>
								<?php } ?>
        					</select>
					</div>

					
					
					<div id="div_registro_cliente2" class="wd30">
					<button  type="button" onclick="location.href='registro_tercero.php'" class="btn_crear"><i class="fas fa-plus"></i>Nuevo Cliente</button>
					</div>

					<div class="wd100">
						<h4>Detalle de la Devolución</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1" style="width:120px;">Descripción</th>
					<th colspan="3" style="width:80px;">Peso/Kilos</th>
					<th colspan="1" style="width:120px;">Descripción</th>
					<th colspan="3" style="width:80px;">Peso/Kilos</th>
					<th colspan="1" style="width:120px;">Descripción</th>
					<th colspan="3" style="width:80px;">Peso/Kilos</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">
				<tr>
					<td style="width:120px;">
						<select id="cbx_prod0" name="cbx_prod0">
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:140px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso01"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso02"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso03"></div>
					</td>


					<td style="width:120px;">
						<select id="cbx_prod1" name="cbx_prod1">
								<?php 
									WHILE($row=$resultadoP1->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:140px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso11"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso12"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso13"></div>
					</td>


					<td style="width:120px;">
						<select id="cbx_prod2" name="cbx_prod2">
								<?php 
									WHILE($row=$resultadoP2->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:140px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso21"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso22"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso23"></div>
					</td>



				</tr>



				<tr>
					


					<td style="width:120px;">
						<select id="cbx_prod3" name="cbx_prod3">
								<?php 
									WHILE($row=$resultadoP3->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso31"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso32"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso33"></div>
					</td>
				
					<td style="width:120px;">
						<select id="cbx_prod4" name="cbx_prod4">
								<?php 
									WHILE($row=$resultadoP4->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso41"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso42"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso43"></div>
					</td>


					<td style="width:120px;">
						<select id="cbx_prod5" name="cbx_prod5">
								<?php 
									WHILE($row=$resultadoP5->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso51"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso52"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="hidden" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso53"></div>
					</td>
				</tr>

				<tr>

				<td colspan="4"><label for="motivo">Motivo de Devolución</label></td>
				<td colspan="8"><select name="motivo" id="motivo" value="<?php echo $motivo; ?>">  
							<option value="Otros">Otros</option>
							<option value="Cliente en Desacuerdo con el Precio">Cliente en Desacuerdo con el Precio</option>
							<option value="Error en el Precio Liquidado">Error en el Precio Liquidado</option>
							<option value="Error de Digitación">Error de Digitación</option>
							<option value="Producto Sucio">Producto Sucio</option>
					</select></td>

				</tr>




				


					
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Procesar Devolución"></div>

					<div class="wd30"><input type="reset" class="btn_limpiar" value="Limpiar Devolución"></div>
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Devolución" name="boton" class="btn_anular"  /></div>


		

			</form>
	</div>
			

		
	</section>
		
</body>
</html>

<?php
}
?>
