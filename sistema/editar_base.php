<?php
session_start();

if($_SESSION['rol']<1)
    {
	header('location:../');
    }



$iduser=$_SESSION['idUser'];
$base=0;
$controlinicial=0;
$alert="";

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
    }






    if(!empty($_POST['basenueva']) && $_POST['basenueva']>0)
                {
                     $baseactual=$_POST['baseactual'];
                     $basenueva=$_POST['basenueva'];
                     $notabase=$_POST['notabase'];

                    //echo $basenueva;


                    $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
                    $inicio1= mysqli_fetch_array($inicio);
                    $controlinicial=$inicio1[0];

                    $inicio2=mysqli_query($conexion, "select ingresos from cuadre WHERE idcuadre='$controlinicial'");
                    $datoinicio=mysqli_fetch_array($inicio2);

                    $ingresos= $datoinicio["ingresos"]+$basenueva-$baseactual;
                   
                    
                        $querycuadre=mysqli_query($conexion, "UPDATE cuadre
                        SET ingresos=$ingresos WHERE idcuadre=$controlinicial");
                        

                        $inicio=mysqli_query($conexion, "select MAX(idbase) from base");
                        $inicio1= mysqli_fetch_array($inicio);
                        $controlinicial=$inicio1[0];   
                        
                        echo $controlinicial."/".$basenueva."/".$notabase;

                        $querybase=mysqli_query($conexion, "UPDATE base SET valorbase=$basenueva, notabase='$notabase' WHERE idbase='$controlinicial'");
                        
                            if($querybase){
                                $alert='<p class="msg_error">Base Modificada Exitosamente  </p>';
                                
                            }
                } else{
                    if (!empty($_POST['basenueva'])){
                        $alert='<p class="msg_error">La Base debe Tener un Valor Mayor a Cero </p>';  
		            }  
                }






    
    $inicio=mysqli_query($conexion, "select MAX(idcuadre) from cuadre");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select ingresos from cuadre WHERE idcuadre='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);
    $controlinicio=$datoinicio["ingresos"];

    if($controlinicio==0)
    {
        
     echo "<script>
                alert('No Existe un Cuadre Abierto ');
                window.location= 'abrir_cuadre.php'
    </script>";
    }else{



    $inicio=mysqli_query($conexion, "select MAX(idbase) from base");
    $inicio1= mysqli_fetch_array($inicio);
    $controlinicial=$inicio1[0];

    $inicio2=mysqli_query($conexion, "select valorbase, notabase from base WHERE idbase='$controlinicial'");
    $datoinicio=mysqli_fetch_array($inicio2);
    $baseactual= $datoinicio["valorbase"];
    $nota= $datoinicio["notabase"];
    
    


    
                
    }

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Modificar Base</title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1></i> Modificar Base</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <?php $baseactual1=number_format($baseactual, 0, ',', '.');?>
                <input type="hidden" name="baseactual" id="baseactual" readonly placeholder="Base Actual" value="<?php echo $baseactual; ?>"" >
                <label for="nit">ULTIMA BASE INGRESADA</label>
                <input type="text" name="mostrar" id="mostrar" readonly placeholder="Base Actual" value="<?php echo $baseactual1; ?>" >
                <label for="nit">NUEVO VALOR PARA LA ULTIMA BASE</label>
                <input type="number" name="basenueva" id="basenueva" placeholder="Nuevo Valor ">
                <label for="nit">NOTA DE LA BASE</label>
                <input type="text" name="notabase" id="notabase" placeholder="Nota de la base" value="<?php echo $nota; ?>">
                

                
                
                <input type="submit" value="Modificar Base" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>

		
        
        
</body>
</html>
