<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;

	$tercero="SIN TERCERO";
	$bandera=1;
	$tipo="";

	$consultatercero="SELECT idcliente, nombrec FROM cliente";
	$resultadoter=mysqli_query($conexion, $consultatercero);
	
	$consultatipo="SELECT idtipogasto, nombregasto FROM tipo_gasto";
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
	<title>Busqueda de Gastos por Periodo</title>
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
			<h1>Generar Informe de Gastos por Periodo</h1>
           
			<form action="pdfGasto.php" target="_blank" method="post" class="form_search">

			
				<input type="text" name="desde" id="desde" class="tcal" placeholder="desde">
				<input type="text" name="hasta" id="hasta" class="tcal" placeholder="hasta">
				<input type="submit" value="Generar" class="btn_search">
			</form>

			


            
			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
