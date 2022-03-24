<?php
	session_start();
    include "../conexion.php";
    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['descripcion']) || empty($_POST['precio_compra']) )
        {
            
            $alert='<p class="msg_error">El Producto debe de tener descripcióny precio de Venta.</p>';
        }else{
            $codproducto  =$_POST['codproducto']; 
            $descripcion  =$_POST['descripcion']; 
            $precio_compra     =$_POST['precio_compra'];
            $precio_venta   =$_POST['precio_venta'];
            $existencia =$_POST['existencia'];

            if(empty($_POST['precio_venta']) )
            {
                    $precio_venta=0;
            }
            if(empty($_POST['existencia']) )
            {
                    $existencia=0;
            }

            /*echo "$codproducto";
            echo "$descripcion";
            echo "$precio_compra";
            echo "$precio_venta";
            echo "$existencia";*/




                    $sql_update = mysqli_query($conexion, "UPDATE producto
                                                            SET descripcion='$descripcion', precio_compra='$precio_compra',
                                                            precio_venta='$precio_venta', existencia='$existencia'
                                                            WHERE codproducto=$codproducto");
                    if( $sql_update){
                        $alert='<p class="msg_error">Producto Actualizado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Actualizar el Producto. </p>';
                    }
        }
    }
    

    if(empty($_GET['id']))
    {
    
    }
    $codproducto=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT p.descripcion, p.precio_compra, p.precio_venta, p.existencia FROM
                    producto p WHERE codproducto=$codproducto");
    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_producto.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            
            $descripcion = $data['descripcion' ];
            $precio_compra = $data['precio_compra' ];
            $precio_venta = $data['precio_venta' ];
            $existencia = $data['existencia' ];
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
	<title>Actualizar Productos</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Actualizar Producto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="codproducto" value="<?php echo $codproducto; ?>">
                <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="descripcion" value="<?php echo $descripcion; ?>">
                <label for="precio_compra">Precio Compra</label>
                <input type="number" name="precio_compra" id="precio_compra" placeholder="Precio Compra" value="<?php echo $precio_compra; ?>">
                <label for="precio_venta">Precio Venta</label>
                <input type="number" name="precio_venta" id="precio_venta" placeholder="Precio Venta" value="<?php echo $precio_venta; ?>">
                <label for="existencia">Existencia</label>
                <input type="number" name="existencia" min="0" id="existencia" placeholder="existencia" value="<?php echo $existencia; ?>">
                
                
                
                
		        
                <input type="submit" value="Actualizar Producto" class="btn_save">
		        <input type="button" onclick=" location.href='listar_inventario.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
		
            </form>
        </div>
			
	</section>

</body>
</html>
