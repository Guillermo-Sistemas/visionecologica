<?php
    session_start();
    include "../conexion.php";

	$fechaactual2=0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Buscar Compra</title>
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
					header("location: listar_compra.php");
				}
			?>


			<h1>Busqueda de Compras</h1>
            <a href="nueva_compra.php" class="btn_new"><i class="fas fa-plus"></i> Registrar Compra</a>

			<form action="buscar_compra.php" method="get" class="form_search">
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
					<th>Valor Pagado</th>
		    		<th>Acciones</th>
                </tr>

				<?php

				//paginador
				
				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM factura 
													WHERE estatus=1 and tipofactura='Efectivo' 
													and (nofactura LIKE '%$busqueda%' OR 
													fecha LIKE '%$busqueda%' OR 
													codcliente LIKE '%$busqueda%' OR 
													totalfactura LIKE '%$busqueda%' )"
												);

				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];



				$por_pagina=20;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d ');

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);

                    $query=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, DATE(fecha) as solofecha, f.totalfactura, c.nit, c.nombrec FROM
                    								factura f INNER JOIN cliente c ON f.codcliente=c.idcliente  
													WHERE f.estatus=1 and
													(nofactura LIKE '%$busqueda%' OR 
													fecha LIKE '%$busqueda%' OR 
													totalfactura LIKE '%$busqueda%' OR 
													nit LIKE '%$busqueda%' OR 
													nombrec LIKE '%$busqueda%') 
													" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
							$fecha_actual = strtotime(date("d-m-Y",time()));
							$solofecha=$data["solofecha"];
							$fecha_entrada = strtotime("$solofecha");
						
				?>
						<tr>
                            <td><?php echo $data["nofactura"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["nit"]; ?></td>
							<td><?php echo $data["totalfactura"]; ?></td>
							<td>
                               
								<a class="link_edit" href="factura_pdf.php? id=<?php echo $data["nofactura"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								<?php
								if($fecha_actual==$fecha_entrada){
									?>
								
								
									|
									<a class="link_delete" href="eliminar_confirmar_compra.php? 
									id=<?php echo $data["nofactura"]; ?>"><i class="fas fa-trash-alt"></i>Anular Compra</a>
								<?php
								
								}
								?>
                                
								
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
					
					
					
					<?php } ?>			

				</ul>
			</div>


			
	</section>
		
</body>
</html>
/