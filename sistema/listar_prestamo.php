<?php

include "../conexion.php";

    session_start();

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }

	   
			?>

			<!DOCTYPE html>
			<html lang="es">
			<head>
				<meta charset="UTF-8">
				<?php
					include "include/scripts.php";
				?>
				<title>Lista de Prestamos</title>
				<link rel="shortcut icon" href="imagenes/icono.ico">
				
			</head>
			<body>
				<?php
					include "include/header.php";
					include "include/nav.php";
				?>
				
				<section class="contenido">
						<h1>Lista de Prestamos</h1>
						
						<<!--form action="buscar_prestamo.php" method="get" class="form_search">
							<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
							<input type="submit" value="buscar" class="btn_search">
						</form>-->


						<table>
							<tr>
								<th>EMPLEADO</th>
								<th>VALOR ADEUDADO</th>
								<th>ABONAR A PRESTAMO</th>
								
							</tr>

							<?php
							date_default_timezone_set('America/Bogota');

							$fechaactual = Date("Y-m-d");

							//$fechaactual2 = Date('Y-m-d H:i:s', time()); 
							//echo $fechaactual2;
							

							//paginador

							$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
										FROM prestamo " );//idcuadre=$controlinicialS
							$result_register= mysqli_fetch_array($sql_registe);
							$total_registro=$result_register['total_registro'];

							$por_pagina=100;

							if(empty($_GET['pagina'])){
									$pagina=1;
							}else{
								$pagina=$_GET['pagina'];
							}

							$desde=($pagina-1)*$por_pagina;
							$total_paginas=ceil($total_registro/$por_pagina);

							
							
								$query=mysqli_query($conexion,"SELECT p.id, c.nombrec, p.total 
											FROM prestamo p INNER JOIN cliente c ON p.id_empleado=c.idcliente  
											ORDER BY c.nombrec LIMIT $desde, $por_pagina" );
	
								$result =mysqli_num_rows($query);
								
								if($result > 0){
									while($data=mysqli_fetch_array($query)){
								
									$empleado=$data["nombrec"];
									$total= $data["total"];
																					
							?>
							<tr>
										
										<td><?php echo $empleado; ?></td>
										<?php $total=number_format($total, 0, ',', '.'); ?>
										<td><?php echo $total; ?></td>

																		

										<td>
											<a class="link_delete" href="abonarprestamo.php? 
											id=<?php echo $data["id"]; ?>"><i class="fas fa-dollar-sign"></i> Abonar a Prestamo</a>	
									
										</td>
										
									</tr>
							<?php
									
									}//fin mientras
									mysqli_close($conexion);
								}
							?>
						
						</table>
						<div class="paginador">
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
						</div>


						
				</section>
					
			</body>
			</html>
8