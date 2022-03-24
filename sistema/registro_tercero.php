<?php
    session_start();
    include "../conexion.php";
    if(!empty($_POST))
    {
        $telefono=0;
        $direccion='';  
        $alert='';
        if(empty($_POST['nombre']))
        {
            $alert='<p class="msg_error">El Tercero debe de tener un Nombre.</p>';
        }else{
            
                $nit        =$_POST['nit']; 
                $nombre     =$_POST['nombre'];
                $apodo     =$_POST['apodo'];
                $telefono   =$_POST['telefono'];
                $direccion  =$_POST['direccion'];
                $tipo  =$_POST['tipotercero'];
                //$usuario_id =$_SESSION['idusuario']);

                if($nit=='' ){
                    $nit=0;
                }
                if($apodo=='' ){
                    $telefono="";
                }
                if($telefono=='' ){
                    $telefono=0;
                }
                if($direccion=='' ){
                    $direccion='No tiene';
                }

                $result=0;

                if(is_numeric($nit) and $nit!=0){
                    $query=mysqli_query($conexion,"SELECT * FROM cliente WHERE nit='$nit'");
                    $result =mysqli_fetch_array($query);
                }

                //echo "$nit";
                //echo "$nombre";
                //echo "$telefono";
                //echo "$direccion";

                 if($result>0){
                    
                    $alert='<p class="msg_error">El Número de NIT ya Existe. </p>';
                 }else {
                    $query_insert=mysqli_query($conexion, "INSERT INTO cliente(nit, nombrec, apodo, telefono, direccion, tipo_cliente)
                                    VALUES ('$nit','$nombre','$apodo','$telefono', '$direccion', '$tipo')");
                    if( $query_insert){
                        $alert='<p class="msg_error">Tercero Creado Correctamente. </p>';
                    }else{
                        
                        $alert='<p class="msg_error">Error al Crear el Tercero. </p>';
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
	<title>Registro Terceros</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1><i class="fas fa-user-alt"></i> Registro Tercero</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <label for="nit">Cédula o NIT</label>
                <input type="text" name="nit" id="nit" placeholder="Número de Cédula o NIT">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo">
                <label for="nombre">Apodo</label>
                <input type="text" name="apodo" id="apodo" placeholder="Apodo">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección">

                <label for="rol">Tipo de Cliente</label>
                <select name="tipotercero" id="tipotercero" value="1">  
                        <option value="Recuperador">Recuperador</option>
                        <option value="Proveedor">Proveedor</option>
                        <option value="Comprador">Comprador</option>
                        <option value="Tercero">Tercero</option>
                        <option value="Reciclador-Comprador">Reciclador-Comprador</option>
                        <option value="Empleado">Empleado</option>
                </select>

                
                
                <input type="submit" value="Guardar Tercero" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>

		
		
        
        
</body>
</html>
