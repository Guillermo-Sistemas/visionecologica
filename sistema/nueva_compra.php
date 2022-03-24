<?php

include "../conexion.php";
mysqli_set_charset($conexion,'utf8'); 

$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
$inicio1= mysqli_fetch_array($inicio);
$controlinicial=$inicio1[0];

$inicio2=mysqli_query($conexion, "select egresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
$datoinicio=mysqli_fetch_array($inicio2);

    $egresos= $datoinicio["egresos"];
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

	

	$consultaCli="SELECT * FROM cliente WHERE tipo_cliente='Recuperador' OR 
				tipo_cliente='Recuperador-Comprador' 
				OR tipo_cliente='Proveedor' and estatus=1 ";
	$resultadoC=mysqli_query($conexion, $consultaCli);
	
	$consultaPro="SELECT codproducto, descripcion FROM producto";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 
	$resultadoP1=mysqli_query($conexion, $consultaPro); 
	$resultadoP2=mysqli_query($conexion, $consultaPro);
	$resultadoP3=mysqli_query($conexion, $consultaPro); 
	$resultadoP4=mysqli_query($conexion, $consultaPro);
	$resultadoP5=mysqli_query($conexion, $consultaPro); 
	$resultadoP6=mysqli_query($conexion, $consultaPro);
	$resultadoP7=mysqli_query($conexion, $consultaPro); 
	$resultadoP8=mysqli_query($conexion, $consultaPro);
	$resultadoP9=mysqli_query($conexion, $consultaPro);
    $resultadoPA=mysqli_query($conexion, $consultaPro); 
    $resultadoPB=mysqli_query($conexion, $consultaPro);  
    

	mysqli_close($conexion);

?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Registrar Compra</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="container">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Registrar Compra</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="procesar_Compra.php" method="POST">
					
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

					<div class="wd20">
						<label>Remisi�n</label>	
						<input style="font-size:18px;  maxlength="5" 
						 name="remision">
							
					</div>
					
					<div id="div_registro_cliente2" class="wd30">
					<button  type="button" onclick="location.href='registro_tercero.php'" class="btn_crear"><i class="fas fa-plus"></i>Nuevo Cliente</button>
					</div>

					<div class="wd100">
						<h4>Detalle de la Compra</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1" style="width:120px;">Descripci�n</th>
					<th colspan="3" style="width:80px;">Peso/Kilos</th>
					<th colspan="1" style="width:120px;">Descripci�n</th>
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
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso01"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso02"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
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
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso11"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso12"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso13"></div>
					</td>
				</tr>



				<tr>
					<td style="width:120px;">
						<select id="cbx_prod2" name="cbx_prod2">
								<?php 
									WHILE($row=$resultadoP2->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso21"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso22"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso23"></div>
					</td>


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
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso32"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso33"></div>
					</td>
				</tr>





				<tr>
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
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso42"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
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
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso52"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso53"></div>
					</td>
				</tr>




				<tr>
					<td style="width:120px;">
						<select id="cbx_prod6" name="cbx_prod6">
								<?php 
									WHILE($row=$resultadoP6->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso61"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso62"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso63"></div>
					</td>


					<td style="width:120px;">
						<select id="cbx_prod7" name="cbx_prod7">
								<?php 
									WHILE($row=$resultadoP7->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso71"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso72"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso73"></div>
					</td>
				</tr>

                <tr>
					<td style="width:120px;">
						<select id="cbx_prod8" name="cbx_prod8">
								<?php 
									WHILE($row=$resultadoP8->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso81"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso82"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso83"></div>
					</td>


					<td style="width:120px;">
						<select id="cbx_prod9" name="cbx_prod9">
								<?php 
									WHILE($row=$resultadoP9->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso91"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso92"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="peso93"></div>
					</td>
				</tr>

                <tr>
					<td style="width:120px;">
						<select id="cbx_prodA" name="cbx_prodA">
								<?php 
									WHILE($row=$resultadoPA->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="pesoA1"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="pesoA2"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="pesoA3"></div>
					</td>


					<td style="width:120px;">
						<select id="cbx_prodB" name="cbx_prodB">
								<?php 
									WHILE($row=$resultadoPB->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="pesoB1"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="pesoB2"></div>
					</td>
					<td colspan="1" style="width:80px;">
							<div class="wd100"><input type="number" min="0" step="any" style="font-size:18px;  maxlength="5" 
							onkeypress="return filterFloat(event,this);" name="pesoB3"></div>
					</td>
				</tr>



				




				

				




				

				


				














			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Procesar Compra"></div>

					<div class="wd30"><input type="reset" class="btn_limpiar" value="Limpiar Compra"></div>
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Compra" name="boton" class="btn_anular"  /></div>


		

			</form>
	</div>
			

		
	</section>
		
</body>
</html>

<?php
}
?>
