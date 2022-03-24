<?php

include "../conexion.php";


        session_start();
        $iduser=$_SESSION['idUser'];

	if($_SESSION['rol']!=1)
    {
	header('location:../');
    }

    $inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select estatus from cajamayor WHERE idcaja='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];

    date_default_timezone_set('America/Bogota');
                        $actual = Date('Y-m-d H:i:s', time());

    if($controlinicio==0)
    {

        mysqli_close($conexion);
        echo "<script>
                alert('No Existe un Cuadre Abierto');
                window.location= '../index.php'
            </script>";

    }else{

    //echo $controlinicial;


            if(!empty($_POST))
            {
                $alert='';
                if(empty($_POST['valor']))
                {
                    $alert='<p class="msg_error">El Gasto debe de tener un Valor.</p>';
                }else{
                        $tipogasto=$_POST['gasto'];
                        $tercero=$_POST['tercero'];
                        $valor=$_POST['valor'];
                        $nota=$_POST['nota'];
                        
                        $procedencia=$_POST['procedencia'];


                        if($_POST['fechareal']){
                            
                            $dia=substr( $_POST['fechareal'], 3, 2 );
                            $mes=substr( $_POST['fechareal'], 0, 2 );
                            $ano=substr( $_POST['fechareal'], 6, 4 );
                            $fechareal=$ano."-".$mes."-".$dia;

                            echo $tercero."/";

                        }else{  
                            date_default_timezone_set('America/Bogota');
                            $fechareal = Date('Y-m-d');
                           
                        }
                        


                        //insertar el gasto dependiendo si es efectivo o consignacion


                    

                            $query_insert=mysqli_query($conexion, "INSERT INTO gasto (idtipogasto, idcliente,
                                                        valorgasto, nota,
                                                        fechareal, idusuario, idcuadre, procedencia)
                                                        VALUES ('$tipogasto','$tercero', '$valor',
                                                        '$nota', '$fechareal', '$iduser',
                                                        '$controlinicial', '$procedencia')");

                            $inicio2=mysqli_query($conexion, "select egresos from cajamayor WHERE idcaja='$controlinicial'");
                            $datoinicio=mysqli_fetch_array($inicio2);
                            $egresos= $datoinicio["egresos"];

                            $egresos=$egresos+$valor;

                            $queryegreso=mysqli_query($conexion, "UPDATE cajamayor
                            SET egresos=$egresos WHERE idcaja=$controlinicial");




                        //si el gasto es un prestamo
//echo "ojoooooooooo".$tipogasto;
if($tipogasto==26){


    $mayorgasto=mysqli_query($conexion, "select MAX(idgasto) from gasto");
    $iniciomayorgasto= mysqli_fetch_array($mayorgasto);
    $ultimogasto=$iniciomayorgasto[0];
   
    $clienteexiste=mysqli_query($conexion, "SELECT * FROM prestamo WHERE
                    id_empleado='$tercero'");

    //echo $actual;
    $result_existe=mysqli_num_rows($clienteexiste);
    
    if($result_existe > 0){
        $siexiste=mysqli_fetch_array($clienteexiste);

        $total=$siexiste["total"];
        $id=$siexiste["id"];
        $total=$total+$valor;

        $queryegreso=mysqli_query($conexion, "UPDATE prestamo
        SET total=$total WHERE id_empleado='$tercero'");

        

        $insertdetalle=mysqli_query($conexion, "INSERT INTO detalleprestamo 
        (id_prestamo, id_gasto, prestamo, fechaprestamo)
        VALUES ($id, $ultimogasto,$valor, '$actual')");

        
    }else{
        $insertcliente=mysqli_query($conexion, "INSERT INTO prestamo 
                            (id_empleado, total)
                    VALUES ($tercero,$valor)");

        $inicioid=mysqli_query($conexion, "select MAX(id) from prestamo");
        $inicioid1= mysqli_fetch_array($inicioid);
        $id=$inicioid1[0];

        $insertdetalle=mysqli_query($conexion, "INSERT INTO detalleprestamo 
        (id_prestamo, id_gasto, prestamo, fechaprestamo)
        VALUES ($id, $ultimogasto,$valor, '$actual')");
    }
}//fin si se puede hacer el Gasto Prestamo-----------------------------------

                                 
                            if( $query_insert && $queryegreso){
                                $alert='<p class="msg_error">Gasto Creado Correctamente. </p>';
                            }else{
                                $alert='<p class="msg_error">Error al Crear el Gasto. </p>';
                            }
                        
                }
            }
    }//fin else cuadre abierto
        

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Registro Gastos Caja Mayor</title>
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
            <h1> Registro de Gastos Caja Mayor</h1>
            
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">

                
                <?php
                    $query_gasto=mysqli_query($conexion, "SELECT * FROM tipo_gasto ORDER BY nombregasto ASC");
                    $result_gasto=mysqli_num_rows($query_gasto);
                    
                ?>
                    <label for="gasto">Tipo de Gasto</label>
                    <select name="gasto" id="gasto">
                <?php
                    if($result_gasto > 0){
                        while($gasto=mysqli_fetch_array($query_gasto)){ 
                ?>
                    <option value="<?php echo $gasto["idtipogasto"]; ?>"><?php echo $gasto["nombregasto"]; ?></option>
                <?php
                    }
                }
                ?>
                </select>

                
                    <label for="tercero">Tercero</label>
                    <select name="tercero" id="tercero">
                    <?php
                        $query_tercero=mysqli_query($conexion, "SELECT * FROM cliente ORDER BY nombrec ASC");
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

                   

                    <label for="valor">Valor</label>
                    <input type="number" pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    name="valor" id="valor" placeholder="Valor Pagado">

                    <label for="valor">Fecha de Pago</label>
                    <input type="text" name="fechareal" id="fechareal" class="tcal" placeholder="Fecha de Pago Gasto">

                    <label for="nota">Nota</label>
                    <input type="text" name="nota" id="nota" placeholder="Nota">

                    <label for="procedencia">Procedencia</label>
                        <select name="procedencia" id="procedencia" value="1">  
                                <option value="2">Efectivo Caja Mayor</option>
                                <option value="3">Consignación</option>
                         </select>
                
            </select>
                
                <input type="submit" value="Crear Gasto" class="btn_save">
		<input type="button" onclick=" location.href='listar_gasto.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>
        
</body>
</html>
