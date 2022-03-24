
<?php
    
    

    include "../conexion.php";

    session_start();

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }

    $consultaPro="SELECT codproducto, descripcion FROM producto";
	$resultadoP0=mysqli_query($conexion, $consultaPro); 
	$resultadoP1=mysqli_query($conexion, $consultaPro); 
	$resultadoP2=mysqli_query($conexion, $consultaPro);
	$resultadoP3=mysqli_query($conexion, $consultaPro); 
	$resultadoP4=mysqli_query($conexion, $consultaPro);
	$resultadoP5=mysqli_query($conexion, $consultaPro);

    if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST['codproducto']) ||  empty($_POST['pesoproducto']) )
        {
            $alert='<p class="msg_error">El Material a Recuperar debe de tener Descripción y Peso.</p>';
        }else{
                
                $codproducto=$_POST['codproducto'];
                $pesoproducto=$_POST['pesoproducto'];

                    $consulta=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$codproducto'");
                    $data=mysqli_fetch_array($consulta);
                    $existencia= $data["existencia"];
                    $existencia=$existencia-$pesoproducto;
                    $query_existencia=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia WHERE codproducto='$codproducto'");


                if($_POST['peso0']){ 
                    $cod0=$_POST['cbx_prod0'];
                    $peso0=$_POST['peso0'];

                    $consulta0=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$cod0'");
                    $data0=mysqli_fetch_array($consulta0);
                    $existencia0= $data0["existencia"];
                    $existencia0=$existencia0+$peso0;
                    $query_existencia0=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia0 WHERE codproducto='$cod0'");
                }

                if($_POST['peso1']){ 
                    $cod1=$_POST['cbx_prod1'];
                    $peso1=$_POST['peso1'];

                    $consulta1=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$cod1'");
                    $data1=mysqli_fetch_array($consulta1);
                    $existencia1= $data1["existencia"];
                    $existencia1=$existencia1+$peso1;
                    $query_existencia1=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia1 WHERE codproducto='$cod1'");
                }

                if($_POST['peso2']){ 
                    $cod2=$_POST['cbx_prod2'];
                    $peso2=$_POST['peso2'];

                    $consulta2=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$cod2'");
                    $data2=mysqli_fetch_array($consulta2);
                    $existencia2= $data2["existencia"];
                    $existencia2=$existencia2+$peso2;
                    $query_existencia2=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia2 WHERE codproducto='$cod2'");
                }

                if($_POST['peso3']){ 
                    $cod3=$_POST['cbx_prod3'];
                    $peso3=$_POST['peso3'];

                    $consulta3=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$cod3'");
                    $data3=mysqli_fetch_array($consulta3);
                    $existencia3= $data3["existencia"];
                    $existencia3=$existencia3+$peso3;
                    $query_existencia3=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia3 WHERE codproducto='$cod3'");
                }

                if($_POST['peso4']){ 
                    $cod4=$_POST['cbx_prod4'];
                    $peso4=$_POST['peso4'];

                    $consulta4=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$cod4'");
                    $data4=mysqli_fetch_array($consulta4);
                    $existencia4= $data4["existencia"];
                    $existencia4=$existencia4+$peso4;
                    $query_existencia4=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia4 WHERE codproducto='$cod4'");
                }

                if($_POST['peso5']){ 
                    $cod5=$_POST['cbx_prod5'];
                    $peso5=$_POST['peso5'];

                    $consulta5=mysqli_query($conexion,"SELECT existencia FROM producto WHERE codproducto='$cod5'");
                    $data5=mysqli_fetch_array($consulta5);
                    $existencia5= $data5["existencia"];
                    $existencia5=$existencia5+$peso5;
                    $query_existencia5=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia5 WHERE codproducto='$cod5'");
                }






                
                    

                    if( $query_existencia  || $query_existencia0 || $query_existencia1
                        || $query_existencia2 || $query_existencia3
                        || $query_existencia4 || $query_existencia5){
                        $alert='<p class="msg_error">Material Recuperado. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Recuperar el Artículo. </p>';
                    }
            }   
    }
    



    //consulta de productos

    
         $query_pro=mysqli_query($conexion, "SELECT codproducto, descripcion FROM producto");
	     mysqli_close($conexion);
         $result_pro=mysqli_num_rows($query_pro);
	

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Recuperar Material</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1><i class="fas fa-plus"></i>  Recuperar Material</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                
                <label for="derivaproducto">Producto de donde se Recupera</label>


                <select name="codproducto" id="codproducto" placeholder="Producto">  
                    <?php
                        if($result_pro > 0){
                            while($pro=mysqli_fetch_array($query_pro)){ 
                    ?>
                            <option value="<?php echo $pro["codproducto"]; ?>"><?php echo $pro["descripcion"]; ?></option>
                    <?php
                        }
                    }
		            ?>
		        </select>

                <label for="Descripción">Peso Total del Material</label>
                <input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="pesoproducto">
                

               
					
					
                    <br>
					<div class="wd100">
						<h4>Productos Recuperados</h4>
					</div>




			<table class="tbl_venta">
			<thead>
				
				<tr>
					<th colspan="2">Descripción</th>
					<th colspan="2">Peso</th>
					<th colspan="2">Descripción</th>
					<th colspan="2">Peso</th>
					

									
				</tr>
			</thead>
			<tbody id="detalle_venta">
				
				<tr>
					<td colspan="2">
						<select id="cbx_prod0" name="cbx_prod0">
								<?php 
									WHILE($row=$resultadoP0->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso0"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod1" name="cbx_prod1">
            				<?php 
								WHILE($row=$resultadoP1->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso1"></div>
					</td>
                </tr>


                <tr>
					<td colspan="2">
						<select id="cbx_prod2" name="cbx_prod2">
								<?php 
									WHILE($row=$resultadoP2->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso2"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod3" name="cbx_prod3">
            				<?php 
								WHILE($row=$resultadoP3->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso3"></div>
					</td>
                </tr>

                <tr>
					<td colspan="2">
						<select id="cbx_prod4" name="cbx_prod4">
								<?php 
									WHILE($row=$resultadoP4->fetch_assoc()){  
								?>
								<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
								<?php } ?>
						</select>
						</td>
						<td colspan="2">
								<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
								onkeypress="return filterFloat(event,this);" name="peso4"></div>
					</td>

					<td colspan="2">
					<select id="cbx_prod5" name="cbx_prod5">
            				<?php 
								WHILE($row=$resultadoP5->fetch_assoc()){  
							?>
                   			<option value="<?php echo $row['codproducto']; ?>"><?php echo $row['descripcion']; ?></option>
            				<?php } ?>
        			</select>
					</td>
					<td colspan="2">
							<div class="wd75"><input type="number" min="0" step="any" style="font-size:22px;  maxlength="6" 
							onkeypress="return filterFloat(event,this);" name="peso5"></div>
					</td>
                </tr>

					

					



			</tbody>
		</table>	

				

               
                
                
           
                </select>
                
                <input type="submit" value="Recuperar Material" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
        </div>
			
	</section>

		
        
        
</body>
</html>
