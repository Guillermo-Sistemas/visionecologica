<?php
    session_start();
    include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Buscar Venta</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">

			<?php
				$busqueda=strtolower($_REQUEST['busqueda']);

				if(empty($busqueda)){ 
					header("location: listar_venta.php");
				}
			?>


			<h1>Busqueda de Ventas</h1>
            <a href="nueva_compra.php" class="btn_new"><i class="fas fa-plus"></i> Registrar Venta</a>

			<form action="buscar_venta.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
				<tr>
                    <!-- <th>ID</th>-->
                    <th>Número de Recibo</th>
                    <th>Fecha</th>
		    		<th>Cliente</th>
                    <th>Identificación</th>
					<th>Valor Venta</th>
		    		<th>Acciones</th>
                </tr>

				<?php

				//paginador
				
				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro,
										f.nofacturav, f.fecha, f.totalfactura, c.nit, c.nombre FROM
										facturav f INNER JOIN cliente c ON f.codcliente=c.idcliente  
										WHERE estatus=1 and tipofactura!='Crédito' and
										(nofacturav LIKE '%$busqueda%' OR 
										fecha LIKE '%$busqueda%' OR 
										totalfactura LIKE '%$busqueda%' OR 
										nit LIKE '%$busqueda%' OR 
										nombre LIKE '%$busqueda%') 
										 " );

				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=12;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);

                    $query=mysqli_query($conexion,"SELECT f.nofacturav, f.fecha, f.totalfactura, c.nit, c.nombre FROM
                    								facturav f INNER JOIN cliente c ON f.codcliente=c.idcliente  
													WHERE estatus=1 and tipofactura!='Crédito' and
													(nofacturav LIKE '%$busqueda%' OR 
													fecha LIKE '%$busqueda%' OR 
													totalfactura LIKE '%$busqueda%' OR 
													nit LIKE '%$busqueda%' OR 
													nombre LIKE '%$busqueda%') 
													LIMIT $desde, $por_pagina " );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            <td><?php echo $data["nofacturav"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $data["nombre"]; ?></td>
							<td><?php echo $data["nit"]; ?></td>
							<td><?php echo $data["totalfactura"]; ?></td>
							<td>
                               
								<a class="link_edit" href="facturaV_pdf.php? id=<?php echo $data["nofacturav"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								|
								
                                <a class="link_delete" href="eliminar_confirmar_compra.php? 
								id=<?php echo $data["nofactura"]; ?>"><i class="fas fa-trash-alt"></i>Anular Compra</a>
								
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
