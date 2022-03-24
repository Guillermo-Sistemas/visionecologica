<?php
    session_start();
    include "../conexion.php";

    if($_SESSION['rol']!=1)
    {
	header('location:../');
    }

    if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol']))
        {
            $alert='<p class="msg_error">Debe de Llenarse toda la Información.</p>';
        }else{
                $idusuario=$_POST['idusuario'];
                $nombre=$_POST['nombre'];
                $email=$_POST['correo'];
                $user=$_POST['usuario'];
                $clave=md5($_POST['clave']);
                $rol=$_POST['rol']; 

                $query=mysqli_query($conexion,"SELECT * FROM usuario 
                                                        WHERE (usuario='$user' AND idusuario!=$idusuario)
                                                        OR (correo='$email' AND idusuario!=$idusuario)");
                $result =mysqli_fetch_array($query);

                if($result > 0){
                    $alert='<p class="msg_error">El Correo o el Usuario ya Existen. </p>';
                }else{
                    if(empty($_POST['clave']))
                    {
                            $sql_update = mysqli_query($conexion, "UPDATE usuario
                                                            SET nombre='$nombre', correo='$email', usuario='$user', rol='$rol'
                                                                WHERE idusuario=$idusuario");
                     }else{ 
                        $sql_update = mysqli_query($conexion, "UPDATE usuario
                                                            SET nombre='$nombre', correo='$email', usuario='$user', clave='$clave', rol='$rol'
                                                            WHERE idusuario=$idusuario");
                     }
                    
                    
                    
                    if( $sql_update){
                        $alert='<p class="msg_error">Usuario Actualizado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Actualizar el Usuario. </p>';
                    }
                }
        }
    }

    if(empty($_GET['id']))
    {
    
    }
    $iduser=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol FROM
                    usuario u INNER JOIN rol r ON u.rol=r.idrol WHERE idusuario=$iduser");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_usuario.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            $iduser = $data['idusuario' ];
            $nombre = $data['nombre' ];
            $correo = $data['correo' ];
            $usuario = $data['usuario' ];
            $idrol = $data['idrol' ];
            $rol = $data['rol' ];

            if($idrol==1){
                $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
             }else if($idrol==2){
                $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
             }else if($idrol==3){
                $option='<option value="'.$idrol.'" select>'.$rol.'</option>';
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
	<title>Actualizar Usuarios</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";

        
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Actualizar Usuarios</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="idusuario" value="<?php echo $iduser; ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo Electrónico" value="<?php echo $correo; ?>">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" placeholder="Clave de Acceso">

                <?php
                    $query_rol=mysqli_query($conexion, "SELECT * FROM rol");
                    $result_rol=mysqli_num_rows($query_rol);

                ?>


                <label for="rol">Tipo de Usuario</label>
                <select name="rol" id="rol" class="notItemOne">  
                    <?php
                        echo $option;
                        if($result_rol > 0){
                            while($rol=mysqli_fetch_array($query_rol)){ 
                        
                    ?>
                    <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"]; ?></option>
                <?php
                    }
                }

                ?>

                </select>
                
                <input type="submit" value="Actualizar Usuario" class="btn_save">
		<input type="button" onclick=" location.href='listar_usuario.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>

		
        
        
</body>
</html>
