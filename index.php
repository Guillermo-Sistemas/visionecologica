<?php

$alert="";
session_start();

if (!empty($_SESSION['active']))
{
    header('location:sistema/');
}else{

    if(!empty($_POST))
    {
        $alert="Ingrese su Usuario y su Clave";
        if(empty($_POST['usuario']) || empty($_POST['clave'] ))
        {
            $alert="Ingrese su Usuario y su Clave";
        }else{
            require_once "conexion.php";

            $user= mysqli_real_escape_string($conexion,$_POST['usuario']);
            $pass= md5(mysqli_real_escape_string($conexion,$_POST['clave']));

            

            $query=mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario= '$user' AND clave='$pass'");

	    mysqli_close($conexion);
            
            $result=mysqli_num_rows($query);


            if($result > 0)
            {
                $data=mysqli_fetch_array($query);
                
                $_SESSION['active']=true;
                $_SESSION['idUser']=$data['idusuario'];
                $_SESSION['nombre']=$data['nombre'];
                $_SESSION['correo']=$data['correo'];
                $_SESSION['user']=$data['usuario'];
                $_SESSION['rol']=$data['rol'];

                header('location:sistema/');
                
            }else{
                $alert='EL Usuario o la Contraseña son Incorrectas';
                session_destroy();
                
            }
        }    
    }
}
        
    
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO SESIÓN | TIS@</title>
    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
</head>
    <body>
    <section id="container">
        <form action="" method="post">
            
            <h3>Visión Ecológica S.A.S </h3>
            <h3>Sistema de Información </h3>
            <img src="img/logo.png" alt="login">

            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <div class="alert"><?php echo isset($alert)? $alert : '';  ?></div>
            <input type="submit" value="INGRESAR">
            

        </form>

    </section>
</body>
</html>