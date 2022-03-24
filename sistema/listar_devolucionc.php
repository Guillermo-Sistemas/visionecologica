<?php
    session_start();
    include "../conexion.php";

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
	<title>Lista de Devoluciones de Compras</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Devoluciones de Compras</h1>
            

			<br>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>No. Devolución</th>
                    <th>Fecha</th>
		    		<th>Cliente</th>
                    <th>Productos</th>
					<th>Valor Recibido</th>
					<th>Motivo</th>
		    <th>Imprimir</th>
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM devolucionc
													 WHERE estatus=1 " );
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




                    $query=mysqli_query($conexion,"SELECT d.nodevolucionc, d.fechadevc, d.total_devc, d.motivo, c.nombrec FROM
                    								devolucionc d  INNER JOIN cliente c ON d.codcliente=c.idcliente  
													WHERE d.estatus=1 ORDER BY fechadevc DESC LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<?php
								 $nofv=$data["nodevolucionc"];
							?>

							<td><?php echo $nofv; ?></td>
							<td><?php echo $data["fechadevc"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>

							<?php
								 $nomproducto=mysqli_query($conexion, "select nomproducto FROM detalledevc 
								 WHERE nodevolucionc='$nofv' ");
		
								$resultnompro =mysqli_num_rows($nomproducto);
					
								if ($resultnompro){
									$productos="";
									while($datanp=mysqli_fetch_array($nomproducto)){
										$productos=$datanp["nomproducto"].", ".$productos;
									}
								}
							?>



							<td><?php echo $productos; ?></td>
							<td><?php echo $data["total_devc"]; ?></td>
							<td><?php echo $data["motivo"]; ?></td>
							<td>
                               
								<a class="link_edit" href="facturadevc_pdf.php? id=<?php echo $data["nodevolucionc"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								
								
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
