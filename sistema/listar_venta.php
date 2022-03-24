<?php
    session_start();
    include "../conexion.php";

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }

	date_default_timezone_set('America/Bogota');
	$actual = Date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Lista de Ventas</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Ventas</h1>
            <a href="nueva_venta.php" class="btn_new"></i> Registrar Venta</a>

			<form action="buscar_venta.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">
			</form>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>No. Recibo</th>
                    <th>Fecha</th>
		    		<th>Cliente</th>
                    <th>Productos</th>
					<th>Valor Cobrado</th>
		    <th>Acciones</th>
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM facturaV
													 WHERE estatus=1 and 
												 DATE(fecha)='$actual' and tipofactura!=2" );
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




                    $query=mysqli_query($conexion,"SELECT f.nofacturav, f.fecha, f.totalfactura, c.nit, c.nombrec FROM
                    								facturaV f  INNER JOIN cliente c ON f.codcliente=c.idcliente  
													WHERE f.estatus=1 and 
												 DATE(fecha)='$actual' and tipofactura!=2
													ORDER BY fecha DESC LIMIT $desde, $por_pagina
					" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<?php
								 $nofv=$data["nofacturav"];
							?>

							<td><?php echo $nofv; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>

							<?php
								 $nomproducto=mysqli_query($conexion, "select nomproducto FROM detallefacturav f
								 WHERE nofacturav='$nofv' ");
		
								$resultnompro =mysqli_num_rows($nomproducto);
					
								if ($resultnompro){
									$productos="";
									while($datanp=mysqli_fetch_array($nomproducto)){
										$productos=$datanp["nomproducto"].", ".$productos;
									}
								}
							?>



							<td><?php echo $productos; ?></td>
							<td><?php echo $data["totalfactura"]; ?></td>
							<td>
                               
								<a class="link_edit" href="facturaV_pdf.php? id=<?php echo $data["nofacturav"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								|
								
                                <a class="link_delete" href="eliminar_confirmar_venta.php? 
								id=<?php echo $data["nofacturav"]; ?>"><i class="fas fa-trash-alt"></i>Anular </a>
								
							</td>
                        </tr>
				<?php
						}
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
