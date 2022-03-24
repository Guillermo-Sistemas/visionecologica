<?php

include "../conexion.php";
mysqli_set_charset($conexion,'utf8'); 

$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
$inicio1= mysqli_fetch_array($inicio);
$controlinicial=$inicio1[0];

$inicio2=mysqli_query($conexion, "select egresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
$datoinicio=mysqli_fetch_array($inicio2);

    $egresos= $datoinicio["egresos"];
    $controlinicio= $datoinicio["estatus"];

    if($controlinicio==0)
    {

        mysqli_close($conexion);
        echo "<script>
                alert('No Existe un Cuadre Abierto');
                window.location= '../index.php'
            </script>";

    }else{
	session_start();

	$valor1=0;

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }


	if(empty($_REQUEST['id']) )
	{
		header("location: listar_recuperado.php");
	}else{
		//consulta de clientes
		$consultaCli="SELECT idcliente, nombrec FROM cliente";
		$resultadoC=mysqli_query($conexion, $consultaCli);
		
		$codrecuperado1=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT descripcion_recuperado, peso_recuperado, precioventa_recuperado 
										FROM recuperado WHERE codrecuperado=$codrecuperado1 ");
                
				$result =mysqli_num_rows($query);


				//date_default_timezone_set('America/Bogota');
                //$fechaactual2 = Date('Y-m-d H:i:s', time());


                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						$descripcion1=$data['descripcion_recuperado'];
						$valor1=$data['precioventa_recuperado'];
						

					}
					$subtotal1=$valor1;
				}else{
					
					header("location: listar_recuperado.php");
				}
	}

	
	
	
		
	
	
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Calcular Venta Artículo</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Calcular Venta de Artículo</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="Vender_recuperado.php" method="POST">
					<input type="hidden" name="action" value="addCliente">
					<input type="hidden" id="idcliente" name="idcliente" value="" required>
					<div class="wd30">
						<h4>Datos del Cliente</h4>
					</div>

					<div class="wd30">
						<label>Nombre</label>	


							<select id="cbx_cliente" name="cbx_cliente">
            				<?php 
								WHILE($row=$resultadoC->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['idcliente']; ?>"><?php echo $row['nombrec']; ?></option>
            				<?php } ?>
        					</select>
					</div>
					
					
					
					

					<div class="wd100">
						<h4>Detalle de la Venta</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Descripción</th>
					<th colspan="2">Valor de Venta</th>
					<th colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody id="detalle_venta">


				
					
				
					<tr>
						<input type="hidden" name="codrecuperado1" id="codrecuperado1" value="<?php echo $codrecuperado1; ?>">
						<td colspan="1">
							<input type="text" name="descripcion1" id="descripcion1" readonly="readonly" value="<?php echo $descripcion1; ?>">
						</td>
						
						<td colspan="2">
							<input type="number" name="valor1" id="valor1"  value="<?php echo $valor1; ?>">
						</td>
						<td colspan="2">
							<input type="text" name="subtotal1" id="subtotal1" readonly="readonly" value="<?php echo $subtotal1; ?>">
						</td>
					</tr>
					
						

				


				

				
			</tbody>
		</table>	

					<div class="wd30"><input type="submit" class="btn_procesar" value="Vender"></div>
				
					<label class="content-input">
						<input type="checkbox" name="credito" id="credito" value="credito">Crédito
						<i></i>
					</label>
				
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar Venta" name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>


<?php
}
?>