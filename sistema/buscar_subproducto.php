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
	<title>Buscar Subproducto</title>
	
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
					header("location: listar_subproducto.php");
				}
			?>


			<h1>Busqueda de Subproducto</h1>
            <a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Crear Producto</a>

			<form action="buscar_subproducto.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <th>Descripcion</th>
                    <th>Del Producto</th>
                    <th>Precio Venta</th>
					<th>Acciones</th>
                </tr>

				<?php

				//paginador
				
				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM subproducto 
										WHERE (nombre_subpro LIKE '%$busqueda%' OR 
												precioventa_subpro LIKE '%$busqueda%'  )"
												);

				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=8;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);

                    $query=mysqli_query($conexion,"SELECT s.codsubproducto, p.descripcion, s.nombre_subpro, s.precioventa_subpro FROM
                                        subproducto s INNER JOIN producto p ON s.codproducto=p.codproducto 
                                        WHERE
										(nombre_subpro LIKE '%$busqueda%' OR 
                                        precioventa_subpro LIKE '%$busqueda%' OR 
                                        descripcion LIKE '%$busqueda%'  ) 
										LIMIT $desde, $por_pagina " );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                            <td><?php echo $data["nombre_subpro"]; ?></td>
							<td><?php echo $data["descripcion"]; ?></td>
							<td><?php echo $data["precioventa_subpro"]; ?></td>
							<td>
                                <a class="link_edit" href="editar_subproducto1.php? id=<?php echo $data["codsubproducto"]; ?>"><i class="fas fa-pen-alt"></i>Editar</a>
                                |
				<a class="link_delete" href="eliminar_confirmar_subproducto.php? id=<?php echo $data["codsubproducto"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
								
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
		<?php
			include "include/footer.php";
		?>
</body>
</html>
