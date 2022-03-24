<?php
    session_start();
    include "../conexion.php";
	if($_SESSION['rol']!=1)
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
	<title>Pago de Nómina</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Pago de Nómina</h1>
            
			<form action="buscar_nomina.php" method="get" class="form_search">
				<input type="text" name="busqueda" id="busqueda" placeholder="buscar">
				<input type="submit" value="buscar" class="btn_search">

			</form>


            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>EMPLEADO</th>
                    <th>FECHA</th>
					<th>VALOR EMPLEADO</th>
		    		<th>VALOR EMPRESA</th>
                    <th>TOTAL</th>
					
		    <th>Acciones</th>
                </tr>

				<?php

				//paginador

				$sql_registe=mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM nomina" );
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




                    $query=mysqli_query($conexion,"SELECT n.idnomina, n.idempleado, n.fecha, n.ordinario,n.dias,
													n.extras, n.valorextras, n.auxilio, n.salud, n.pension, n.saludem, n.pensionem, n.arl, n.confa, c.nombrec
													FROM nomina n INNER JOIN cliente c ON n.idempleado=c.idcliente " );
					
					$result =mysqli_num_rows($query);
					
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){

							$empleado=round(($data["ordinario"]/15*$data["dias"])+$data["valorextras"]+$data["auxilio"]-$data["salud"]-$data["pension"]);
				?>
						<tr>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $empleado; ?></td>
							
							<td>
                                <a class="link_edit" href="editar_tercero.php? id=<?php echo $data["idnomina"]; ?>"><i class="fas fa-pen-alt"></i>Editar</a>
                                
								|
								<?php if($data["idnomina"] >0){?>
                                <a class="link_delete" href="eliminar_confirmar_tercero.php? id=<?php echo $data["idnomina"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
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