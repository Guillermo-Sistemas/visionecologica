<?php
session_start();

if($_SESSION['rol']!=1)
    {
	header('location:../');
    }


$iduser=$_SESSION['idUser'];
$base=0;
$anterior=0;
$bandera=0;
$valorsaldo=0;
$banco=0;

    include "../conexion.php";

    $inicio=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select fechaini, estatus from cajamayor WHERE idcaja='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $fechaini= $datoinicio["fechaini"];
   
    
    if($controlinicio==1)
    {
       
     echo "<script>
                alert('Existe una Caja Abierta el $fechaini ');
                window.location= '../index.php'
    </script>";

    mysqli_close($conexion);

    }else{
        
        if(!empty($_POST))
        {
        
           
            if(!empty($_POST['saldoanterior']))
            {
                $anterior=$_POST['saldoanterior'];
            } else{
                $anterior=0;
            }
            
        
          
        
           date_default_timezone_set('America/Bogota');
            $fechaactual2 = Date('Y-m-d H:i:s', time());
            
            
           
                
                $querycuadre=mysqli_query($conexion, "INSERT INTO cajamayor(fechaini, ingresos, egresos, saldo, estatus)
                VALUES ('$fechaactual2' ,'$anterior',0, 0,1)");
                
        
                   $querybase=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
                   $banderbase= mysqli_fetch_array($querybase);
                   $controlbase=$banderbase[0];
                   $queryentrada=mysqli_query($conexion, "INSERT INTO entrada(idcaja, fecha, valorentrada,descripcion)
                                            VALUES ('$controlbase','$fechaactual2','$anterior','saldo inicial')") ;
                    if($queryentrada){
                        $alert='<p class="msg_error">Caja Mayor Abierta </p>';
                        $bandera=1;
                        $valorsaldo=$anterior;
                    }
            }
    }








    $saldo=mysqli_query($conexion, "select MAX(idcaja) from cajamayor");
        $bandercuadre= mysqli_fetch_array($saldo);
        $controlcuadre=$bandercuadre[0];
        
        $saldo=mysqli_query($conexion, "select saldo from cajamayor WHERE idcaja='$controlcuadre' ");
        $datosaldo=mysqli_fetch_array($saldo);
        
        mysqli_close($conexion);
        
        if($bandera==0) {
             $valorsaldo= $datosaldo["saldo"];
        }else {
            $valorsaldo=$anterior;
        }

    

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Abrir Caja Mayor</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
</head>

<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1></i>Abrir Caja Mayor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            

            <form action="" method="post">
                <label for="nit">SALDO </label>
                <input type="number" name="saldoanterior" id="saldoanterior" placeholder="Saldo Anterior" value="<?php echo $valorsaldo; ?>"">
                <label for="nit">BANCO </label>
                <input type="number" name="banco" id="banco" placeholder="Saldo Banco" value="<?php echo $banco; ?>"">
                
                

                
            <?php   
                if($bandera==0) {
                   
                ?>
                    <input type="submit" value="Iniciar Caja Mayor" class="btn_save">
                    <input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
                    <?php
                }else {
                   
                   ?>
                      
                       <input type="button" onclick=" location.href='index.php' " value="Terminar" name="boton" class="btn_cancelado"  />
                       <?php
                       }
                       ?>
            </form>
        </div>
			
	</section>

		<?php
            
			include "include/footer.php";
		?>
</body>
</html>
