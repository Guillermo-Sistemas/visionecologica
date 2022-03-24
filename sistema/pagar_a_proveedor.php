<?php
    session_start();
    $iduser=$_SESSION['idUser'];
    include "../conexion.php";

    $bandera=1;
    $nomproveedor="";
    $valor=0; $valor2=0;
    $nofactura=0;

    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['valorpagado']) )
        {
            
            $alert='<p class="msg_error">El Valor Pagado debe Ser Mayor a Cero.</p>';
        }else{
            
            $valor=$_POST['valor'];
            $idproveedor=$_POST['cliente'];
            $pagado=$_POST['valorpagado'];
            $tipo=$_POST['tipopago'];

            if ($pagado>$valor){
                $alert='<p class="msg_error">El Valor pagado NO Puede ser mayor del Adeudado.</p>';
            }else{

                echo $pagado."/".$valor;

                date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());
            
        
            //SE MODIFICA EL EGRESO si es efectivo en la caja mayor
            if ($tipo==1){
                $inicio=mysqli_query($conexion, "SELECT MAX(idcaja) from cajamayor");
                $inicio1= mysqli_fetch_array($inicio);
                $controlcaja=$inicio1[0];

                $inicio2=mysqli_query($conexion, "SELECT egresos from cajamayor WHERE idcaja='$controlcaja'");
                $datoinicio=mysqli_fetch_array($inicio2);
                //se suma el abono al ingreso
                $egresos= $datoinicio["egresos"];
                $egresos=$egresos+$pagado;
                $query_cuadre=mysqli_query($conexion, "UPDATE cajamayor SET egresos=$egresos WHERE idcaja=' $controlcaja'"); 

                $queryentrada=mysqli_query($conexion, "INSERT INTO salida(idcaja, fecha, valorsalida, tiposalida,descripcion_s)
                                            VALUES ('$controlcaja','$fechaactual2','$pagado', 1 ,'Pago Facturas Crédito')") ;
            }else {

                $caja=mysqli_query($conexion, "SELECT MAX(idcaja) from cajamayor");
                $caja1= mysqli_fetch_array($caja);
                $controlcaja=$caja1[0];

                $caja2=mysqli_query($conexion, "SELECT bancosale from cajamayor WHERE idcaja='$controlcaja'");
                $datocaja=mysqli_fetch_array($caja2);
                //se suma el abono al banco
                $bancosale= $datocaja["bancosale"];
                $bancosale=$bancosale+$pagado;
                $query_caja=mysqli_query($conexion, "UPDATE cajamayor SET bancosale=$bancosale WHERE idcaja='$controlcaja'"); 

                date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());

                $queryentrada=mysqli_query($conexion, "INSERT INTO salida(idcaja, fecha, valorsalida, tiposalida,descripcion_s)
                                            VALUES ('$controlcaja','$fechaactual2','$pagado', 2 ,'Abono Factura .$nofactura')") ;
            }
                    
            
            
            
            //se realiza los pagos que se puedan

             
                    $querysinpagar=mysqli_query($conexion,"SELECT nofactura  FROM factura  WHERE estatus=1 
													and tipofactura=2 and codcliente='$idproveedor' " );
                    $resultado=mysqli_num_rows($querysinpagar);
                    
                    if($resultado>0){
                    
                    while($sinpagar=mysqli_fetch_array($querysinpagar) ){ 
                        $nofactura=$sinpagar['nofactura'];
                        
                        if($pagado>0){

                            $queryfactura=mysqli_query($conexion,"SELECT abono, totalfactura  FROM factura  WHERE nofactura='$nofactura' " );
                            
                            $datofactura=mysqli_fetch_array($queryfactura);
                            $totalfac= $datofactura["totalfactura"];
                            $abonado= $datofactura["abono"];
                            $saldof=$totalfac-$abonado;
                            //echo $abonado."ahh/";

                                if($pagado>=$saldof){
                                    $pagado=$pagado-$saldof;
                                    
                                    
                                    $queryabono=mysqli_query($conexion, "INSERT INTO abonoc (factura, valor, tipo_abc, usuario_abc)
                                                VALUES ('$nofactura','$saldof',$tipo,'$iduser')");
                                    //se realiza el abono en la factura de compra
                                    $abonado= $abonado+$saldof;

                                    $queryabonar=mysqli_query($conexion, "UPDATE factura
                                                SET abono='$abonado' WHERE nofactura='$nofactura' ");

                                        if( $totalfac==$abonado){
                                            $query_cobrado=mysqli_query($conexion, "UPDATE factura SET estatus=2  WHERE nofactura='$nofactura'");
                                        }
                                }else{
                                    $saldof=$pagado;
                                    $pagado=0;
                                    
                                    $queryabono=mysqli_query($conexion, "INSERT INTO abonoc (factura, valor, tipo_abc, usuario_abc)
                                                VALUES ('$nofactura','$saldof',$tipo,'$iduser')");
                                    //se realiza el abono en la factura de compra
                                    $abonado= $abonado+$saldof;

                                    $queryabonar=mysqli_query($conexion, "UPDATE factura
                                    SET abono='$abonado' WHERE nofactura='$nofactura' ");

                                        
                                }
                        }//fin si pagado mayor a cero


                        
                        
                    }
                
            }


            


            

            
           
            }//fin del else valor pagado menor o igual al adeudado
        }//fin del else 
    }//fin del post
    

   
    $idproveedor=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT SUM(totalfactura) as total, SUM(abono) as totalab  FROM factura f WHERE estatus=1 
													and tipofactura=2 and codcliente='$idproveedor' " );

    $queryproveedor=mysqli_query($conexion,"SELECT nombrec FROM cliente WHERE idcliente=$idproveedor" );
    $datap=mysqli_fetch_array($queryproveedor);
    $nomproveedor=$datap["nombrec"];

    
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_compra_credito1.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            $fechaventa = "llillo";
            $cliente = "llillo";
            $nombre = "llillo";
            $valor = $data['total'];
            $tabono = $data['totalab'];
            
            $valor2=$valor-$tabono;
            $valor=$valor-$tabono;
            $valor2=number_format($valor2, 0, ',', '.');
            
        }

        if($valor==0){
            $bandera=0;
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
	<title>Pagar Compras a Crédito </title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Total Adeudado a <BR> <?php echo $nomproveedor;?> </h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="cliente" value="<?php echo $idproveedor; ?>">
                <input type="hidden" name="valor" id="valor" value="<?php echo $valor; ?>">
                
                
                               
                
                <label for="nota">Valor Total</label>
                <input  name="valor2" id="valor2" placeholder="VALOR FACTURA" readonly="readonly" value="<?php echo $valor2; ?>">

                
                
               
                   
                <?php

                if($bandera==1){
                ?>
                <label for="nota">Forma de Pago</label>
                <select name="tipopago" id="tipopago" value="1">  
                        <option value=1>Efectivo</option>
                        <option value=2>Consignación</option>
                </select>
                <label for="valor">Valor a Pagar</label>
                <input type="number" name="valorpagado" id="valorpagado" 
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                 placeholder="VALOR COBRADO" value="<?php echo $valorpagado; ?>">
                 <input type="submit" value="Pagar Crédito" class="btn_save">
                <input type="button" onclick=" location.href='compras_proveedor_porpagar.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
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
