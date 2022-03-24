<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;
	$pesotoacu=0; $totalcomacu=0;

	


	$consultaPro="SELECT codproducto, descripcion FROM producto";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Lista de Compras por Producto</title>
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
			<h1>Lista de Compras por Producto</h1>
           
			<form action="" method="post" class="form_search">
				
				<select id="producto" name="producto"><option value="">Producto</option>
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
								?>
								<option value="<?php echo $row['descripcion']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
				</select>
				<input type="text" name="desde" id="desde" class="tcal" placeholder="desde">
				<input type="text" name="hasta" id="hasta" class="tcal" placeholder="hasta">
				<input type="submit" value="buscar" class="btn_search">
				
					
			</form>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    
		    		
                    <th colspan="2">Producto</th>
		    		<th colspan="2">Cantidad</th>
					<th colspan="3">Valor Kilo</th>
					<th colspan="2">Subtotal</th>
					
                </tr>

				<?php

				if(!empty($_POST))
				{

					$producto=$_POST['producto'];
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

				//acumulado por precio de compra
				


				$queryacu=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.tipofactura, c.nit, c.nombrec, 
												d.nomproducto, d.cantidad, d.valorkilo, d.subtotal, 
												SUM(d.cantidad) as cantidades FROM factura f INNER JOIN cliente c 
												ON f.codcliente=c.idcliente INNER JOIN detallefactura d 
												ON d.nofactura=f.nofactura WHERE f.estatus=1 and DATE(fecha)>='$desdef' 
												and DATE(fecha)<='$hasta' and nomproducto='$producto' 
												GROUP BY d.valorkilo ORDER BY fecha" );

												//echo $desdef."/".$hasta."/".$producto;
					
					$resultacu =mysqli_num_rows($queryacu);
					
					if($resultacu > 0){
                        while($dataacu=mysqli_fetch_array($queryacu)){
					?>
						<tr>
                            
							
							<td colspan="2"> <?php echo $dataacu["nomproducto"]; ?></td>
							<?php $canti=number_format($dataacu["cantidades"], 1, ',', '.');?>
							<td colspan="2"><?php echo $canti; ?></td>
							<td colspan="3"><?php echo $dataacu["valorkilo"]; ?></td>

							<?php $subacumulado=$dataacu["cantidades"]*$dataacu["valorkilo"]; ?>
							<?php $subacu=number_format($subacumulado, 1, ',', '.');?>
							<td colspan="2"><?php echo $subacu ; ?></td>

							<?php 
								$pesotoacu=$pesotoacu+$dataacu["cantidades"];
								$totalcomacu=$totalcomacu+$subacumulado;
							?>

							
							
                        </tr>
						
				<?php
							}//fin mientras
						}//fin si
						
				?>

				<?php $pesotoacu=number_format($pesotoacu, 1, ',', '.');?>
				<?php $totalcomacu=number_format($totalcomacu, 0, ',', '.');?>
						

				<tr>
						<td colspan="4">
						<label><h1>PESO TOTAL <?php echo $pesotoacu; ?></h1></label></td>
						<td colspan="5">
						<label><h1>TOTAL PAGADO <?php echo "$ ".$totalcomacu; ?></h1></label></td>
				</tr>

				<tr>
                    <!-- <th>ID</th>-->
                    <th>Número de Recibo</th>
                    <th>Fecha</th>
					<th>Tipo Factura</th>
		    		<th>Cliente</th>
                    <th>Producto</th>
		    		<th>Cantidad</th>
					<th>Valor Kilo</th>
					<th>Subtotal</th>
					<th>Imprimir</th>
                </tr>
				<?php
				//echo $producto;

                    $query=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.tipofactura, c.nit, c.nombrec, 
												d.nomproducto, d.cantidad, d.valorkilo, d.subtotal
												
												FROM factura f 
												INNER JOIN cliente c ON f.codcliente=c.idcliente INNER JOIN 
												detallefactura d ON d.nofactura=f.nofactura WHERE f.estatus=1 
												and DATE(fecha)>='$desdef' and DATE(fecha)<='$hasta' 
												and nomproducto='$producto'  ORDER BY fecha 
												" );

												//echo $desdef."/".$hasta."/".$producto;
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
					?>
						<tr>
                             
							<td><?php echo $data["nofactura"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<?php
								$tipof="Efectivo";
								if($data["tipofactura"]==2)
									$tipof="Crédito";
							?>



							<td><?php echo $tipof; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["nomproducto"]; ?></td>
							<td><?php echo $data["cantidad"]; ?></td>
							<td><?php echo $data["valorkilo"]; ?></td>
							<td><?php echo $data["subtotal"]; ?></td>

							<?php 
								$pesoto=$pesoto+$data["cantidad"];
								$totalcom=$totalcom+$data["subtotal"];
							?>

							<td>
                               
								<a class="link_edit" href="factura_pdf.php? id=<?php echo $data["nofactura"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								
							</td>
							
                        </tr>
						
				<?php
							}//fin mientras
						}//fin si
					}
				?>
				
	        
            </table>
			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
