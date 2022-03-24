<?php
    session_start();
    include "../conexion.php";

	$pagina=0; $total_paginas=0; $pagina=0;
	$pesoto=0; $totalcom=0;

	


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

					

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM factura f 
											INNER JOIN cliente c ON f.codcliente=c.idcliente INNER JOIN 
											detallefactura d ON d.nofactura=f.nofactura WHERE estatus=1 
											and DATE(fecha)>='$desdef' and DATE(fecha)<='$hasta' 
											and nomproducto='$producto' " );
				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=50;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);


				//echo $producto;

                    $query=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.tipofactura, c.nit, c.nombrec, 
												d.nomproducto, d.cantidad, d.valorkilo, d.subtotal FROM factura f 
												INNER JOIN cliente c ON f.codcliente=c.idcliente INNER JOIN 
												detallefactura d ON d.nofactura=f.nofactura WHERE estatus=1 
												and DATE(fecha)>='$desdef' and DATE(fecha)<='$hasta' 
												and nomproducto='$producto' ORDER BY fecha
												DESC LIMIT $desde, $por_pagina" );
					
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
				}
						}
					}
				?>
				<tr>
						<td>PESO TOTAL <?php echo $pesoto; ?></td>
						<td>TOTAL PAGADO <?php echo $totalcom; ?></td>
				</tr>
	        
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
