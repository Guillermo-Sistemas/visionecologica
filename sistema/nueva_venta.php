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

    if($_SESSION['rol']<1)
    {
	header('location:../');
    }

	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	$consultaCli="SELECT idcliente, nombrec FROM cliente WHERE tipo_cliente!='temporal' and estatus=1 ";
	$resultadoC=mysqli_query($conexion, $consultaCli);
	
	$consultaPro="SELECT codproducto, descripcion FROM producto WHERE estatus=1";
    $consultaSub="SELECT codsubproducto, nombre_subpro FROM subproducto WHERE estatus_subpro=1";
	$consultaArt="SELECT codrecuperado, descripcion_recuperado FROM recuperado WHERE estatus=1";

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

	$resultadoS0=mysqli_query($conexion, $consultaSub); 
	$resultadoS1=mysqli_query($conexion, $consultaSub); 
	$resultadoS2=mysqli_query($conexion, $consultaSub);
	$resultadoS3=mysqli_query($conexion, $consultaSub); 
	$resultadoS4=mysqli_query($conexion, $consultaSub);
	$resultadoS5=mysqli_query($conexion, $consultaSub); 
	$resultadoS6=mysqli_query($conexion, $consultaSub);
	$resultadoS7=mysqli_query($conexion, $consultaSub);

	$resultadoA0=mysqli_query($conexion, $consultaArt); 
	$resultadoA1=mysqli_query($conexion, $consultaArt); 
	$resultadoA2=mysqli_query($conexion, $consultaArt); 
	$resultadoA3=mysqli_query($conexion, $consultaArt);

	mysqli_close($conexion);


	

?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Registrar Venta</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-shopping-cart"></i></i>Registrar Venta</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="procesar_venta.php" method="POST">
					<input type="hidden" name="action" value="addCliente">
					<input type="hidden" id="idcliente" name="idcliente" value="" required>
					<div class="wd20">
						<h4>Datos del Cliente</h4>
					</div>
					<div class="wd20">
						<label>Nombre</label>	


							<select id="cbx_cliente" name="cbx_cliente">
            				<?php 
								WHILE($row=$resultadoC->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['idcliente']; ?>"><?php echo $row['nombrec']; ?></option>
            				<?php } ?>
        					</select>
					</div>

					<div class="wd20">
						<label>Remisión</label>	
						<input style="font-size:18px;  maxlength="5" 
						 name="remision">
							
					</div>
					
					<div id="div_registro_cliente2" class="wd30">
					<button  type="button" onclick="location.href='registro_tercero.php'" class="btn_crear"><i class="fas fa-plus"></i>Nuevo Cliente</button>
					</div>

					<div class="wd100">
						<h4>Detalle de la Venta</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="2">Descripción</th>
					<th colspan="2">Peso</th>
					<th colspan="2">Descripción</th>
					<th colspan="2">Peso</th>
					<th colspan="2">Descripción</th>
					<th colspan="2">Peso</th>
					<th colspan="2">Descripción</th>
					<th colspan="2">Peso</th>

									
				</tr>
			</thead>
			<tbody id="detalle_venta">
				
				<tr>
					<td colspan="2">
						<select id="cbx_prod0" name="cbx_prod0">
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso0"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod1" name="cbx_prod1">
            				<?php 
								WHILE($row=$resultadoP1->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso1"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod2" name="cbx_prod2">
            				<?php 
								WHILE($row=$resultadoP2->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso2"></div>
					</td>
					<td colspan="2">
						<select id="cbx_prod3" name="cbx_prod3">
								<?php 
									WHILE($row=$resultadoP3->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso3"></div>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<select id="cbx_prod4" name="cbx_prod4">
								<?php 
									WHILE($row=$resultadoP4->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso4"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod5" name="cbx_prod5">
            				<?php 
								WHILE($row=$resultadoP5->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso5"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod6" name="cbx_prod6">
            				<?php 
								WHILE($row=$resultadoP6->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso6"></div>
					</td>
					<td colspan="2">
						<select id="cbx_prod7" name="cbx_prod7">
								<?php 
									WHILE($row=$resultadoP7->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso7"></div>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<select id="cbx_prod8" name="cbx_prod8">
								<?php 
									WHILE($row=$resultadoP8->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso8"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod9" name="cbx_prod9">
            				<?php 
								WHILE($row=$resultadoP9->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso9"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prodA" name="cbx_prodA">
            				<?php 
								WHILE($row=$resultadoPA->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="pesoA"></div>
					</td>
					<td colspan="2">
						<select id="cbx_prodB" name="cbx_prodB">
								<?php 
									WHILE($row=$resultadoPB->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="pesoB"></div>
					</td>
				</tr>

				<tr>
					<td colspan="4">
									<h4><center>Subproductos</center></h4>
					</td>

					<td colspan="2">
					<select id="cbx_sub1" name="cbx_sub1">
            				<?php 
								WHILE($row=$resultadoS1->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="pesoS1"></div>
					</td>

					<td colspan="2">
					<select id="cbx_sub2" name="cbx_sub2">
            				<?php 
								WHILE($row=$resultadoS2->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="pesoS2"></div>
					</td>
					<td colspan="2">
						<select id="cbx_sub3" name="cbx_sub3">
								<?php 
									WHILE($row=$resultadoS3->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="pesoS3"></div>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<select id="cbx_sub4" name="cbx_sub4">
								<?php 
									WHILE($row=$resultadoS4->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="pesoS4"></div>
					</td>

					<td colspan="2">
					<select id="cbx_sub5" name="cbx_sub5">
            				<?php 
								WHILE($row=$resultadoS5->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="pesoS5"></div>
					</td>

					<td colspan="2">
					<select id="cbx_sub6" name="cbx_sub6">
            				<?php 
								WHILE($row=$resultadoS6->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="pesoS6"></div>
					</td>

					<td colspan="2">
					<select id="cbx_sub7" name="cbx_sub7">
            				<?php 
								WHILE($row=$resultadoS7->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codsubproducto']; ?>"><?php echo $row['nombre_subpro']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="pesoS7"></div>
					</td>
				</tr>


				<tr>
					<td colspan="4">
									<h4><center>Recuperados</center></h4>
					</td>
					<td colspan="4">
						<select id="cbx_art1" name="cbx_art1">
								<option >Seleccione Artículo</option>
								<?php 
									WHILE($row=$resultadoA1->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codrecuperado']; ?>"><?php echo $row['descripcion_recuperado']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="4">
						<select id="cbx_art2" name="cbx_art2">
						<option >Seleccione Artículo</option>
								<?php 
									WHILE($row=$resultadoA2->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codrecuperado']; ?>"><?php echo $row['descripcion_recuperado']; ?></option>
								<?php } ?>
						</select>
					</td>
					<td colspan="4">
                        <select id="cbx_art3" name="cbx_art3">
                                <option >Seleccione Artículo</option>
                                <?php 
                                    WHILE($row=$resultadoA3->fetch_assoc()){  
                                ?>
                                <option value="<?php echo $row['codrecuperado']; ?>"><?php echo $row['descripcion_recuperado']; ?></option>
                                <?php } ?>
                        </select>
                    </td>

				</tr>

				


				









				














			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Procesar Venta"></div>
				
					<div class="wd30"><input type="reset" class="btn_anular" value="Cancelar Venta"></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>


<?php
}
?>
