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
	<title>Lista de Artículos</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Artículos Eliminados</h1>
            <a href="registro_recuperado.php" class="btn_new"><i class="fas fa-plus"></i>Recuperar Artículo</a>

			<form action="buscar_recuperado.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <th>Descripcion</th>
                    <th>Fecha de Recuperacion</th>
                    <th>Del Producto</th>
					<th>Peso</th>
					<th>Precio de Venta</th>
					<th>Fecha Eliminación</th>
					
                    
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM recuperado WHERE estatus=0 " );
				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=15;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);




                    $query=mysqli_query($conexion,"SELECT r.codrecuperado, r.descripcion_recuperado, r.fecha_recuperado, p.descripcion, 
													r.peso_recuperado, r.precioventa_recuperado, r.fechaventa_recuperado FROM recuperado r 
													INNER JOIN producto p ON r.codproducto=p.codproducto
                   									WHERE r.estatus=0 ORDER BY r.fechaventa_recuperado ASC LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){

						$data["descripcion"]=($data["descripcion"]);//strtoupper para mayuscula
				?>
						<tr>
                            <td><?php echo $data["descripcion_recuperado"]; ?></td>
							<td><?php echo $data["fecha_recuperado"]; ?></td>
							<td><?php echo $data["descripcion"]; ?></td>
							<td><?php echo $data["peso_recuperado"]; ?></td>
							<td><?php echo $data["precioventa_recuperado"]; ?></td>
							<td><?php echo $data["fechaventa_recuperado"]; ?></td>
							
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
