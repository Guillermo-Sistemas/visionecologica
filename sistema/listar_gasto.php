<?php



include "../conexion.php";


$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
$inicio1= mysqli_fetch_array($inicio);
$controlinicial=$inicio1[0];

$inicio2=mysqli_query($conexion, "select egresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
$datoinicio=mysqli_fetch_array($inicio2);

    $egresos= $datoinicio["egresos"];
    $controlinicio= $datoinicio["estatus"];

    if($controlinicio==0)
    {
        echo "<script>
                alert('No Existe un Cuadre Abierto');
                window.location= '../index.php'
            </script>";

    }

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
				<title>Lista de Gastos</title>
				<link rel="shortcut icon" href="imagenes/icono.ico">
				
			</head>
			<body>
				<?php
					include "include/header.php";
					include "include/nav.php";
				?>
				
				<section class="contenido">
						<h1>Lista de Gastos</h1>
						<a href="registro_gasto.php" class="btn_new"><i class="fas fa-user-alt"></i> Crear Gasto</a>

						<! --<form action="buscar_gasto.php" method="get" class="form_search">
						<! --	<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
						<! --	<input type="submit" value="buscar" class="btn_search">
						<! --</form>


						<table>
							<tr>
								<th>GASTO</th>
								<th>TERCERO</th>
								<th>VALOR</th>
								<th>NOTA</th>
								<th>REALIZO</th>
								<th>PROCEDENCIA</th>
								<th>Acciones</th>
							</tr>

							<?php
							date_default_timezone_set('America/Bogota');

							$fechaactual = Date("Y-m-d");

							//$fechaactual2 = Date('Y-m-d H:i:s', time()); 
							//echo $fechaactual2;
							

							//paginador

							$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
										FROM gasto WHERE DATE(fechagasto)='$fechaactual' and estatus!=0" );//idcuadre=$controlinicialS
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

							
							
								$query=mysqli_query($conexion,"SELECT * FROM gasto 
											WHERE DATE(fechagasto)='$fechaactual' and estatus!=0 LIMIT $desde, $por_pagina" );

								
								
								$result =mysqli_num_rows($query);
								
								if($result > 0){
									while($data=mysqli_fetch_array($query)){
								
									$gasto=$data["idtipogasto"];
									$querygasto=mysqli_query($conexion, "select nombregasto from tipo_gasto WHERE idtipogasto='$gasto'");
									$datogasto=mysqli_fetch_array($querygasto);
									$gasto= $datogasto["nombregasto"];

									$idcliente=$data["idcliente"];
									$queryidcliente=mysqli_query($conexion, "select nombrec from cliente WHERE idcliente='$idcliente'");
									$datocliente=mysqli_fetch_array($queryidcliente);
									$idcliente= $datocliente["nombrec"];

									$usuario=$data["idusuario"];
									$queryusuario=mysqli_query($conexion, "select idusuario, nombre from usuario WHERE idusuario='$usuario'");
									$datousuario=mysqli_fetch_array($queryusuario);
									$idusuario= $datousuario["idusuario"];
									$usuario= $datousuario["nombre"];
									$procedencia=$data["procedencia"];

									if($procedencia==1){
										$procedencianombre="Efectivo";
									}elseif($procedencia==2){
										$procedencianombre="Efectivo Caja Mayor";
									}else{
										$procedencianombre="Consignación";
									}
																					
							?>

								
									<tr>
										
										<td><?php echo $gasto; ?></td>
										<td><?php echo $idcliente; ?></td>

										<?php $valorg=number_format($data["valorgasto"], 0, ',', '.'); ?>

										<td><?php echo $valorg; ?></td>
										<td><?php echo $data["nota"]; ?></td>
										<td><?php echo $usuario; ?></td>
										<td><?php echo $procedencianombre; ?></td>

										

										

										<td>
											<?php
											//echo $gasto;
											if($gasto!="Prestamos" && $procedencia==1){ ?>
											<a class="link_edit" href="editar_gasto.php? id=<?php echo $data["idgasto"]; ?>"><i class="fas fa-pen-alt"></i>Editar</a>
											
											|
											
											<?php 
											}if($data["idgasto"] >0){?>
											<a class="link_delete" href="eliminar_confirmar_gasto.php? id=<?php echo $data["idgasto"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
											<?php }
											?>
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