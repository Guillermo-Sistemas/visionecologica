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
	<title>Lista de Terceros</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Terceros</h1>
            <a href="registro_tercero.php" class="btn_new"><i class="fas fa-user-alt"></i> Crear Tercero</a>

			<form action="buscar_tercero.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>NIT</th>
                    <th>Nombre</th>
					<th>Apodo</th>
		    		<th>Teléfono</th>
                    <th>Dirección</th>
					<th>Tipo de Tercero</th>
		    <th>Acciones</th>
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM cliente WHERE estatus=1 " );
				$result_register= mysqli_fetch_array($sql_registe);
				$total_registro=$result_register['total_registro'];

				$por_pagina=100;

				if(empty($_GET['pagina'])){
						$pagina=1;
				 }else{
					$pagina=$_GET['pagina'];
				}

				$desde=($pagina-1)*$por_pagina;
				$total_paginas=ceil($total_registro/$por_pagina);




                    $query=mysqli_query($conexion,"SELECT c.idcliente, c.nit,c.nombrec, c.apodo, c.telefono, c.direccion, 
					 				c.tipo_cliente FROM cliente c  WHERE estatus=1
									  ORDER BY c.nombrec ASC LIMIT $desde, $por_pagina 
					" );
					//AND tipo_cliente!='temporal'
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["nit"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["apodo"]; ?></td>
							<td><?php echo $data["telefono"]; ?></td>
							<td><?php echo $data["direccion"]; ?></td>
							<td><?php echo $data["tipo_cliente"]; ?></td>
							<td>
                                <a class="link_edit" href="editar_tercero.php? id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-pen-alt"></i>Editar</a>
                                
								|
								<?php if($data["idcliente"] >0){?>
                                <a class="link_delete" href="eliminar_confirmar_tercero.php? id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
								<?php }
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
					
					
					<li><a href="?pagina=<?php echo $pagina+1;?> ">>></a></li>
					<li><a href="?pagina=<?php echo $total_paginas;?>">>|</a></li>
					<?php } ?>			

				</ul>
			</div>


			
	</section>
		
</body>
</html>