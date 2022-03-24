<?php
    session_start();
    $iduser=$_SESSION['idUser'];
    include "../conexion.php";


    $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select ingresos, egresos, estatus from cuadre WHERE idcuadre='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $ingresos= $datoinicio["ingresos"];
    $egresos= $datoinicio["egresos"];
    $saldo=$ingresos-$egresos;
    


    if($controlinicio==0)
    {
        
     echo "<script>
                alert('No Existe un Cuadre Abierto ');
                window.location= 'abrir_cuadre.php'
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



                        $cuadre=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
                        $bandercuadre= mysqli_fetch_array($cuadre);
                        $controlcuadre=$bandercuadre[0];

                        $query7=mysqli_query($conexion, "SELECT ingresos, egresos FROM cuadre WHERE idcuadre=$controlcuadre");
                        $result7=mysqli_num_rows($query7);
                        $valor7=mysqli_fetch_array($query7);
                    
                        $ingresos=$valor7['ingresos'];
                        $egresos=$valor7['egresos'];
                        
                        $final=$ingresos-$egresos-$saldo;

                        date_default_timezone_set('America/Bogota');
                        $fechaactual2 = Date('Y-m-d H:i:s', time());

                        //echo $fechaactual2;
                    
                        $consulta3=mysqli_query($conexion,"UPDATE cuadre SET saldo=$saldo, estatus=0,
                                    idusuario_cierra=$iduser, fechaFinal='$fechaactual2'
                                    WHERE idcuadre=$controlcuadre");

                        mysqli_close($conexion);

                        $final=$ingresos-$egresos-$saldo;
                        $mensaje="Cuadre Cerrado con Sobrante ".($final*-1);

                         if($final==0){
                            $mensaje="Cuadre Cerrado OK"; 
                         }elseif($final>0){
                            $mensaje="Cuadre Cerrado con Faltante ".($final*-1); 
                        }

                            
                            
                            $alert='<p class="msg_error">Cuadre Cerrado </p>';
                            $alert="$alert" . "   $mensaje";
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
            <h1></i> Cerrar Cuadre de Caja</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post" onsubmit="return confirmation()">
                <label for="nit">INGRESAR SALDO FINAL</label>
                <input type="number" name="saldo" 
                pattern=" 0+\.[0-9]*[1-9][0-9]*$" 
                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                id="saldo" placeholder="Ingresar Saldo Final">
                

                
                
                <input type="submit" value="Cerrar Cuadre" class="btn_save">
                <input type="button" onclick=" location.href='index.php'" target="_blank" value="Cancelar" name="boton" class="btn_cancelado"  />
                <center><a href='imprimir_cuadre.php' target="_blank" class="btn_imp">       Imprimir Cuadre        </a></center>
                
            </form>
        </div>
			
	</section>

    <script type="text/javascript">
     function confirmation() 
     {
        if(confirm("Esta Seguro de Cerrar el Cuadre de Caja?"))
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

