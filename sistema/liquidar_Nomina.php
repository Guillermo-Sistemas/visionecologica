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


           
               
                        $empleado=$_POST['idcliente'];

						if(!empty($_POST['horas']))
                		{
                        	$horas=$_POST['horas'];
						}
						$dias=$_POST['dias'];
						$pagar=$_POST['pagar'];

                        $basico=$_POST['basico'];
                        $auxilio=$_POST['aux'];
						$extras=$_POST['extras'];
						$devengado=$_POST['devengado'];
						$nota=$_POST['nota'];
                       
						
						if(!empty($_POST['periodo']))
                		{
                        	$nota=" ".$_POST['periodo'];
						}

						$salud=$_POST['salud'];
						$pension=$_POST['pension'];
						$descuento=$_POST['descuento'];

						$saludemp=$_POST['saludemp'];
						$pensionemp=$_POST['pensionemp'];
						$arl=$_POST['arl'];
						$confa=$_POST['confa'];
						$totalemp=$_POST['totalemp'];


                       


                       
						$sql=mysqli_query($conexion,"SELECT nombrec FROM cliente WHERE idcliente=$empleado");
    					$result_sql=mysqli_num_rows($sql);
						$data = mysqli_fetch_array($sql); 
						$nombre = $data['nombrec' ];

						//se registra el movimiento de la nomina en la caja mayor
						$caja=mysqli_query($conexion, "SELECT MAX(idcaja) from cajamayor ");
						$caja1= mysqli_fetch_array($caja);
						$controlcaja=$caja1[0];
		
						$caja2=mysqli_query($conexion, "SELECT egresos from cajamayor WHERE idcaja='$controlcaja' ");
						$datocaja=mysqli_fetch_array($caja2);
						//se suma el abono al banco
						$egresos= $datocaja["egresos"];
						$egresos=$egresos+$pagar+$totalemp;

						// echo $egresos;

						$query_caja=mysqli_query($conexion, "UPDATE cajamayor SET egresos=$egresos WHERE idcaja='$controlcaja'"); 
		
						date_default_timezone_set('America/Bogota');
						$fechaactual2 = Date('Y-m-d H:i:s', time());

						$v=$pagar+$totalemp;

						//echo $empleado."/".$fechaactual2."/".$basico."/". $dias."/".$extras."/".$auxilio."/"
										//.$salud."/".$pension."/". $saludemp."/".$pensionemp."/".$arl."/".$confa;

						$querynomina=mysqli_query($conexion, "INSERT INTO nomina (idempleado, fecha, ordinario,dias,
													extras, valorextras, auxilio, salud, pension, saludem, pensionem, arl, confa)
													VALUES ('$empleado','$fechaactual2','$basico','$dias','$horas','$extras','$auxilio'
													,'$salud','$pension','$saludemp','$pensionemp','$arl','$confa')") ;
		
						$querysalida=mysqli_query($conexion, "INSERT INTO salida(idcaja, fecha, valorsalida,descripcion_s)
													VALUES ('$controlcaja','$fechaactual2','$v','Nomina de . $nombre. del . $nota ')") ;

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
	<title>Nómina Liquidad</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        	
	<div class="datos_cliente">	
		<div class="title_page">
			<h1><i class="fas fa-cube"></i>Nómina Liquidad</h1>
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
							
							<td colspan="1">
								<input type="text" name="basico" id="basico" readonly="readonly" value="<?php echo $basico; ?>">
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

					

					<div class="wd30"><input type="button" onclick=" location.href='imprimir_nomina.php'" target="_blank" 
											class="btn_procesar" value="Imprimir"></div>

					
				
					
					<div class="wd30"><input type="button" onclick=" location.href='index.php'" target="_blank" 
					                value="Terminar " name="boton" class="btn_anular"  /></div>


		

			</form>
		</div>
			<div id="acciones_venta">

			
					
					
								
						
			
		</div>

		
	</section>
		
</body>
</html>
