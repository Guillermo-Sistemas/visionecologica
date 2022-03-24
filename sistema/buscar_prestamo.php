<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;

	$tercero="SIN TERCERO";
	$bandera=1;
	$control=0;
	$tipo=-1;

	$total=0;

	$consultatercero="SELECT idcliente, nombrec FROM cliente ORDER BY nombrec";
	$resultadoter=mysqli_query($conexion, $consultatercero);
	
	


	$totalgasto=0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Detallado de Prestamo</title>
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
			<h1>Detallado de Prestamo</h1>
           
			<form action="" method="post" class="form_search">

			
				
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
                    
                    <th>Valor Prestado</th>
		    		<th>Fecha Prestamo</th>
					<th>Valor Abonado</th>
					<th>Fecha Abono</th>
					<th>Pagado</th>
                    
					
					
                </tr>

				<?php

				if(!empty($_POST))
				{

					if($_POST['tercero']){
					$tercero=$_POST['tercero'];
					}else{
						$bandera=2;
						}


					
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

					
					
//echo "acaaaaaaaaa".$tercero;
					
                    $query=mysqli_query($conexion,"SELECT p.total, c.nombrec, d.id_prestamo, d.abono, d.fechaabono, d.prestamo, 
													d.fechaprestamo, d.estatusdetalleprestamo 
													FROM detalleprestamo d INNER JOIN prestamo p ON d.id_prestamo=p.id 
													INNER JOIN cliente c ON p.id_empleado=c.idcliente 
													WHERE (DATE(fechaprestamo)>='$desdef' 
													and DATE(fechaprestamo)<='$hasta' OR
													DATE(fechaabono)>='$desdef' 
													and DATE(fechaabono)<='$hasta') 
													AND p.id_empleado='$tercero' " );
					
									
					$result =mysqli_num_rows($query);
					
					if($result > 0){
						$control=1;
                        while($data=mysqli_fetch_array($query)){
							$total=$data["total"];
							$terceronom=$data["nombrec"];
							$estatus=$data["estatusdetalleprestamo"];
				?>
						<tr>
							<?php


							if($estatus!=0){
							?>
                           
							<?php $pr=number_format($data["prestamo"], 0, ',', '.');?>
							<td><?php echo "$ ".$pr; ?></td>
							<td><?php echo $data["fechaprestamo"]; ?></td>
							<?php $ab=number_format($data["abono"], 0, ',', '.');?>
							<td><?php echo "$ ".$ab; ?></td>
							<td><?php echo $data["fechaabono"]; ?></td>

							<?php
							if($estatus==2){ ?>
								<td><?php echo "SI"; ?></td>
							<?php
							}else{ ?>
								<td><?php echo "NO"; ?></td>
								<?php
							}?>
							
							
                        </tr>
					
						
				<?php
							}	
					}
					
						}

						?>

						<tr>
						<?php $total=number_format($total, 0, ',', '.');?>

						<td colspan="6">

						<?php
						if ($control>0){ ?>
						<label><h1>SALDO PRESTAMOS DE <?php echo $terceronom. " $ " .$total. " DEL ".$desdef. " HASTA ".$hasta; ?></h1></label>
						<?php
						}
						//detalle de abonos
						?>
						<br><br>
						<h1>Detalle de los Abonos</h1>
						<table>
								<tr>
									<!-- <th>ID</th>-->
									
									<th>Valor abonado</th>
									<th>Fecha </th>
									<th>Abonado A</th>
								</tr>
								
						<?php
						//abonos
						$queryabo=mysqli_query($conexion,"SELECT a.id_prestamo, a.valor,
													a.fecha, a.procedencia, p.id , p.id_empleado
													FROM detalleabonoprestamo a
													INNER JOIN prestamo p ON a.id_prestamo=p.id 
													WHERE DATE(a.fecha)>='$desdef' 
													and DATE(a.fecha)<='$hasta'
													AND p.id_empleado=$tercero " );
					
					//echo $desdef."/".$hasta."/".$tercero."/";
					
									
					$resultabo =mysqli_num_rows($queryabo);
					
					if($resultabo > 0){
						
                        while($databo=mysqli_fetch_array($queryabo)){
							$valor=$databo["valor"];
							$fecha=$databo["fecha"];
							$procedencia=$databo["procedencia"];

							if($procedencia==1)
								$procedencia="Caja Menor";
							if($procedencia==2)
								$procedencia="Efectivo Caja Mayor";
							if($procedencia==3)
								$procedencia="Consignación";

							$v=number_format($valor, 0, ',', '.');
							?>
							<tr>
							<td><?php echo "$ ".$v; ?></td>
							<td><?php echo $fecha; ?></td>
							<td><?php echo $procedencia; ?></td>
						
						</tr>
						
						
						<?php
						}
					}
					?>
					</table>
									






















					
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
