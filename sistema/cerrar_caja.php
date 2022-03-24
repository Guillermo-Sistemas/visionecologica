<?php
    session_start();
    $iduser=$_SESSION['idUser'];
    include "../conexion.php";

    $bandera=0;


    $inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select ingresos, egresos, estatus from cajamayor WHERE idcaja='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $ingresos= $datoinicio["ingresos"];
    $egresos= $datoinicio["egresos"];
    $saldo=$ingresos-$egresos;
    


    if($controlinicio==0)
    {
        
     echo "<script>
                alert('No Existe una Caja Abierta ');
                window.location= 'abrir_mayor.php'
    </script>";
    }else{



                if(!empty($_POST))
                {
                    $saldo=$_POST['saldo'];
                    $final=0;

                    
                
                    if($_POST['saldo']<0 || $saldo==null )
                    {
                        $alert='<p class="msg_error">Debe de Reportar Saldo Final.</p>';
                    }else{



                        $cuadre=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
                        $bandercuadre= mysqli_fetch_array($cuadre);
                        $controlcuadre=$bandercuadre[0];

                        /*$query7=mysqli_query($conexion, "SELECT ingresos, egresos FROM cuadre WHERE idcuadre=$controlcuadre");
                        $result7=mysqli_num_rows($query7);
                        $valor7=mysqli_fetch_array($query7);
                    
                        $ingresos=$valor7['ingresos'];
                        $egresos=$valor7['egresos'];
                        
                        $final=$ingresos-$egresos-$saldo;*/

                        date_default_timezone_set('America/Bogota');
                        $fechaactual2 = Date('Y-m-d H:i:s', time());

                        //echo $fechaactual2;
                    
                        $consulta3=mysqli_query($conexion,"UPDATE cajamayor SET estatus=0,
                                    fechafin='$fechaactual2'
                                    WHERE idcaja=$controlcuadre");

                        $bandera=1;

                        mysqli_close($conexion);

                        /*$final=$ingresos-$egresos-$saldo;
                        $mensaje="Cuadre Cerrado con Sobrante ".($final*-1);

                         if($final==0){
                            $mensaje="Cuadre Cerrado OK"; 
                         }elseif($final>0){
                            $mensaje="Cuadre Cerrado con Faltante ".($final*-1); 
                        }*/

                            
                            
                            $alert='<p class="msg_error">Caja Cerrada </p>';
                            //$alert="$alert" . "   $mensaje";
                        }
                    
                        
                    
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
	<title>Cerrar Cuadre</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1></i> Cerrar Caja Mayor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post" onsubmit="return confirmation()">
                
                <input type="hidden" name="saldo" value=1
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                id="saldo" placeholder="Ingresar Saldo Final">
                

                
                <?php
                if ($bandera==0){
                ?>
                    <input type="submit" value="Cerrar Caja" class="btn_save">
                    <input type="button" onclick=" location.href='index.php'" target="_blank" value="Cancelar" name="boton" class="btn_cancelado"  />
                <?php
                }
                else{
                ?>
                    <input type="button" onclick=" location.href='index.php'" target="_blank" value="Terminar" name="boton" class="btn_cancelado"  />
                    <center><a href='imprimir_caja.php' target="_blank" class="btn_imp">       Imprimir Caja Mayor        </a></center>
                <?php
                }?>

               
                
            </form>
        </div>
			
	</section>

    <script type="text/javascript">
     function confirmation() 
     {
        if(confirm("Esta Seguro de Cerrar la Caja?"))
	{
	   return true;
	}
	else
	{
	   return false;
	}
     }
    </script>



		<?php
			include "include/footer.php";
		?>
		
        
        
</body>
</html>

