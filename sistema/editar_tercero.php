<?php
    session_start();
    include "../conexion.php";
    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['nombre']) )
        {
            
            $alert='<p class="msg_error">El Cliente debe de tener un Nombre.</p>';
        }else{
            $idcliente  =$_POST['idcliente']; 
            $nit        =$_POST['nit']; 
            $nombre     =$_POST['nombre'];
            $apodo     =$_POST['apodo'];
            $telefono   =$_POST['telefono'];
            $direccion  =$_POST['direccion'];
            $tipo  =$_POST['tipotercero'];

            if($nit=='' ){

                $nit=0;
            }
            if($telefono=='' ){
                $telefono=0;
            }
            if($direccion=='' ){
                $direccion='No tiene';
            }

                    $sql_update = mysqli_query($conexion, "UPDATE cliente
                                                            SET nit='$nit', nombrec='$nombre', apodo='$apodo', 
                                                            telefono='$telefono', direccion='$direccion',
                                                            tipo_cliente='$tipo'
                                                            WHERE idcliente=$idcliente");
                    if( $sql_update){
                        $alert='<p class="msg_error">Tercero Actualizado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Actualizar el Tercero. </p>';
                    }
        }
    }
    

    if(empty($_GET['id']))
    {
    
    }
    $idcliente=$_GET['id'];
    

    $sql=mysqli_query($conexion,"SELECT c.idcliente, c.nit, c.nombrec, c.apodo, c.telefono, c.direccion, c.tipo_cliente FROM
                    cliente c WHERE idcliente=$idcliente");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_cliente.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            $idcli = $data['idcliente' ];
            $nit = $data['nit' ];
            $nombre = $data['nombrec' ];
            $apodo = $data['apodo' ];
            $telefono = $data['telefono' ];
            $direccion = $data['direccion' ];
            $tipo = $data['tipo_cliente' ];
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
	<title>Actualizar Clientes</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1>Actualizar Tercero</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="idcliente" value="<?php echo $idcli; ?>">
                <label for="nit">NIT</label>
                <input type="text" name="nit" id="nit" placeholder="NIT" value="<?php echo $nit; ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" value="<?php echo $nombre; ?>">
                <label for="nombre">Apodo</label>
                <input type="text" name="apodo" id="apodo" placeholder="Apodo" value="<?php echo $apodo; ?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
                <label for="usuario">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion" value="<?php echo $direccion; ?>">
                <label for="rol">Tipo de Tercero</label>
                <select name="tipotercero" id="tipotercero" value="<?php echo $tipo; ?>">  
                        <option value="Recuperador">Recuperador</option>
                        <option value="Proveedor">Proveedor</option>
                        <option value="Comprador">Comprador</option>
                        <option value="Tercero">Tercero</option>
                        <option value="Reciclador-Comprador">Reciclador-Comprador</option>
                        <option value="Empleado">Empleado</option>
                </select>
                
                <input type="submit" value="Actualizar Tercero" class="btn_save">
		<input type="button" onclick=" location.href='listar_tercero.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
            </form>
        </div>
			
	</section>

</body>
</html>
