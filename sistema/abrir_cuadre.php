<?php
session_start();

if($_SESSION['rol']<1)
    {
	header('location:../');
    }


$iduser=$_SESSION['idUser'];
$base=0;
$anterior=0;
$bandera=0;


    include "../conexion.php";

    $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select idusuario_abre, estatus from cuadre WHERE idcuadre='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);

    $controlinicio= $datoinicio["estatus"];
    $idusuario= $datoinicio["idusuario_abre"];

    
    if($controlinicio==1)
    {
        $inicio3=mysqli_query($conexion, "select nombre from usuario WHERE idusuario='$idusuario'");
        $datoinicio3=mysqli_fetch_array($inicio3);
    
        $nombre= $datoinicio3["nombre"];  
     echo "<script>
                alert('Existe un Cuadre Abierto por $nombre ');
                window.location= '../index.php'
    </script>";

    mysqli_close($conexion);

    }else{


        if(!empty($_POST))
        {

            if(!empty($_POST['base']))
            {
                $base=$_POST['base'];
            }
            if(!empty($_POST['saldoanterior']))
            {
                $anterior=$_POST['saldoanterior'];
            }
            

            $ingresos=$base+$anterior;

            date_default_timezone_set('America/Bogota');
            $fechaactual2 = Date('Y-m-d H:i:s', time());
            
            
            if($ingresos>0)
            {
                
                $querycuadre=mysqli_query($conexion, "INSERT INTO cuadre(idusuario_abre, fechaInicial, ingresos, egresos, saldo, estatus)
                VALUES ('$iduser', '$fechaactual2' ,'$ingresos',0, 0,1)");
                

                   $querybase=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
                   $banderbase= mysqli_fetch_array($querybase);
                   $controlbase=$banderbase[0];
                   $querybase=mysqli_query($conexion, "INSERT INTO base(idcuadre, idusuario, fechabase,valorbase, notabase)
                                            VALUES ('$controlbase','$iduser','$fechaactual2','$base','Base Inicial')") ;
                    if($querybase){
                        $alert='<p class="msg_error">Cuadre Abierto </p>';
                        $bandera=1;
                        
                    }
                
                
            }else{
                $alert='<p class="msg_error">Para Abrir el cuadre se necesita Saldo Anterior o Base Mayor a Cero </p>';    
        }
        
    }

        $saldo=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
        $bandercuadre= mysqli_fetch_array($saldo);
        $controlcuadre=$bandercuadre[0];

        $saldo=mysqli_query($conexion, "select saldo from cuadre WHERE idcuadre='$controlcuadre' ");
        $datosaldo=mysqli_fetch_array($saldo);

        mysqli_close($conexion);
        
        $valorsaldo= $datosaldo["saldo"];
       
    }

    

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Abrir Cuadre de Caja</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
</head>

<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1></i> Abrir Cuadre de Caja</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            

            <form action="" method="post">
                <label for="nit">SALDO ANTERIOR</label>
                <input type="number" name="saldoanterior" id="saldoanterior" readonly placeholder="Saldo Anterior" value="<?php echo $valorsaldo; ?>"">
                <label for="nit">BASE INICIAL</label>
                <input type="number" name="base" id="base" placeholder="Base Inicial">

                <label for="procedencia">Procedencia</label>
                        <select name="procedencia" id="procedencia" value="2">  
                                
                                <option value="2">Efectivo Caja Mayor</option>
                                
                         </select>
                

                
        <?php
        if($bandera==0){
        ?>        
        <input type="submit" value="Abrir Cuadre de Caja" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
        <?php 
        }else{
        ?>
            <input type="button" onclick=" location.href='index.php' " value="Terminar" name="boton" class="btn_cancelado"  />   
        <?php } ?>    
        </form>
        </div>
			
	</section>

		
</body>
</html>
