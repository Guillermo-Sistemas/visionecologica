<?php
    session_start();
    include "../conexion.php";

	if($_SESSION['rol']!=1)
    {
	header('location:../');
    }

	$controlinicial=0;
	$tipo="Efectivo";
	$tipos="Efectivo";
	$entefe=0;
	$entcon=0;
	$salefe=0;
	$salcon=0;
	$valent2=0;
	$valsal2=0;

	date_default_timezone_set('America/Bogota');
	$actual = Date("Y-m-d");

	$inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

	//echo $controlinicial;

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Movimientos de la Caja</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Movimientos de la Caja</h1>
			
            <!--<a href="nueva_compra.php" class="btn_new"></i> Registrar Compra</a>

			<form action="buscar_compra.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">
			</form>-->

			


            <table>
			<h1>Entradas</h1>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>Fecha</th>
		    		<th>Valor</th>
                    <th>Descripción</th>
					<th>Tipo</th>
		    	</tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM entrada WHERE idcaja=$controlinicial" );
				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=20;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);




                    $query=mysqli_query($conexion,"SELECT * FROM entrada WHERE estatus=1 and  
												 idcaja=$controlinicial
												 LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["fecha"]; ?></td>
							<?php
							$valent2=$data["valorentrada"];
							$valent=number_format($data["valorentrada"], 0, ",", ".");
							?>
							<td><?php echo $valent; ?></td>
							<td><?php echo $data["descripcion"]; ?></td>
							

							<?php
							$tipo="Efectivo";
							if ($data["tipoentrada"]==2){
								$tipo="Consignación";
								$entcon=$entcon+$valent2;
							}else{
								$entefe=$entefe+$valent2;
							}

								
							?>

							<td><?php echo $tipo; ?></td>
							
                        </tr>
				<?php
						}
					}
				?>
	        
            </table>
			<br>
			<h1>Entradas en Efectivo $ <?php 
			$entefe=number_format($entefe, 0, ",", ".");
			echo $entefe ?></h1>
			<h1>Entradas en Consignación $ <?php 
			$entcon=number_format($entcon, 0, ",", ".");
			echo $entcon ?></h1>






			<br>
			<table>
			<h1>Salidas</h1>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>Fecha</th>
		    		<th>Valor</th>
                    <th>Descripción</th>
					<th>Tipo</th>
		    	</tr>

				<?php

				



                    $query=mysqli_query($conexion,"SELECT * FROM salida WHERE estatus_s=1 and  
												 idcaja=$controlinicial
												 LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["fecha"]; ?></td>


							<?php
							$valent3=$data["valorsalida"];
							$valsal=number_format($data["valorsalida"], 0, ",", ".");
							?>

							<td><?php echo $valsal; ?></td>
							<td><?php echo $data["descripcion_s"]; ?></td>
							

							<?php
							$tipos="Efectivo";
							if ($data["tiposalida"]==2){
								$tipos="Consignación";
								$salcon=$salcon+$valent3;
							}else{
								$salefe=$salefe+$valent3;
							}
								
							?>

							<td><?php echo $tipos; ?></td>
							
                        </tr>
				<?php
						}
					}
				?>
	        
            </table>

			<br>
			<h1>Salidas en Efectivo $ <?php 
			$salefe=number_format($salefe, 0, ",", ".");
			echo $salefe ?></h1>
			<h1>Salidas en Consignación $ <?php 
			$salcon=number_format($salcon, 0, ",", ".");
			echo $salcon ?></h1>









			<!--<div class="paginador">
				<ul>
				<?php
					if($pagina!=1){
				?>

					<li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
					<li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
				<?php
					}
					for($i=1; $i<=$total_paginas; $i++) { 
						if($i==$pagina){ 
							echo'<li class="pageSelected">'.$i.'</a></li>';
						}else{ 
							echo'<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
						}
						
					}

					if($pagina!=$total_paginas){
				?>
					
					
					<li><a href="?pagina=<?php echo $pagina+1;?> ">>></a></li>
					<li><a href="?pagina=<?php echo $total_paginas;?>">>|</a></li>
					<?php } ?>			

				</ul>
			</div>-->


			
	</section>
		
</body>
</html>
