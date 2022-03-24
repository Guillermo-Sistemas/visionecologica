<?php

include "../conexion.php";
session_start();


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
	<title>Nomina</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
    <link rel="stylesheet" type="text/css" href="css/tcal.css" />
    <script type="text/javascript" src="js/tcal.js"></script> 
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1>Salario Empleado</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form  action="calcular_Nomina.php" method="post">

                
                    <label for="tercero">Nombre Empleado</label>
                    <select name="idcliente" id="idcliente">
                        <?php
                            $query_tercero=mysqli_query($conexion, "SELECT idcliente, nombrec FROM cliente WHERE tipo_cliente='Empleado'");
                            $result_tercero=mysqli_num_rows($query_tercero);

                            mysqli_close($conexion);
                            if($result_tercero > 0){
                                while($tercero=mysqli_fetch_array($query_tercero)){ 
                            
                        ?>
                            <option value="<?php echo $tercero["idcliente"]; ?>"><?php echo $tercero["nombrec"]; ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>

                    <label for="valor">Salario Básico</label>
                    <input type="number" pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    name="salario" id="salario" placeholder="SALARIO BÁSICO MENSUAL $908.526">

                    <label for="valor">Auxilio de Transporte</label>
                    <input type="number" pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    name="aux" id="aux" placeholder="AUXILIO DE TRANSPORTE MENSUAL">

                                 


                    <label for="dias">Días Laborados</label>
                    <input type="number" pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    name="dias" id="dias" placeholder="Días Laborados">

                    <label for="valor">Horas Extras</label>
                    <input type="number" pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    name="horas" id="horas" placeholder="HORAS EXTRAS" >

                    <label for="nota">fecha Inicial</label>
                    <div><input type="text" name="date1" class="tcal" placeholder="Mes/Dia/Año" value="" /></div>

                    <label for="nota">fecha Final</label>
                    <div><input type="text" name="date2" class="tcal" placeholder="Mes/Dia/Año" value="" /></div>
                
           
                
                <input type="submit" value="Calcular Salario" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>
        
</body>
</html>

