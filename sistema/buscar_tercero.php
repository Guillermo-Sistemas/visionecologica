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
	<title>Lista Terceros</title>
	
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
					header("location: listar_tercero.php");
				}
			?>


			<h1>Busqueda de Terceros</h1>
            <a href="registro_tercero.php" class="btn_new"><i class="fas fa-user-alt"></i> Crear Tercero</a>

			<form action="buscar_tercero.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <th>NIT</th>
                    <th>Nombre</th>
					<th>Apodo</th>
                    <th>Teléfono</th>
					<th>Direccion</th>
					<th>Tipo</th>
					<th>Acciones</th>
                </tr>

				<?php

				//paginador
				
				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM cliente 
										WHERE (nit LIKE '%$busqueda%' OR 
												nombrec LIKE '%$busqueda%' OR 
												apodo LIKE '%$busqueda%' OR
												telefono LIKE '%$busqueda%' OR
												tipo_cliente LIKE '%$busqueda%' OR 
												direccion LIKE '%$busqueda%' )");

				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=1000;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);

                    $query=mysqli_query($conexion,"SELECT c.idcliente, c.nit, c.nombrec, c.apodo, c.telefono, c.direccion, c.tipo_cliente FROM
                    					cliente c WHERE
										(nit LIKE '%$busqueda%' OR 
										nombrec LIKE '%$busqueda%' OR 
										apodo LIKE '%$busqueda%' OR
										telefono LIKE '%$busqueda%' OR 
										tipo_cliente LIKE '%$busqueda%' OR
										direccion LIKE '%$busqueda%') AND
										estatus=1
										LIMIT $desde, $por_pagina " );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            <td><?php echo $data["nit"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["apodo"]; ?></td>
							<td><?php echo $data["telefono"]; ?></td>
							<td><?php echo $data["direccion"]; ?></td>
							<td><?php echo $data["tipo_cliente"]; ?></td>
							<td>
                                <a class="link_edit" href="editar_tercero.php? id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-pen-alt"></i>Editar</a>

                                |
				<a class="link_delete" href="eliminar_confirmar_tercero.php? id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
								
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