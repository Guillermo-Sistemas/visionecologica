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
			<h1>Buscar Gastos</h1>
           
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

				if($tercero!="SIN TERCERO"){

					
                    $query=mysqli_query($conexion,"SELECT t.nombregasto, c.nombrec, g.valorgasto, g.fechagasto, g.nota, u.nombre 
													FROM gasto g INNER JOIN tipo_gasto t ON g.idtipogasto=t.idtipogasto 
													INNER JOIN cliente c ON g.idcliente=c.idcliente 
													INNER JOIN usuario u ON u.idusuario=g.idusuario 
													WHERE g.estatus!=0 and DATE(fechagasto)>='$desdef' 
													and DATE(fechagasto)<='$hasta' and g.idcliente='$tercero' 
													and g.idtipogasto='$tipo' ORDER BY fechagasto" );
					
					//consultar el nombvre del gasto
					$consultatipo2=mysqli_query($conexion, "SELECT idtipogasto, nombregasto FROM tipo_gasto WHERE idtipogasto=$tipo");
					$datotipo2=mysqli_fetch_array($consultatipo2);
					$tipo= $datotipo2["nombregasto"];
					//consultar el nombre del tercero
					$tercero2=mysqli_query($conexion, "SELECT idcliente, nombrec FROM cliente WHERE idcliente=$tercero");
					$datotercero2=mysqli_fetch_array($tercero2);
					$tercero= $datotercero2["nombrec"];



					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            
							
							<td><?php echo $data["nombregasto"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<?php $vg=number_format($data["valorgasto"], 0, ',', '.');?>
							<td><?php echo $vg; ?></td>
							<td><?php echo $data["fechagasto"]; ?></td>
							<td><?php echo $data["nota"]; ?></td>
							<td><?php echo $data["nombre"]; ?></td>
							<?php
							$totalgasto=$totalgasto+$data["valorgasto"];
							?>

							

							
							
                        </tr>
						
				<?php
				}
						}

						?>

						<tr>
						<?php $totalgasto=number_format($totalgasto, 0, ',', '.');?>

						<td colspan="6">
						<label><h1>TOTAL <?php echo $tipo. " A " .$tercero. " $ ".$totalgasto. " DEL ".$desdef. " HASTA ".$hasta; ?></h1></label>
						</td>
						</tr>
					<?php
					}elseif($bandera!=1 ){//fin SI tercero

					//echo "ultimo".$tercero;


					
				
					$query=mysqli_query($conexion,"SELECT t.nombregasto, c.nombrec, g.valorgasto, g.fechagasto, g.nota, u.nombre 
													FROM gasto g INNER JOIN tipo_gasto t ON g.idtipogasto=t.idtipogasto 
													INNER JOIN cliente c ON g.idcliente=c.idcliente 
													INNER JOIN usuario u ON u.idusuario=g.idusuario 
													WHERE g.estatus!=0 and DATE(fechagasto)>='$desdef' 
													and DATE(fechagasto)<='$hasta' 
													and g.idtipogasto='$tipo' ORDER BY fechagasto" );

					//consultar el nombvre del gasto
					$consultatipo2=mysqli_query($conexion, "SELECT idtipogasto, nombregasto FROM tipo_gasto WHERE idtipogasto=$tipo");
					$datotipo2=mysqli_fetch_array($consultatipo2);
					$tipo= $datotipo2["nombregasto"];
					
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            
							
							<td><?php echo $data["nombregasto"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<?php $vg=number_format($data["valorgasto"], 0, ',', '.');?>
							<td><?php echo $vg; ?></td>
							<td><?php echo $data["fechagasto"]; ?></td>
							<td><?php echo $data["nota"]; ?></td>
							<td><?php echo $data["nombre"]; ?></td>
							<?php
							$totalgasto=$totalgasto+$data["valorgasto"];
							?>

							

							
							
                        </tr>
						
				<?php
				}
						}
						?>

						<tr>
						<?php $totalgasto=number_format($totalgasto, 0, ',', '.');?>
						<td colspan="6">
							<label><h1>TOTAL GASTO <?php echo $tipo.  " $ ".$totalgasto. " DEL ".$desdef. " HASTA ".$hasta; ?></h1></label>
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
