<?php
    session_start();
    $iduser=$_SESSION['idUser'];
    include "../conexion.php";

    $bandera=1;

    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['valor']) )
        {
            
            $alert='<p class="msg_error">El Valor Cobrado debe tener un Valor Mayor a Cero.</p>';
        }else{
            $nofactura=$_POST['nofactura'];
            $valor=$_POST['valor'];
            $abono=$_POST['abonos'];
            $deuda=$_POST['deuda'];
            $pagado=$_POST['valorpagado'];
            $tipo=$_POST['tipopago'];

            if ($pagado>$deuda){
                $alert='<p class="msg_error">El Valor pagado NO Puede ser mayor del Adeudado.</p>';
            }else{
            
        
            //SE MODIFICA EL EGRESO si es efectivo
            if ($tipo==1){
                $inicio=mysqli_query($conexion, "SELECT MAX(idcuadre) from cuadre");
                $inicio1= mysqli_fetch_array($inicio);
                $controlinicial=$inicio1[0];

                $inicio2=mysqli_query($conexion, "SELECT egresos,  pago from cuadre WHERE idcuadre='$controlinicial'");
                $datoinicio=mysqli_fetch_array($inicio2);
                //se suma el abono al ingreso
                $egresos= $datoinicio["egresos"];
                $pago= $datoinicio["pago"];
                $egresos=$egresos+$pagado;
                $pago=$pago+$pagado;
                $query_cuadre=mysqli_query($conexion, "UPDATE cuadre SET egresos=$egresos, pago=$pago WHERE idcuadre='$controlinicial'"); 
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
                    
            

            
            //se realiza el abono en la tabala Abonos
            $queryabono=mysqli_query($conexion, "INSERT INTO abonoc (factura, valor, tipo_abc, usuario_abc)
                                        VALUES ('$nofactura','$pagado',$tipo,'$iduser')");
            //se realiza el abono en la factura de compra
            $inicio5=mysqli_query($conexion, "select abono FROM factura WHERE nofactura='$nofactura'  ");
            $datoinicio5=mysqli_fetch_array($inicio5);
            $abonar= $datoinicio5["abono"];

            //echo $valor."/";


            $abonar= $abonar+$pagado;

           // echo $abono."/";
            //echo $cobrado."/";

            $queryabonar=mysqli_query($conexion, "UPDATE factura
                            SET abono='$abonar' WHERE nofactura='$nofactura' ");

            
            if( $valor!=$abonar){
                $alert='<p class="msg_error">Abono Realizado Correctamente </p>';
            }else{
                $query_cobrado=mysqli_query($conexion, "UPDATE factura SET estatus=2  WHERE nofactura='$nofactura'");
                $alert='<p class="msg_error">Compra Pagada en su Totalidad </p>';
                $bandera=2;
            }
        }
        }//fin del else valor
    }//fin del post
    

    if(empty($_GET['id']))
    {
    
    }
    $nofactura=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT f.fecha, f.codcliente, c.nombrec, f.abono, f.totalfactura FROM
                    factura f INNER JOIN cliente c ON c.idcliente=f.codcliente WHERE nofactura=$nofactura");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_compra_credito1.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            $fechaventa = $data['fecha' ];
            $cliente = $data['codcliente' ];
            $nombre = $data['nombrec' ];
            $valor = $data['totalfactura' ];
            $abono = $data['abono' ];
            
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
	<title>Pagar Compra</title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Pagar Compra a Crédito</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="nofactura" value="<?php echo $nofactura; ?>">
                <input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
                
                               
                <label for="fecha">Fecha de Venta</label>
                <input type="text" name="fecha" id="fecha" placeholder="FECHA DE VENTA" readonly="readonly" value="<?php echo $fechaventa; ?>">

                <label for="cliente">Cliente</label>
                <input type="text" name="nombre" id="cliente" placeholder="CLIENTE" readonly="readonly" value="<?php echo $nombre; ?>">

                <label for="nota">Valor Factura de Venta</label>
                <input type="number" name="valor" id="valor" placeholder="VALOR FACTURA" readonly="readonly" value="<?php echo $valor; ?>">

                <label for="nota">Abonos</label>
                <input type="number" name="abonos" id="abonos" placeholder="VALOR ABONO" readonly="readonly" value="<?php echo $abono; ?>">

                <label for="nota">Valor Adeudado</label>
                <input type="number" name="deuda" id="deuda" placeholder="VALOR ADEUDADO" readonly="readonly" value="<?php echo $valor-$abono; ?>">

                
               
                   
                <?php

                if($bandera==1){
                ?>
                <label for="nota">Forma de Pago</label>
                <select name="tipopago" id="tipopago" value="1">  
                        <option value=1>Efectivo</option>
                        <option value=2>Consignación</option>
                </select>
                <label for="valor">Valor a Pagar</label>
                <input type="number" name="valorpagado" id="valorpagaado" 
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                 placeholder="VALOR COBRADO" value="<?php echo $valorpagado; ?>">
                 <input type="submit" value="Pagar Compra" class="btn_save">
                <input type="button" onclick=" location.href='listar_compra_credito1.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
                 <?php

                }
                else{ ?>
                    <input type="button" onclick=" location.href='listar_compra_creditopag1.php' " value="Terminar" name="boton" class="btn_cancelado"  />
                <?php    
                }
                ?>
                
                
                
                
               
                
                 
            </form>
        </div>
			
	</section>

</body>
</html>
