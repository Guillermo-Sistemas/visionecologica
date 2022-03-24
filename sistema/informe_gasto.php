<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;

	$tercero="SIN TERCERO";
	$bandera=1;
	$tipo="";

	$consultatercero="SELECT idcliente, nombrec FROM cliente ORDER BY nombrec";
	$resultadoter=mysqli_query($conexion, $consultatercero);
	
	$consultatipo="SELECT idtipogasto, nombregasto FROM tipo_gasto ORDER BY nombregasto";
	$resultadotipo=mysqli_query($conexion, $consultatipo); 


	$totalgasto=0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Busqueda de Gastos</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	<link rel="stylesheet" type="text/css" href="css/tcal.css" />
    <script type="text/javascript" src="js/tcal.js"></script> 
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";

		//echo "acaasito".$tercero;
	?>
	
	<section class="contenido">
			<h1>Generar Informe de Gastos</h1>
           
			<form action="pdfGasto.php" target="_blank" method="post" class="form_search">

			<select id="tipo" name="tipo"><option value="">Tipo de Gasto</option>
								<?php 
									WHILE($row=$resultadotipo->fetch_assoc()){  
								?>
								<option value="<?php echo $row['idtipogasto']; ?>"><?php echo $row['nombregasto']; ?></option>
								<?php } ?>
				</select>
				
				<select id="tercero" name="tercero"><option value="">Tercero</option>
								<?php 
									WHILE($row=$resultadoter->fetch_assoc()){  
								?>
								<option value="<?php echo $row['idcliente']; ?>"><?php echo $row['nombrec']; ?></option>
								<?php } ?>
				</select>
				<input type="text" name="desde" id="desde" class="tcal" placeholder="desde">
				<input type="text" name="hasta" id="hasta" class="tcal" placeholder="hasta">
				<input type="submit" value="Generar" class="btn_search">
			</form>

			


            
			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
