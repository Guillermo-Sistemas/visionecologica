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
	<title>Lista de Productos</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Productos</h1>
            <a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Crear Producto</a>

			<form action="buscar_producto1.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <th>Descripcion</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
					<th>Existencia</th>
					<th>Acciones</th>
                    
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM producto " );
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




                    $query=mysqli_query($conexion,"SELECT p.codproducto, p.descripcion, p.precio_compra, p.precio_venta, p.existencia FROM
                    producto p ORDER BY p.descripcion ASC LIMIT $desde, $por_pagina
					" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){

						$data["descripcion"]=($data["descripcion"]);//strtoupper para mayuscula
				?>
						<tr>
                            <td><?php echo $data["descripcion"]; ?></td>
							<td><?php echo $data["precio_compra"]; ?></td>
							<td><?php echo $data["precio_venta"]; ?></td>
							<td><?php echo $data["existencia"]; ?></td>
							<td>
                                <a class="link_edit" href="editar_producto1.php? id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-pen-alt"></i>Editar</a>
                                
								|
                                <a class="link_delete" href="eliminar_confirmar_producto.php? id=<?php echo $data["codproducto"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
								
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
