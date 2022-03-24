<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;
	$pesotoacu=0; $totalcomacu=0;

	


	$consultaPro="SELECT codproducto, descripcion FROM producto";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Informe Compras por Producto</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	<link rel="stylesheet" type="text/css" href="css/tcal.css" />
    <script type="text/javascript" src="js/tcal.js"></script> 
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Informe Compras por Producto</h1>
           
			<form  method="post" target="_blank" class="form_search" action="pdfComprasProducto.php">
				
				<select id="producto" name="producto"><option value="">Producto</option>
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
								?>
								<option value="<?php echo $row['descripcion']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
				</select>
				<input type="text" name="desde" id="desde" class="tcal" placeholder="desde">
				<input type="text" name="hasta" id="hasta" class="tcal" placeholder="hasta">
				<input type="submit" value="Imprimir Informe" class="btn_search">

					
			</form>

			


            		

				</ul>
			</div>


			
	</section>
		
</body>
</html>
