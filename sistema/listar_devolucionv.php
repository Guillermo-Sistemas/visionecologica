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
	<title>Lista de Devoluciones de Ventas</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Devoluciones de Ventas</h1>
            

			<br>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>No. Devolución</th>
                    <th>Fecha</th>
		    		<th>Cliente</th>
                    <th>Productos</th>
					<th>Valor Devuelto</th>
					<th>Motivo</th>
		    <th>Imprimir</th>
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM devolucionv
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




                    $query=mysqli_query($conexion,"SELECT d.nodevolucionv, d.fechadevv, d.total_devv, d.motivo, c.nombrec FROM
                    								devolucionv d  INNER JOIN cliente c ON d.codcliente=c.idcliente  
													WHERE d.estatus=1 ORDER BY fechadevv DESC LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<?php
								 $nofv=$data["nodevolucionv"];
							?>

							<td><?php echo $nofv; ?></td>
							<td><?php echo $data["fechadevv"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>

							<?php
								 $nomproducto=mysqli_query($conexion, "select nomproducto FROM detalledevv 
								 WHERE nodevolucionv='$nofv' ");
		
								$resultnompro =mysqli_num_rows($nomproducto);
					
								if ($resultnompro){
									$productos="";
									while($datanp=mysqli_fetch_array($nomproducto)){
										$productos=$datanp["nomproducto"].", ".$productos;
									}
								}
							?>



							<td><?php echo $productos; ?></td>
							<td><?php echo $data["total_devv"]; ?></td>
							<td><?php echo $data["motivo"]; ?></td>
							<td>
                               
								<a class="link_edit" href="facturadevv_pdf.php? id=<?php echo $data["nodevolucionv"]; ?>"
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
