<?php
    
    

    include "../conexion.php";

    session_start();


    if($_SESSION['rol']<1)
    {
	header('location:../');
    }

    if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST['descripcion']) || empty($_POST['precio_compra']))
        {
            $alert='<p class="msg_error">El Producto debe de tener Descripción y Precio de Compra.</p>';
        }else{
                $descripcion=$_POST['descripcion'];
                $precio_compra=$_POST['precio_compra'];
                $precio_venta=$_POST['precio_venta'];
                $existencia=$_POST['existencia'];
                //$usuario_id=$_POST['usuario_id']; 

                


                if(empty($_POST['precio_venta']) )
                {
                    $precio_venta=0;
                }
                if(empty($_POST['existencia']) )
                {
                    $existencia=0;
                }

                //echo "$descripcion";
                //echo "$precio_compra";
                //echo "$precio_venta";
                //echo "$existencia";



                $query=mysqli_query($conexion,"SELECT * FROM producto WHERE descripcion='$descripcion'");
                
                $result =mysqli_fetch_array($query);

                if($result > 0){
                    $alert='<p class="msg_error">El Producto ya esta creado. </p>';
                }else{
                    $query_insert=mysqli_query($conexion, "INSERT INTO producto(descripcion, precio_compra,
                                                            precio_venta, existencia)
                                                            VALUES ('$descripcion','$precio_compra', 
                                                            '$precio_venta', '$existencia')");

                    if( $query_insert){
                        $alert='<p class="msg_error">Producto Creado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Crear el Producto. </p>';
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
	<title>Crear Productos</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1><i class="fas fa-plus"></i>  Crear Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <label for="Descripción">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Producto">
                 <label for="precio_compra">Precio de Compra</label>
                <input type="number" name="precio_compra" id="precio_compra" placeholder="Precio de Compra del Producto">
                <label for="precio_venta">Precio de Venta</label>
                <input type="number" name="precio_venta" id="precio_venta" placeholder="Precio de Venta del Producto">
                <label for="existencia">Existencia</label>
                <input type="number" name="existencia" id="existencia" placeholder="Existencia del Producto">
                
           
                </select>
                
                <input type="submit" value="Crear Producto" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
        </div>
			
	</section>

		
        
        
</body>
</html>
