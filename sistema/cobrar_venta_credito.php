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
            $nofacturav=$_POST['nofacturav'];
            $valor=$_POST['valor'];
            $abono=$_POST['abonos'];
            $deuda=$_POST['deuda'];
            $cobrado=$_POST['valorcobrado'];
            $tipo=$_POST['tipopago'];

            if ($cobrado>$deuda){
                $alert='<p class="msg_error">El Valor Cobrado NO Puede ser mayor del Adeudado.</p>';
            }else{
            
        
            //SE MODIFICA EL INGRESO si es efectivo
            if ($tipo==1){
                $caja=mysqli_query($conexion, "SELECT MAX(idcaja) from cajamayor ");
                $caja1= mysqli_fetch_array($caja);
                $controlcaja=$caja1[0];

                $caja2=mysqli_query($conexion, "SELECT ingresos from cajamayor WHERE idcaja='$controlcaja' ");
                $datocaja=mysqli_fetch_array($caja2);
                //se suma el abono al banco
                $ingresos= $datocaja["ingresos"];
                $ingresos=$ingresos+$cobrado;
                $query_caja=mysqli_query($conexion, "UPDATE cajamayor SET ingresos=$ingresos WHERE idcaja='$controlcaja'"); 

                date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());

                $queryentrada=mysqli_query($conexion, "INSERT INTO entrada(idcaja, fecha, valorentrada,descripcion)
                                            VALUES ('$controlcaja','$fechaactual2','$cobrado','Abono Factura .$nofacturav')") ;
            }else {

                $caja=mysqli_query($conexion, "SELECT MAX(idcaja) from cajamayor");
                $caja1= mysqli_fetch_array($caja);
                $controlcaja=$caja1[0];

                $caja2=mysqli_query($conexion, "SELECT banco from cajamayor WHERE idcaja='$controlcaja'");
                $datocaja=mysqli_fetch_array($caja2);
                //se suma el abono al banco
                $banco= $datocaja["banco"];
                $banco=$banco+$cobrado;
                $query_caja=mysqli_query($conexion, "UPDATE cajamayor SET banco=$banco WHERE idcaja='$controlcaja'"); 

                date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());

                $queryentrada=mysqli_query($conexion, "INSERT INTO entrada(idcaja, fecha, valorentrada, tipoentrada ,descripcion)
                                            VALUES ('$controlcaja','$fechaactual2','$cobrado',2,'Abono Factura .$nofacturav')") ;
            }
                    
            

            
            //se realiza el abono en la tabala Abonos
            $queryabono=mysqli_query($conexion, "INSERT INTO abonov (facturav, valor, tipo_abv, usuario_abv)
                                        VALUES ('$nofacturav','$cobrado',$tipo,'$iduser')");
            //se realiza el abono en la factura de Venta
            $inicio5=mysqli_query($conexion, "select abono FROM facturav WHERE nofacturav='$nofacturav'  ");
            $datoinicio5=mysqli_fetch_array($inicio5);
            $abonar= $datoinicio5["abono"];

            //echo $valor."/";


            $abonar= $abonar+$cobrado;

           // echo $abono."/";
            //echo $cobrado."/";

            $queryabonar=mysqli_query($conexion, "UPDATE facturav
                            SET abono='$abonar' WHERE nofacturav='$nofacturav' ");

            
            if( $valor!=$abonar){
                $alert='<p class="msg_error">Abono Realizado Correctamente </p>';
            }else{
                $query_cobrado=mysqli_query($conexion, "UPDATE facturav SET estatus=2  WHERE nofacturav='$nofacturav'");
                $alert='<p class="msg_error">Factura Pagada en su Totalidad </p>';
                $bandera=2;
            }
        }
        }//fin del else valor
    }//fin del post
    

    if(empty($_GET['id']))
    {
    
    }
    $nofacturav=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT f.fecha, f.codcliente, c.nombrec, f.abono, f.totalfactura FROM
                    facturav f INNER JOIN cliente c ON c.idcliente=f.codcliente WHERE nofacturav=$nofacturav");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_venta_credito.php');
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
	<title>Cobrar Venta</title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Cobrar Venta a Crédito Administrador</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="nofacturav" value="<?php echo $nofacturav; ?>">
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
                <label for="valor">Valor a Cobrar</label>
                <input type="number" name="valorcobrado" id="valorcobrado" 
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                 placeholder="VALOR COBRADO" value="<?php echo $valorcobrado; ?>">
                 <input type="submit" value="Cobrar Venta" class="btn_save">
                <input type="button" onclick=" location.href='listar_venta_credito.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
                 <?php

                }
                else{ ?>
                    <input type="button" onclick=" location.href='listar_venta_credito.php' " value="Terminar" name="boton" class="btn_cancelado"  />
                <?php    
                }
                ?>
                
                
                
                
               
                
                 
            </form>
        </div>
			
	</section>

</body>
</html>
