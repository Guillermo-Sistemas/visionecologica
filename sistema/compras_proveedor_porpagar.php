<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;
	$nombrecli="";
	$nomproveedor="";
	$proveedor="";
	$totalabo=0;

	


	$consultaPro="SELECT idcliente, nombrec FROM cliente WHERE tipo_cliente='Proveedor' 
				OR tipo_cliente='Proveedor-Cliente' OR tipo_cliente='Recuperador' ORDER BY nombrec ASC";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Compras a Crédito por Proveedor</title>
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
			<h1>Lista de Compras a Crédito por Pagar por Proveedor</h1>
           
			<form action="" method="post" class="form_search">
				
				<select id="proveedor" name="proveedor"><option value="">Proveedor</option>
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
								?>
								<option value="<?php echo $row['idcliente']; ?>"><?php echo $row['nombrec']; ?></option>
								<?php } ?>
				</select>
				
				<input type="submit" value="buscar" class="btn_search">
				
			</form>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>Número de Recibo</th>
                    <th>Fecha</th>
					<th>Cliente</th>
                    <th>Abonos</th>
					<th>Total Factura</th>
					<th>Imprimir</th>
                </tr>

				<?php

				if(!empty($_POST) )
				{

					$proveedor=$_POST['proveedor'];

					if($proveedor!=""){

						$queryproveedor=mysqli_query($conexion,"SELECT nombrec FROM cliente WHERE idcliente=$proveedor" );
							$datap=mysqli_fetch_array($queryproveedor);
							$nomproveedor=$datap["nombrec"];
						


					
						$query=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.tipofactura, f.abono, c.idcliente, c.nombrec, 
													f.totalfactura FROM factura f 
													INNER JOIN cliente c ON f.codcliente=c.idcliente  WHERE f.estatus=1 
													and tipofactura=2 and idcliente='$proveedor'  ORDER BY fecha
													" );
						
						$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
								<tr>
									<!--<td><?php// echo $data["idcliente"]; ?></td>-->
									<td><?php echo $data["nofactura"]; ?></td>
									<td><?php echo $data["fecha"]; ?></td>
									
									<td><?php echo $data["nombrec"]; ?></td>
									<td><?php echo number_format($data["abono"], 0, ',', '.');?></td>
									<td><?php echo number_format($data["totalfactura"], 0, ',', '.');
									$totalcom=$totalcom+$data["totalfactura"];
									$totalabo=$totalabo+$data["abono"];
									?></td>

									

									<td>
									
										<a class="link_edit" href="factura_pdf.php? id=<?php echo $data["nofactura"]; ?>"
										target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
										|
										<a class="link_delete" href="pagar_compra_credito.php? 
											id=<?php echo $data["nofactura"]; ?>"><i class="fas fa-dollar-sign"></i>Pagar Compra</a>
										
									</td>
									
								</tr>
								
						<?php
						}
						$totalcom=$totalcom-$totalabo;
						$totalcom=number_format($totalcom, 0, ',', '.');

						
				?>

						
						<tr>
						<td colspan="5"><label><h1><CENTER>Total Compras por Pagar a <?php echo $nomproveedor." $ ".$totalcom; ?></CENTER></h1></label></td>
						<td>
							<a href="pagar_a_proveedor.php?id=<?php echo $proveedor;?>" class="btn_news" ></i> Pagar a Proveedor</a>
					</td>
						</tr>
						
						

				<?php
				}else{
					
					?>
					<tr>
						<td colspan="9"><label><h1><CENTER>No hay Compras por Pagar al Proveedor <?php echo $nomproveedor;?> </CENTER></h1></label></td>
						</tr>
				<?php	
				}//fin si hay consulta
			}//fin si hay dato a buscar

				}//si post
				?>
				
	        
            </table>
			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
