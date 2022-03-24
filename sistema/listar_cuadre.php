<?php

include "../conexion.php";

    session_start();

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }

	$estatus=1;

	   
			?>

			<!DOCTYPE html>
			<html lang="es">
			<head>
				<meta charset="UTF-8">
				<?php
					include "include/scripts.php";
				?>
				<title>Lista de Cuadres</title>
				<link rel="shortcut icon" href="imagenes/icono.ico">
				
			</head>
			<body>
				<?php
					include "include/header.php";
					include "include/nav.php";
				?>
				
				<section class="contenido">
						<h1>Lista de Cuadres</h1>
						<a href="abrir_cuadre.php" class="btn_new"><i class="fas fa-user-alt"></i> Abrir Cuadre</a>

						<! --<form action="buscar_gasto.php" method="get" class="form_search">
						<! --	<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
						<! --	<input type="submit" value="buscar" class="btn_search">
						<! --</form>


						<table>
							<tr>
								<th>FECHA DEL CUADRE</th>
								<th>ESTADO</th>
								<th>ACTUALIZADO</th>
								<th>IMPRIMIR</th>
							</tr>

							<?php

							$fechaactual = Date("Y-m-d");

							//$fechaactual2 = Date('Y-m-d H:i:s', time()); 
							//echo $fechaactual2;
							

							//paginador

							$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
										FROM cuadre" );
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

							
							
								$query=mysqli_query($conexion,"SELECT idcuadre, DATE_FORMAT(fechaInicial, '%d/%m/%Y') as fecha, 
													ingresos, egresos,saldo, estatus, fechaFinal  FROM cuadre ORDER BY fechaFinal DESC 
													LIMIT $desde, $por_pagina "  );

								$result =mysqli_num_rows($query);
								
								if($result > 0){
									while($data=mysqli_fetch_array($query)){
								
									$fechaini= $data["fecha"];
									$estatus=$data["estatus"];
									$fechafin=$data["fechaFinal"];
									$estado="";
									$ingresos=$data["ingresos"];
									$egresos=$data["egresos"];
									$saldo=$data["saldo"];


									
									if($estatus==1){
										$estado="Cuadre sin Cerrar"; 
										$fechafin="Sin Cerrar";
									}else{

											$final=$ingresos-$egresos-$saldo;
											$estado="Cuadre Cerrado con Sobrante   ".($final*-1);

											if($final==0){
												$estado="Cuadre Cerrado OK"; 
											}elseif($final>0){
												$estado="Cuadre Cerrado con Faltante   ".($final*-1); 
											}
									}
																												
							?>

								
									<tr>
										<!--<td><?php// echo $data["idcliente"]; ?></td>-->
										<td><?php echo $fechaini; ?></td>
										<td><?php echo $estado; ?></td>
										<td><?php echo $fechafin; ?></td>

										<?php if($estatus!=1){ ?>
										<td>
											<a class="link_edit" href="imprimir_cuadre.php? id=<?php echo $data["idcuadre"]; ?>"
											target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
										</td>
										<?php } ?>
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
