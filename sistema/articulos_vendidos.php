<?php
    include "../conexion.php";

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
	<title>Lista de Artículos vendidos</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Artículos Vendidos</h1>
            <a href="registro_recuperado.php" class="btn_new"><i class="fas fa-plus"></i>Recuperar Artículo</a>

			<form action="buscar_articulo_eliminado.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <th>Descripcion</th>
                    <th>Fecha de Recuperacion</th>
                    <th>Peso</th>
					<th>Precio de Venta</th>
					<th>Fecha de Venta</th>
					<th>No. Recibo</th>
					<th>Cliente</th>
					<th>Acciones</th>
					
                    
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM recuperado WHERE estatus=2 " );
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




                    $query=mysqli_query($conexion,"SELECT r.codrecuperado, r.descripcion_recuperado, r.fecha_recuperado, r.peso_recuperado, 
													r.precioventa_recuperado, r.fechaventa_recuperado, r.nofactura, c.nombrec FROM recuperado r 
													INNER JOIN cliente c ON r.idcliente=c.idcliente
                   									WHERE r.estatus=2 ORDER BY r.fechaventa_recuperado ASC LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){

						
				?>
						<tr>
                            <td><?php echo $data["descripcion_recuperado"]; ?></td>
							<td><?php echo $data["fecha_recuperado"]; ?></td>
							<td><?php echo $data["peso_recuperado"]; ?></td>
							<td><?php echo $data["precioventa_recuperado"]; ?></td>
							<td><?php echo $data["fechaventa_recuperado"]; ?></td>
							<td><?php echo $data["nofactura"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>

							<td>
                               
								<a class="link_edit" href="facturaV_pdf.php? id=<?php echo $data["nofactura"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								|
								
                                <a class="link_delete" href="eliminar_confirmar_venta_recuperado.php? 
								id=<?php echo $data["codrecuperado"]; ?>"><i class="fas fa-trash-alt"></i></a>
								
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
