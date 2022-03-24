<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;
	$nombrecli="";

	


	$consultaPro="SELECT idcliente, nombrec FROM cliente WHERE tipo_cliente='Proveedor' 
				OR tipo_cliente='Proveedor-Cliente' ORDER BY nombrec ASC";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Lista de Compras por Proveedor</title>
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
			<h1>Lista de Compras por Proveedor</h1>
           
			<form action="" method="post" class="form_search">
				
				<select id="proveedor" name="proveedor"><option value="">Proveedor</option>
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
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
                    <th>Número de Recibo</th>
                    <th>Fecha</th>
					<th>Tipo Factura</th>
		    		
                    
					<th>Total</th>
					<th>Estado</th>
					<th>Imprimir</th>
                </tr>

				<?php

				if(!empty($_POST))
				{

					$proveedor=$_POST['proveedor'];
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

					

				


				//echo $producto;

                    $query=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.totalfactura, f.estatus, f.tipofactura, c.idcliente,
												c.nombrec FROM factura f 
												INNER JOIN cliente c ON f.codcliente=c.idcliente 
												WHERE f.estatus=1 
												and DATE(fecha)>='$desdef' and DATE(fecha)<='$hasta' 
												and idcliente='$proveedor'  ORDER BY fecha" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["nofactura"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<?php
								$tipof="Efectivo";
								if($data["tipofactura"]==2)
									$tipof="Crédito";
							$nombrecli=$data["nombrec"]
							?>



							<td><?php echo $tipof; ?></td>
							<!--php echo $data["nombrec"]; ?></td>
							php echo $data["nomproducto"]; ?></td>
							<td>php echo $data["cantidad"]; ?></td>
							<td>php echo $data["valorkilo"]; ?></td-->
							<td><?php echo $data["totalfactura"]; ?></td>
							<td><?php echo $data["estatus"]; ?></td>


							<?php 
								//$pesoto=$pesoto+$data["cantidad"];
								$totalcom=$totalcom+$data["totalfactura"];
							?>

							<td>
                               
								<a class="link_edit" href="factura_pdf.php? id=<?php echo $data["nofactura"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								
							</td>
							
                        </tr>
						
				<?php
				}
						
						$totalcom=number_format($totalcom, 0, ',', '.');
				?>

						
						<tr>
						<td colspan="9"><label><h1><CENTER>Total Compras A <?php echo $nombrecli." $ ".$totalcom; ?></CENTER></h1></label></td>
						</tr>
						<tr>
						<td colspan="9"><label><h1><CENTER>Del <?php echo $desdef." Hasta ".$hasta; ?></CENTER></h1></label></td>
						</tr>

				<?php
				}else{?>
					<tr>
						<td colspan="9"><label><h1><CENTER>No hay Compras en Efectivo para el Periodo y Proveedor Seleccionado</CENTER></h1></label></td>
						</tr>
				<?php	
				}//fin si hay consulta

				}//si post
				?>
				
	        
            </table>
			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
