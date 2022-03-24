<?php
    session_start();
    $iduser=$_SESSION['idUser'];
    include "../conexion.php";

    $bandera=1;
    $nomproveedor="";
    $valor=0; $valor2=0;
    $total=0;
    $fechaactual2 ="";
   

    if(!empty($_POST))
    {
       
        $alert='';
        if(empty($_POST['valorpagado']) )
        {
            
            $alert='<p class="msg_error">El Valor Pagado debe Ser Mayor a Cero.</p>';
        }else{

            $debe=$_POST['valor'];
            $idprestamo=$_POST['prestamo'];
            $abono=$_POST['valorpagado'];
            $procedencia=$_POST['procedencia'];
            $empleado=$_POST['empleado'];
            $nota=$_POST['nota'];

            if ($abono>$debe){
                $alert='<p class="msg_error">El Valor pagado NO Puede ser mayor del Adeudado.</p>';

            
            }else{

                date_default_timezone_set('America/Bogota');
                        $fechaactual2 = Date('Y-m-d H:i:s', time());

                
                               //abono prestamo en efectivo
                if($procedencia==1){

                    echo $procedencia."/".$abono;
                $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
                $inicio1= mysqli_fetch_array($inicio);
                $controlinicial=$inicio1[0];

                $inicio2=mysqli_query($conexion, "select ingresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
                $datoinicio=mysqli_fetch_array($inicio2);
                $ingresos= $datoinicio["ingresos"];
               //se modifica el ingreso
                $ingresos=$ingresos+$abono;

                $queryegreso=mysqli_query($conexion, "UPDATE cuadre
                            SET ingresos=$ingresos WHERE idcuadre=$controlinicial");

                $queryabono=mysqli_query($conexion, "INSERT INTO detalleabonoprestamo(id_prestamo, valor, fecha)
                                        VALUES ('$idprestamo','$abono','$fechaactual2')") ;

                }else{

                    $inicioMayor=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
                    $inicioMayor1= mysqli_fetch_array($inicioMayor);
                    $controlMayor=$inicioMayor1[0];

                    

                    $inicioMayor=mysqli_query($conexion, "select ingresos, banco 
                                 from cajamayor WHERE idcaja='$controlMayor'");
                    $datoinicioMayor=mysqli_fetch_array($inicioMayor);
                    $ingresosMayor= $datoinicioMayor["ingresos"];
                    $banco= $datoinicioMayor["banco"];

                   //echo "procedencia".$procedencia."procedencia".$controlMayor;

                    if ($procedencia=='2'){//si el pago es efectivo de caja Mayor
                        $ingresosMayor=$ingresosMayor+$abono;
                        $queryegreso=mysqli_query($conexion, "UPDATE cajamayor
                        SET ingresos=$ingresosMayor WHERE idcaja=$controlMayor");

                        date_default_timezone_set('America/Bogota');
                        $fechaactual2 = Date('Y-m-d H:i:s', time());

                        //echo "control".$controlMayor."control".$fechaactual2."control".$abono.
                                        //"control".$empleado;


                        $queryentrada=mysqli_query($conexion, "INSERT INTO entrada(idcaja, fecha, valorentrada,
                                                    tipoentrada,descripcion)
                                                 VALUES ('$controlMayor','$fechaactual2',
                                                 '$abono', 1 ,'$nota')") ;
                        
                        $queryabono=mysqli_query($conexion, "INSERT INTO detalleabonoprestamo(id_prestamo, valor, fecha, procedencia)
                                        VALUES ('$idprestamo','$abono','$fechaactual2', 2)") ;


                    }else{//si el pago prestamo es consignacion
                        $banco=$banco+$abono;
                        $querySale=mysqli_query($conexion, "UPDATE cajamayor
                        SET banco=$banco WHERE idcaja=$controlMayor");

                        

                        
                        $queryentrada=mysqli_query($conexion, "INSERT INTO entrada(idcaja, fecha, valorentrada,
                                                    tipoentrada,descripcion)
                                                VALUES ('$controlMayor','$fechaactual2',
                                                '$abono', 2 ,'$nota')") ;

                        $queryabono=mysqli_query($conexion, "INSERT INTO detalleabonoprestamo(id_prestamo, valor, fecha, procedencia)
                        VALUES ('$idprestamo','$abono','$fechaactual2', 3)") ;
                    }

                }

                $debe=$debe-$abono; 
                date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());
            
        
            //SE MODIFICA EL total del prestamo
            
                $prestamo=mysqli_query($conexion, "UPDATE prestamo SET total=$debe WHERE id=' $idprestamo'"); 

            //se realiza los pagos que se puedan

                    $querysinpagar=mysqli_query($conexion,"SELECT *  FROM detalleprestamo  WHERE estatusdetalleprestamo=1 
													and id_prestamo='$idprestamo' " );
                    $resultado=mysqli_num_rows($querysinpagar);
                    
                    if($resultado>0){
                    
                    while($sinpagar=mysqli_fetch_array($querysinpagar) ){ 
                        $iddetalle=$sinpagar['id'];
                        
                        if($abono>0){

                            
                            
                            $querydetalle=mysqli_query($conexion,"SELECT abono, prestamo  FROM detalleprestamo  WHERE id='$iddetalle' " );
                            
                            $datodetalle=mysqli_fetch_array($querydetalle);
                            $totaldetalle= $datodetalle["prestamo"];
                            $abonado= $datodetalle["abono"];
                            $saldof=$totaldetalle-$abonado;
                            //echo $abonado."ahh/";

                                if($abono>=$saldof){
                                    $abono=$abono-$saldof;

                                    $abonado= $abonado+$saldof;

                                    
                                    
                                    $queryabono=mysqli_query($conexion, "UPDATE detalleprestamo SET abono='$abonado', 
                                                            fechaabono='$fechaactual2' WHERE id='$iddetalle'");
                                     
                                  

                                        if( $totaldetalle==$abonado){
                                            $query_cobrado=mysqli_query($conexion, "UPDATE detalleprestamo 
                                            SET estatusdetalleprestamo=2  WHERE id='$iddetalle'");
                                            
                                        }
                                }else{
                                    
                                    //$pagado=0;
                                    $abonado=$abonado+$abono;
                                    $abono=0;
                                    
                                    $queryabono=mysqli_query($conexion, "UPDATE detalleprestamo SET abono='$abonado', 
                                                 fechaabono='$fechaactual2' WHERE id=' $iddetalle'");
                                }
                        } 
                    }//fin mientras
                
                }//fin siiiiiiii
            }    
        }      
     
            
    }//fin del post
    

   
    $id=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT p.id_empleado, p.total, c.nombrec  
                                FROM prestamo p
                                INNER JOIN cliente c ON p.id_empleado=c.idcliente
                                WHERE id='$id' " );

    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_compra_credito1.php');
    }else{ 
        
        while($data=mysqli_fetch_array($sql)){ 
            
            $empleado = $data['nombrec'];
            $total = $data['total'];
            
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
	<title>Abonar Prestamo </title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Total Prestamo <BR> <?php echo $empleado;?> </h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="empleado" value="<?php echo $empleado; ?>">
                <input type="hidden" name="prestamo" value="<?php echo $id; ?>">
                <input type="hidden" name="valor" id="valor" value="<?php echo $total; ?>">
                
                
                               
                
                <label for="nota">Valor Total</label>
                <input  name="valor2" id="valor2" placeholder="VALOR PRESTAMO" readonly="readonly" value="<?php echo $total; ?>">

                
                
               
                   
                <?php

                if($bandera==1){
                ?>
                <!--<label for="nota">Forma de Pago</label>
                <select name="tipopago" id="tipopago" value="1">  
                        <option value=1>Efectivo</option>
                        <option value=2>Consignación</option>
                </select>-->
                <label for="valor">Valor a Pagar</label>
                <input type="number" name="valorpagado" id="valorpagado" 
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                 placeholder="VALOR COBRADO" >

                 <label for="procedencia">Procedencia</label>
                        <select name="procedencia" id="procedencia" value="1">  
                                <option value="1">Efectivo</option>
                                <option value="2">Efectivo Caja Mayor</option>
                                <option value="3">Consignación</option>
                         </select>

                <label for="nota">Nota del Abono</label>
                <input  name="nota" id="nota" placeholder="NOTA DEL ABONO">


                 <input type="submit" value="Abonar a Prestamo" class="btn_save">
                <input type="button" onclick=" location.href='listar_prestamo.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
                 <?php

                }
                else{ ?>
                    <input type="button" onclick=" location.href='listar_compra_creditopag.php' " value="Terminar" name="boton" class="btn_cancelado"  />
                <?php    
                }
                ?>


               
                
                
                
                
               
                
                 
            </form>
        </div>
			
	</section>

</body>
</html>
