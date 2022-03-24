<?php
    session_start();
    include "../conexion.php";


	if($_SESSION['rol']!=1)
    {
	header('location:../');
    }

	date_default_timezone_set('America/Bogota');
	$actual = Date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Lista de Compras a Crédito Administrador</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Lista de Compras a Crédito Administrador</h1>
            <a href="nueva_compra.php" class="btn_new"></i> Registrar Compra</a>

			<form action="buscar_compra_credito.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">
			</form>

			


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>Número de Recibo</th>
                    <th>Fecha</th>
		    		<th>Cliente</th>
                    <th>Identificación</th>
					<th>Valor Compra</th>
					<th>Abonos</th>
		    		<th>Acciones</th>
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM factura WHERE estatus=1 
										and tipofactura=2 and abono=0 " );
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




                    $query=mysqli_query($conexion,"SELECT f.nofactura, f.fecha, f.totalfactura, f.abono,  c.nit, c.nombrec FROM
                    factura f INNER JOIN cliente c ON f.codcliente=c.idcliente  WHERE f.estatus=1 and tipofactura=2 and abono=0 ORDER BY 
					fecha DESC LIMIT $desde, $por_pagina" );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["nofactura"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["nit"]; ?></td>
							
							<td><?php echo number_format($data["totalfactura"], 0, ",", "."); ?></td>
							<td><?php echo number_format($data["abono"], 0, ",", "."); ?></td>
							<td>
                               
								<a class="link_edit" href="factura_pdf.php? id=<?php echo $data["nofactura"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
								|
								
                                <a class="link_delete" href="eliminar_confirmar_compracre.php? 
								id=<?php echo $data["nofactura"]; ?>"><i class="fas fa-trash-alt"></i>Anular Compra</a>
								|
								<a class="link_delete" href="pagar_compra_credito.php? 
									id=<?php echo $data["nofactura"]; ?>"><i class="fas fa-dollar-sign"></i>Pagar Compra</a>	
									
                                
								
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
