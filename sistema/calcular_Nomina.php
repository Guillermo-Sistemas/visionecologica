<?php
	include "../conexion.php";
	mysqli_set_charset($conexion,'utf8'); 

	session_start();

	if($_SESSION['rol']!=1)
    {
	header('location:../');
    }else{

        $iduser=$_SESSION['idUser'];

        $empleado=""; $nota=""; $devengado=0; $descuento=0;$auxilio=0;
        $salud=0; $pension=0; $horas=0; $extras=0; $saluemp=0; $pensionemp=0; $totalemp=0;
		$nombre=""; $pagar=0; $arl=0; $confa=0; $saludemp=0; $basico=0;


           
                if(empty($_POST['idcliente']) || empty($_POST['salario']) ||  empty($_POST['dias']))
                {
                    $alert='<p class="msg_error">Debe de Ingresar Empleado, Salario Básico, días Laborados y Periodo de Pago.</p>';
                }else{
                        $empleado=$_POST['idcliente'];
                        $basico=$_POST['salario'];
                        $aux=$_POST['aux'];
                        $dias=$_POST['dias'];
						if(!empty($_POST['horas']))
                		{
                        	$horas=$_POST['horas'];
						}else{
                        	$horas=0;
						}
						if(!empty($_POST['date1']) && !empty($_POST['date2']))
                		{
                        	$nota="Salario del ".$_POST['date1']. " al ".$_POST['date2'] ;
						}


                        $ordinario=$basico/30*$dias;
                        $auxilio=round($aux/30*$dias);
                        $extras=($basico/240*1.25) *  $horas;
						$extras=round($extras);

                        $devengado=round($ordinario+$extras+$auxilio);

                        $salud=round(($ordinario+$extras)*4/100);
						$saludemp=round(($ordinario+$extras)*8.5/100);
                        $pension=round(($ordinario+$extras)*4/100);
						$pensionemp=round(($ordinario+$extras)*12/100);
                        $arl=round(($ordinario+$extras)*1.044/100);
                        $confa=round(($ordinario+$extras)*4/100);

						$totalemp=$saludemp+$pensionemp+$arl+$confa;


                        $descuento=$salud+$pension;

                        $pagar=$devengado-$descuento;


                       
						$sql=mysqli_query($conexion,"SELECT nombrec FROM cliente WHERE idcliente=$empleado");
    					$result_sql=mysqli_num_rows($sql);
						$data = mysqli_fetch_array($sql); 
						$nombre = $data['nombrec' ];






                    

                          /*  $query_insert=mysqli_query($conexion, "INSERT INTO gasto (idtipogasto, idcliente, valorgasto,nota, idusuario, idcuadre)
                                            VALUES ('$tipogasto','$tercero', '$valor', '$nota', '$iduser','$controlinicial')");

                                $egresos=$egresos+$valor;

                                $queryegreso=mysqli_query($conexion, "UPDATE cuadre
                                SET egresos=$egresos WHERE idcuadre=$controlinicial");


                                
                            if( $query_insert && $queryegreso){
                                $alert='<p class="msg_error">Gasto Creado Correctamente. </p>';
                            }else{
                                $alert='<p class="msg_error">Error al Crear el Gasto. </p>';
                            }*/
                        
                }
            
}
        




						
mysqli_close($conexion);
	
	
?>



<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Calcular Nómina</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Calcular Nómina</h1>
		</div>
				
			<form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos" action="liquidar_Nomina.php" method="POST">
			
			<?php
			if(!empty($_POST['idcliente']) || !empty($_POST['salario']) ||  !empty($_POST['dias']))
			{
					
			?>
										
					<div class="wd100">
						<h4>Salario a Pagar a <?php echo $nombre.$nota ?>  $ <?php echo $pagar ?></h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="1">Salario Ordinario</th>
					<th colspan="1">Aux Transporte</th>
					<th colspan="1">Horas Extras <?php echo $horas; ?></th>
					<th colspan="2">DEVENGADO</th>
					
				</tr>
			</thead>
			<tbody id="detalle_venta">


				
						<tr>
							
							<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $empleado; ?>">
							<input type="hidden" name="horas" id="horas" value="<?php echo $horas; ?>">
							<input type="hidden" name="dias" id="dias" value="<?php echo $dias; ?>">
							<input type="hidden" name="pagar" id="pagar" value="<?php echo $pagar; ?>">
							<input type="hidden" name="nota" id="nota" value="<?php echo $nota; ?>">
							
							<td colspan="1">
								<input type="text" name="basico" id="basico" readonly="readonly" value="<?php echo $basico/2; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="aux" id="aux" readonly="readonly" value="<?php echo $auxilio; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="extras" id="extras" readonly="readonly" value="<?php echo $extras; ?>">
							</td>
							<td colspan="2">
								<input type="text" name="devengado" id="devengado" readonly="readonly" value="<?php echo $devengado; ?>">
							</td>
							
						</tr>



				<thead>
				
				<tr>
					<th colspan="1">Salud</th>
					<th colspan="2">Pension</th>
					<th colspan="2">DESCUENTOS</th>
					
				</tr>

				</thead>

				<tr>
							
							<td colspan="1">
								<input type="text" name="salud" id="salud" readonly="readonly" value="<?php echo $salud; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="pension" id="pension" readonly="readonly" value="<?php echo $pension; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="" id="" readonly="readonly" ">
							</td>
							<td colspan="2">
								<input type="text" name="descuento" id="descuento" readonly="readonly" value="<?php echo $descuento; ?>">
							</td>
							
				</tr>

				<thead>

				<tr>
				<th colspan="5">APORTES DE LA EMPRESA</th>
					
				</tr>
				
				<tr>
					<th colspan="1">Salud</th>
					<th colspan="1">Pension</th>
					<th colspan="1">ARL</th>
					<th colspan="1">CONFAMILIARES</th>
					<th colspan="1">TOTAL APORTE EMPRESA</th>
					
				</tr>
						<tr>

							<td colspan="1">
								<input type="text" name="saludemp" id="saludemp" readonly="readonly" value="<?php echo $saludemp; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="pensionemp" id="pensionemp" readonly="readonly" value="<?php echo $pensionemp; ?>">
							</td>
							<td colspan="1">
							<input type="text" name="arl" id="arl" readonly="readonly" value="<?php echo $arl; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="confa" id="confa" readonly="readonly" value="<?php echo $confa; ?>">
							</td>
							<td colspan="1">
								<input type="text" name="totalemp" id="totalemp" readonly="readonly" value="<?php echo $totalemp; ?>">
							</td>
						</tr>

						<tr>

						<td colspan="3">
							<label><h1><?php echo "TOTAL A PAGAR   $".($pagar+$totalemp); ?></h1></label>
						</td>
							
						</tr>

				
					<?php
						
					}
					?>


				
			</tbody>
		</table>	

					

					<div class="wd30"><input type="submit" class="btn_procesar" value="Pagar Salario"></div>

				s
				
					
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Cancelar " name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
