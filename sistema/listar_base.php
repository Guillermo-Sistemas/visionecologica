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
				<title>Lista de Bases</title>
				<link rel="shortcut icon" href="imagenes/icono.ico">
				
			</head>
			<body>
				<?php
					include "include/header.php";
					include "include/nav.php";
				?>
				
				<section class="contenido">
						<h1>Lista de Bases</h1>
						<a href="bases.php" class="btn_new"> Agregar Base</a>

						<! --<form action="buscar_gasto.php" method="get" class="form_search">
						<! --	<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
						<! --	<input type="submit" value="buscar" class="btn_search">
						<! --</form>


						<table>
							<tr>
								<th>VALOR BASE</th>
								<th>FECHA Y HORA</th>
								<th>NOTA</th>
								<th>RESPONSABLE</th>
								
							</tr>

							<?php
							date_default_timezone_set('America/Bogota');

							$fechaactual = Date("Y-m-d");

							//$fechaactual2 = Date('Y-m-d H:i:s', time()); 
							//echo $fechaactual2;
							

							//paginador

							$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
										FROM base WHERE idcuadre=$controlinicial " );//DATE(fechabase)='$fechaactual'
							$result_register= mysqli_fetch_array($sql_registe);
							$total_registro=$result_register['total_registro'];

							$por_pagina=15;

							if(empty($_GET['pagina'])){
									$pagina=1;
							}else{
								$pagina=$_GET['pagina'];
							}

							$desde=($pagina-1)*$por_pagina;
							$total_paginas=ceil($total_registro/$por_pagina);

							$controlinicial=$controlinicial-1;
							$querySaldo=mysqli_query($conexion, "select saldo, fechaFinal from cuadre WHERE idcuadre='$controlinicial'");
							$querySaldo1=mysqli_fetch_array($querySaldo);

    						$saldo= $querySaldo1["saldo"];
							$fechafinal= $querySaldo1["fechaFinal"];
							$saldo=number_format($saldo, 0, ',', '.');
							$controlinicial=$controlinicial+1;
							?>

							
							<td><?php echo $saldo; ?></td>
							<td><?php echo $fechafinal; ?></td>
							<td><?php echo "Saldo Anterior"; ?></td>

							<?php
							
								$query=mysqli_query($conexion,"SELECT * FROM base 
											WHERE idcuadre=$controlinicial LIMIT $desde, $por_pagina" );

								
								
								$result =mysqli_num_rows($query);
								
								if($result > 0){
									while($data=mysqli_fetch_array($query)){
								
									$usuario=$data["idusuario"];
									$queryusuario=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$usuario'");
									$datousuario=mysqli_fetch_array($queryusuario);
									$usuario= $datousuario["nombre"];

																												
							?>

								
									<tr>
										

										<?php $valor=number_format($data["valorbase"], 0, ',', '.');?>
										<td><?php echo $valor; ?></td>
										<td><?php echo $data["fechabase"]; ?></td>
										<td><?php echo $data["notabase"]; ?></td>
										<td><?php echo $usuario; ?></td>
										
									</tr>
							<?php
							
									
									}//fin mientras
									mysqli_close($conexion);
									//echo $controlinicial;
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
