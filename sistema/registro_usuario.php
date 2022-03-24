<?php
    session_start();

    if($_SESSION['rol']!=1)
    {
	header('location:../');
    }

    

    include "../conexion.php";
    if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
        {
            $alert='<p class="msg_error">Debe de Llenarse toda la Información.</p>';
        }else{
                $nombre=$_POST['nombre'];
                $email=$_POST['correo'];
                $user=$_POST['usuario'];
                $clave=md5($_POST['clave']);
                $rol=$_POST['rol']; 

                $query=mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario='$user' OR correo='$email'");
                
                $result =mysqli_fetch_array($query);

                if($result > 0){
                    $alert='<p class="msg_error">El Correo o el Usuario ya Existen. </p>';
                }else{
                    $query_insert=mysqli_query($conexion, "INSERT INTO usuario(nombre, correo, usuario,clave,rol)
                                    VALUES ('$nombre','$email', '$user', '$clave', '$rol')");

                    if( $query_insert){
                        $alert='<p class="msg_error">Usuario Creado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Crear el Usuario. </p>';
                    }
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
	<title>Registro Usuarios</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1><i class="fas fa-user-alt"></i> Registro Usuarios</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo Electrónico">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" placeholder="Clave de Acceso">

                <?php
                    $query_rol=mysqli_query($conexion, "SELECT * FROM rol");
	            mysqli_close($conexion);
                    $result_rol=mysqli_num_rows($query_rol);
		?>

                <label for="rol">Tipo de Usuario</label>
                <select name="rol" id="rol">  
                    <?php
                        if($result_rol > 0){
                            while($rol=mysqli_fetch_array($query_rol)){ 
                    ?>
                    <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"]; ?></option>
                <?php
                    }
                }
		?>
		</select>
                
                <input type="submit" value="Crear Usuario" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>

		
        
        
</body>
</html>






