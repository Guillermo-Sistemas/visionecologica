<?php
session_start();

if($_SESSION['rol']<1)
    {
	header('location:../');
    }


$iduser=$_SESSION['idUser'];
$base=-1;
$controlinicial=0;
$alert="";
$saldo1=0;
$saldo=0;

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
                if(!empty($_POST['base']) && $_POST['base']>0)
                {
                     $base=$_POST['base'];
                     $notabase=$_POST['notabase'];
                     $ingresos=$ingresos+$base;

                     date_default_timezone_set('America/Bogota');
                     $fechaactual2 = Date('Y-m-d H:i:s', time());
                    
                        $querycuadre=mysqli_query($conexion, "UPDATE cuadre
                        SET ingresos=$ingresos WHERE idcuadre=$controlinicial");
                        

                        $querybase=mysqli_query($conexion, "INSERT INTO base(idcuadre, idusuario, fechabase, valorbase, notabase)
                        VALUES ('$controlinicial','$iduser','$fechaactual2','$base','$notabase')");
                        
                            if($querybase){
                                $alert='<p class="msg_error">Base Agregada Exitosamente </p>';
                                $inicio3=mysqli_query($conexion, "select ingresos, egresos from cuadre WHERE idcuadre='$controlinicial'");
                                $datoinicio3=mysqli_fetch_array($inicio3);

                                $saldo= $datoinicio3["ingresos"]-$datoinicio3["egresos"];

                                mysqli_close($conexion);

                                header('Location: bases.php');
                                
                            }
                } else{
                        if ($base!=-1){
                                $alert='<p class="msg_error">La Base a Agregar Debe Tener un Valor Mayor a Cero </p>'; 
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
	<title>Agregar Base</title>
    <link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1></i> Agregar Base al Cuadre Actual</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post" onsubmit="return confirmation()">

                <?php $saldo1=number_format($saldo, 0, ',', '.');?>

                <input type="hidden" name="saldoanterior" id="saldoanterior" readonly placeholder="Saldo Actual" value="<?php echo $saldo; ?>"" >
                <label for="nit">SALDO ACTUAL</label>
                <input type="text" name="mostrar" id="mostrar" readonly placeholder="Saldo Actual" value="<?php echo $saldo1; ?>"" >
                <label for="nit">AGREGAR BASE</label>
                <input type="number" name="base" id="base" placeholder="Valor a Adicionar ">
                <label for="nit">NOTA DE LA BASE</label>
                <input type="text" name="notabase" id="notabase" placeholder="Nota de la base">

                <label for="procedencia">Procedencia</label>
                        <select name="procedencia" id="procedencia" value="2">  
                                
                                <option value="2">Efectivo Caja Mayor</option>
                                
                         </select>
                

                
                
                <input type="submit" value="Agregar Base" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>

    <script type="text/javascript">
     function confirmation() 
     {
        if(confirm("Esta Seguro de Ingresar una Base?"))
	{
	   return true;
	}
	else
	{
	   return false;
	}
     }
    </script>

		

        		
        
        
</body>
</html>
