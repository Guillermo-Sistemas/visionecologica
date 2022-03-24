<?php
	session_start();
    include "../conexion.php";
    if(!empty($_POST))
    {
        //echo $_POST['nombre'];
        $alert='';
        if(empty($_POST['descripcion'])  )
        {
            
            $alert='<p class="msg_error">El Producto debe de tener descripción.</p>';
        }else{
            $codsubproducto=$_POST['codsubproducto'];
            $descripcion=$_POST['descripcion'];
            $codproducto=$_POST['codproducto'];
            $precio_venta=$_POST['precio_venta'];

            if(empty($_POST['precio_venta']) )
            {
                    $precio_venta=0;
            }
            

            /*echo "$codproducto";
            echo "$descripcion";
            echo "$precio_compra";
            echo "$precio_venta";
            echo "$existencia";*/




                    $sql_update = mysqli_query($conexion, "UPDATE subproducto
                                                            SET nombre_subpro='$descripcion', codproducto='$codproducto',
                                                            precioventa_subpro='$precio_venta'
                                                            WHERE codsubproducto=$codsubproducto");
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
    $codsubproducto=$_GET['id'];

    $sql=mysqli_query($conexion,"SELECT s.codsubproducto, p.descripcion, p.codproducto, s.nombre_subpro, s.precioventa_subpro FROM
                    subproducto s INNER JOIN producto p ON s.codproducto=p.codproducto
                    WHERE codsubproducto=$codsubproducto");

    $result_sql=mysqli_num_rows($sql);
    

    if ($result_sql ==0){ 
        header('location: listar_usuario.php');
    }else{ 
        $option='';
        while($data=mysqli_fetch_array($sql)){ 
            
            $codsubpro = $data['codsubproducto' ];
            $codproducto = $data['codproducto' ];
            $descripcion = $data['descripcion' ];
            $subproducto = $data['nombre_subpro' ];
            $precio_venta = $data['precioventa_subpro' ];
            
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
	<title>Actualizar Subproducto</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id="container">
        <div class="form_register">
            <h1><i class="fas fa-edit"></i> Actualizar Subproducto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <input type="hidden" name="codsubproducto" value="<?php echo $codsubproducto; ?>">
                <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="descripcion" value="<?php echo $subproducto; ?>">
                
                <label for="producto">Producto</label>
                <?php
                     $query_pro=mysqli_query($conexion, "SELECT codproducto, descripcion FROM producto");
	                 mysqli_close($conexion);
                     $result_pro=mysqli_num_rows($query_pro);
	            ?>

                <select name="codproducto" id="codproducto" placeholder="Producto">  
                    <?php
                        if($result_pro > 0){
                            while($pro=mysqli_fetch_array($query_pro)){ 
                    ?>
                            <option value="<?php echo $pro["codproducto"]; ?>"><?php echo $pro["descripcion"]; ?></option>
                    <?php
                        }
                    }
		            ?>
		        </select>



                <label for="precio_venta">Precio Venta</label>

                <input type="number" name="precio_venta" id="precio_venta" placeholder="Precio Venta" value="<?php echo $precio_venta; ?>">



                
               
                
                
                <input type="submit" value="Actualizar Subproducto" class="btn_save">
		        <input type="button" onclick=" location.href='listar_subproducto.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
                
		        
                
		
            </form>
        </div>
			
	</section>

</body>
</html>
