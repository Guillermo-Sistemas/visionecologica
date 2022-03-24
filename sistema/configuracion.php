<?php
	session_start();
    include "../conexion.php";


    if($_SESSION['rol']!=1)
    {
	header('location:../');
    }

    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['nombre']) || empty($_POST['nit']) )
        {
            
            $alert='<p class="msg_error">La Empresa debe de tener Nombre y NIT.</p>';
        }else{
            $id = $_POST['id' ];
            $nit = $_POST['nit' ];
            $nombre = $_POST['nombre' ];
            $razon = $_POST['razon' ];
            $telefono = $_POST['telefono' ];
            $email = $_POST['email' ];
            $direccion =$_POST['direccion' ];
            $ciudad = $_POST['ciudad' ];

            //echo $id."/".$nit."/".$nombre."/".$razon."/".$telefono."/".$email."/".$direccion."/".$ciudad;

                   $sql_update = mysqli_query($conexion, "UPDATE configuracion
                                                            SET nit='$nit', nombre='$nombre',
                                                            razon_social='$razon', telefono='$telefono', 
                                                            email='$email', direccion='$direccion',
                                                            ciudad='$ciudad' WHERE id=$id");
                    if( $sql_update){
                        $alert='<p class="msg_error">Datos de la Empresa Actualizados Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Actualizar los Datos. </p>';
                    }
        }
    }
    

   

    $sql=mysqli_query($conexion,"SELECT * FROM configuracion ");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: index.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            
            $id = $data['id' ];
            $nit = $data['nit' ];
            $nombre = $data['nombre' ];
            $razon = $data['razon_social' ];
            $telefono = $data['telefono' ];
            $email = $data['email' ];
            $direccion = $data['direccion' ];
            $ciudad = $data['ciudad' ];
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
	<title>Actualizar Datos de la Empresa</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Actualizar Datos de la Empresa</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="nit">NIT</label>
                <input type="text" name="nit" id="nit" placeholder="NIT" value="<?php echo $nit; ?>">
                <label for="nombre">NOMBRE</label>
                <input type="text" name="nombre" id="nombre" placeholder="NOMBRE" value="<?php echo $nombre; ?>">
                <label for="razon">RAZON SOCIAL</label>
                <input type="text" name="razon" id="razon" placeholder="RAZÓN SOCIAL" value="<?php echo $razon; ?>">
                <label for="telefono">TELEFONO</label>
                <input type="text" name="telefono" id="telefono" placeholder="TELÉFONO" value="<?php echo $telefono; ?>">
                <label for="email">CORREO ELECTRÓNICO</label>
                <input type="text" name="email" id="email" placeholder="CORREO ELECTRÓNICO" value="<?php echo $email; ?>">
                <label for="direccion">DIRECCIÓN</label>
                <input type="text" name="direccion" id="direccion" placeholder="DIRECCIÓN" value="<?php echo $direccion; ?>">
                <label for="ciudad">CIUDAD</label>
                <input type="text" name="ciudad" id="ciudad" placeholder="CIUDAD" value="<?php echo $ciudad; ?>">
                
                
                
                
		        
                <input type="submit" value="Actualizar Datos" class="btn_save">
		        <input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
                
		
            </form>
        </div>
			
	</section>

</body>
</html>
