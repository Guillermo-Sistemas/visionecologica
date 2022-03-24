<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;

	$tercero="0521";
	$bandera=1;

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
	<title>Busqueda de Gastos Caja Mayor</title>
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
			<h1>Buscar Gastos Administrador</h1>
           
			<form action="" method="post" class="form_search">

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
				<input type="submit" value="buscar" class="btn_search">
			</form>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>Gasto</th>
                    <th>Tercero</th>
					<th>Valor</th>
		    		<th>Fecha</th>
                    <th>Nota</th>
		    		<th>Realizo</th>
					
					
                </tr>

				<?php

				if(!empty($_POST))
				{

					if($_POST['tercero']){
					$tercero=$_POST['tercero'];
					}else{
						$bandera=2;
						}


					$tipo=$_POST['tipo'];
					$desdef=$_POST['desde'];

					$dia=substr( $desdef, 3, 2 );
					$mes=substr( $desdef, 0, 2 );
					$ano=substr( $desdef, 6, 4 );

					$desdef=$ano."-".$mes."-".$dia;

					$hasta=$_POST['hasta'];

					$dia=substr( $hasta, 3, 2 );
					$mes=substr( $hasta, 0, 2 );
					$ano=substr( $hasta, 6, 4 );

					$hasta=$ano."-".$mes."-".$dia;
				}

					

				

						//ORDER BY fecha
				//echo $desdef."/".$hasta."/".$tipo."/".$tercero;
				$totalgasto=0;

				if($tercero!="0521"){

					
                    $query=mysqli_query($conexion,"SELECT t.nombregasto, c.nombrec, g.valorgastom, g.fechagastom, g.notam, u.nombre 
													FROM gastomayor g INNER JOIN tipo_gasto t ON g.idtipogastom=t.idtipogasto 
													INNER JOIN cliente c ON g.idcliente=c.idcliente 
													INNER JOIN usuario u ON u.idusuario=g.idusuario 
													WHERE g.estatus=1 and DATE(fechagastom)>='$desdef' 
													and DATE(fechagastom)<='$hasta' and g.idcliente='$tercero' 
													and g.idtipogastom='$tipo' ORDER BY fechagastom" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            
							
							<td><?php echo $data["nombregasto"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<?php $vg=number_format($data["valorgastom"], 0, ',', '.');?>
							<td><?php echo $vg; ?></td>
							<td><?php echo $data["fechagastom"]; ?></td>
							<td><?php echo $data["notam"]; ?></td>
							<td><?php echo $data["nombre"]; ?></td>
							<?php
							$totalgasto=$totalgasto+$data["valorgastom"];
							?>

							

							
							
                        </tr>
						
				<?php
				}
						}

						?>

						<tr>
						<?php $totalgasto=number_format($totalgasto, 0, ',', '.');?>

						<td colspan="3">
							<label><h1>TOTAL GASTO <?php echo "$ ".$totalgasto; ?></h1></label>
						</td>
						</tr>
					<?php
					}elseif($bandera!=1 ){//fin SI tercero

					//echo "ultimo".$tercero;


					
				
					$query=mysqli_query($conexion,"SELECT t.nombregasto, c.nombrec, g.valorgastom, g.fechagastom, g.notam, u.nombre 
													FROM gastomayor g INNER JOIN tipo_gasto t ON g.idtipogastom=t.idtipogasto 
													INNER JOIN cliente c ON g.idcliente=c.idcliente 
													INNER JOIN usuario u ON u.idusuario=g.idusuario 
													WHERE g.estatus=1 and DATE(fechagastom)>='$desdef' 
													and DATE(fechagastom)<='$hasta' 
													and g.idtipogastom='$tipo' ORDER BY fechagastom" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            
							
							<td><?php echo $data["nombregasto"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<?php $vg=number_format($data["valorgastom"], 0, ',', '.');?>
							<td><?php echo $vg; ?></td>
							<td><?php echo $data["fechagastom"]; ?></td>
							<td><?php echo $data["notam"]; ?></td>
							<td><?php echo $data["nombre"]; ?></td>
							<?php
							$totalgasto=$totalgasto+$data["valorgastom"];
							?>

							

							
							
                        </tr>
						
				<?php
				}
						}
						?>

						<tr>
						<?php $totalgasto=number_format($totalgasto, 0, ',', '.');?>
						<td colspan="3">
							<label><h1>TOTAL GASTO <?php echo "$ ".$totalgasto; ?></h1></label>
						</td>
						</tr>
					<?php
					}
				?>
				

				
	        
            </table>
			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
