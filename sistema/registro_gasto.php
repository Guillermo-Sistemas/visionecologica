<?php

include "../conexion.php";

$inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
$inicio1= mysqli_fetch_array($inicio);
$controlinicial=$inicio1[0];
$tipogasto=-1;
$query_insert=null;

$valor=0;

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
        $iduser=$_SESSION['idUser'];

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }


            if(!empty($_POST))
            {
                $alert='';
                if(empty($_POST['valor']))
                {
                    $alert='<p class="msg_error">El Gasto debe de tener un Valor.</p>';
                }else{

                    if (1==2){
                        $nuevocliente=$_POST['nuevo'];
                        $query_insert=mysqli_query($conexion, "INSERT INTO cliente(nit, nombrec, telefono, direccion, tipo_cliente)
                                        VALUES ('0','$nuevocliente', '0', 'No tiene','temporal')");
                                        $inicio=mysqli_query($conexion, "select MAX(idcliente) from cliente");
                                        $inicio1= mysqli_fetch_array($inicio);
                                        $controlcliente=$inicio1[0];
                                        $tercero=$controlcliente;
                        
                    }else{
                        $tercero=$_POST['tercero'];
                    }
                        
                        $tipogasto=$_POST['gasto'];
                        $valor=$_POST['valor'];
                        $nota=$_POST['nota'];
                        $procedencia=$_POST['procedencia'];

                        date_default_timezone_set('America/Bogota');
                        $actual = Date('Y-m-d H:i:s', time());
                        $actual2 = Date('Y-m-d ');

                        $nombregasto=mysqli_query($conexion, "SELECT nombregasto FROM tipo_gasto WHERE idtipogasto=$tipogasto");

                        //se ingresa el Gasto

                        $query_insert=mysqli_query($conexion, "INSERT INTO gasto 
                                        (idtipogasto, idcliente, valorgasto,nota, 
                                        idusuario, idcuadre, procedencia, fechareal)
                                        VALUES ('$tipogasto','$tercero', '$valor', '$nota', 
                                        '$iduser','$controlinicial','$procedencia', $actual2)");

                        $inicioMayor=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
                        $inicioMayor1= mysqli_fetch_array($inicioMayor);
                        $controlMayor=$inicioMayor1[0];

                        //ultimo gasto

                        //echo $controlMayor;


                        //si el gasto es en efectivo de la caja general********************
                        if ($procedencia==1){
                                $egresos=$egresos+$valor;
                                $queryegreso=mysqli_query($conexion, "UPDATE cuadre
                                SET egresos=$egresos WHERE idcuadre=$controlinicial");
                        }else{
                            $inicioMayor=mysqli_query($conexion, "select egresos, bancosale 
                                        from cajamayor WHERE idcaja='$controlMayor'");
                            $datoinicioMayor=mysqli_fetch_array($inicioMayor);
                            $egresosMayor= $datoinicioMayor["egresos"];
                            $bancoSale= $datoinicioMayor["bancosale"];

                            if ($procedencia==2){//si el gasto es efectivo de caja Mayor
                                $egresosMayor=$egresosMayor+$valor;
                                $queryegreso=mysqli_query($conexion, "UPDATE cajamayor
                                SET egresos=$egresosMayor WHERE idcaja=$controlMayor");

                                date_default_timezone_set('America/Bogota');
                                $fechaactual2 = Date('Y-m-d H:i:s', time());


                                $querysalida=mysqli_query($conexion, "INSERT INTO salida(idcaja, fecha, valorsalida,
                                                            tiposalida,descripcion_s)
                                                        VALUES ('$controlMayor','$fechaactual2',
                                                        '$valor', 1 ,'$nota')") ;
                            }else{//si el gasto es consignacion
                                $bancoSale=$bancoSale+$valor;
                                $querySale=mysqli_query($conexion, "UPDATE cajamayor
                                SET bancosale=$bancoSale WHERE idcaja=$controlMayor");

                                
                                $querysalida=mysqli_query($conexion, "INSERT INTO salida(idcaja, fecha, valorsalida,
                                                            tiposalida,descripcion_s)
                                                        VALUES ('$controlMayor','$fechaactual2',
                                                        '$valor', 2 ,'$nota')") ;
                            }
                        }//fin ********************************************************

                             

                    }

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
                                VALUES ($id, $ultimogasto,$valor, '$actual')");//*****acaaaa */

                                
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
                        }//fin si se puede hacer el Gasto---------------------------------------
                if( $query_insert ){
                    $alert='<p class="msg_error">Gasto Creado Correctamente. </p>';
                }else{
                    $alert='<p class="msg_error">Error al Crear el Gasto. </p>';
                }
            }//si se manda el formulario------------------------------------------------
        }//si hau usuario logueado------------------------------------------------------

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Registro Gastos</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1> Registro de Gastos</h1>
            
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">

                
                <?php
                    $query_gasto=mysqli_query($conexion, "SELECT * FROM tipo_gasto ORDER BY nombregasto ASC");
                    $result_gasto=mysqli_num_rows($query_gasto);
                    
                ?>
                    <label for="gasto">Gasto</label>
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
                        $query_tercero=mysqli_query($conexion, "SELECT * FROM cliente 
                                        WHERE tipo_cliente!='temporal' and estatus=1 ORDER BY nombrec ASC");
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

                    <!--label for="tercero">Nuevo Tercero</label>
                    <input type="text" name="nuevo" id="nuevo" placeholder="Nuevo Tercero"-->


                    <label for="valor">Valor</label>
                    <input type="number" pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    name="valor" id="valor" placeholder="Valor Pagado">

                    <label for="nota">Nota</label>
                    <input type="text" name="nota" id="nota" placeholder="Nota">

                    <label for="procedencia">Procedencia</label>
                        <select name="procedencia" id="procedencia" value="2">  
                               
                                <option value="2">Efectivo Caja Mayor</option>
                                <option value="3">Consignación</option>
                         </select>
                    
               
                    
                    <input type="submit" value="Crear Gasto" class="btn_save">
            <input type="button" onclick=" location.href='listar_gasto.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>
        
</body>
</html>
