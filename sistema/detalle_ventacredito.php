<?php
    session_start();
    include "../conexion.php";

	$estatus=0;

	if(empty($_GET['id']))
    {
    
    }
	$numfactura=$_GET['id'];

					$query=mysqli_query($conexion,"SELECT f.nofacturav, f.fecha, f.abono, f.totalfactura, f.estatus, c.nit, c.nombrec  FROM
                    								facturaV f  INNER JOIN cliente c ON f.codcliente=c.idcliente  
													WHERE nofacturav='$numfactura'" );
					$result =mysqli_num_rows($query);


					$queryabono=mysqli_query($conexion,"SELECT a.idabono, a.fecha, a.valor, a.tipo_abv, u.nombre  FROM
                    								abonov a  INNER JOIN usuario u ON a.usuario_abv=u.idusuario  
													WHERE facturav='$numfactura' and estatus_abv=1" );
					$result1 =mysqli_num_rows($queryabono);
					

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Detalle de Abonos Venta Crédito</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
			<h1>Venta Crédito</h1>
            <a href="nueva_venta.php" class="btn_new"></i> Registrar Venta</a>
			<table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>No.Recibo</th>
                    <th>Fecha</th>
		    		<th>Cliente</th>
                    <th>Identificación</th>
					<th>Valor Crédito</th>
					
		   			<th>Acciones</th>
                </tr>

					<tr>
						<?php
					if($result > 0){
                        while($data=mysqli_fetch_array($query)){
						?>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["nofacturav"]; ?></td>
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $data["nombrec"]; ?></td>
							<td><?php echo $data["nit"]; ?></td>
							<td><?php echo $data["totalfactura"]; ?></td>
							<?php
							$estatus=$data["estatus"];
							?>
							<td>
                               
								<a class="link_edit" href="facturaV_pdf.php? id=<?php echo $data["nofacturav"]; ?>"
								target="_blank" ><img alt="Imprimir" src="imagenes/imprimir.ico" width="40" height="30" /></a>
							</td>
                        </tr>

						<?php
						}
					}
				?>
	        </table>
	</section>



	<section class="contenido">
			<h1>Detalle de Abonos</h1>
            <table>
                <tr>
                    <!-- <th>ID</th>-->
                    <th>Fecha</th>
                    <th>Valor</th>
		    		<th>Forma de Pago</th>
                    <th>Cajero</th>
					<!--<th>Acciones</th>-->
                </tr>


				<tr>
						<?php
					if($result1 > 0){
                        while($data=mysqli_fetch_array($queryabono)){
						?>
                             <!--<td><?php// echo $data["idcliente"]; ?></td>-->
							<td><?php echo $data["fecha"]; ?></td>
							<td><?php echo $data["valor"]; ?></td>

							<?php if ($data["tipo_abv"]==1){
									$tipo="Efectivo";
								  }else{
									  $tipo="Consignación";
								  }
							?>
							<td><?php echo $tipo; ?></td>
							<td><?php echo $data["nombre"]; ?></td>

							<?php
								/*if ($estatus!=2){
							?>
							<td>
                               
								<a class="link_delete" href="eliminar_confirmar_venta.php? 
								id=<?php echo $data["nofacturav"]; ?>"><i class="fas fa-pen-alt"></i></i>Editar</a>
								|
								
                                <a class="link_delete" href="eliminar_confirmar_venta.php? 
								id=<?php echo $data["nofacturav"]; ?>"><i class="fas fa-trash-alt"></i>Eliminar</a>
							</td>
							<?php
								}*/
							?>
                        </tr>

						<?php
						}
					}
				?>

						
	        </table>
	</section>
		
</body>
</html>
