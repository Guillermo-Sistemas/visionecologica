
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
        if(empty($_POST['descripcion']) )
        {
            $alert='<p class="msg_error">El Subproducto debe de tener Descripción.</p>';
        }else{
                $descripcion=$_POST['descripcion'];
                $codproducto=$_POST['codproducto'];
                $precio_venta=$_POST['precio_venta'];
                

                


                if(empty($_POST['precio_venta']) )
                {
                    $precio_venta=0;
                }
                

                //echo "$descripcion";
                //echo "$precio_compra";
                //echo "$precio_venta";
                //echo "$existencia";



                $query=mysqli_query($conexion,"SELECT * FROM subproducto WHERE nombre_subpro='$descripcion'");
                
                $result =mysqli_fetch_array($query);

                if($result > 0){
                    $alert='<p class="msg_error">El Subproducto ya esta creado. </p>';
                }else{
                    $query_insert=mysqli_query($conexion, "INSERT INTO subproducto(codproducto, nombre_subpro, precioventa_subpro)
                                                            VALUES ('$codproducto','$descripcion', 
                                                            '$precio_venta')");

                    if( $query_insert){
                        $alert='<p class="msg_error">Subproducto Creado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Crear el Subproducto. </p>';
                    }
                }
        }
    }



    //consulta de productos

    
         $query_pro=mysqli_query($conexion, "SELECT codproducto, descripcion FROM producto");
	     mysqli_close($conexion);
         $result_pro=mysqli_num_rows($query_pro);
	

?>
        

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Crear Subproducto</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1><i class="fas fa-plus"></i>  Crear Subproducto</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <label for="Descripción">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Sub Producto">
                <label for="derivaproducto">Producto</label>


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
                


                <label for="precio_venta">Precio de Venta</label>
                <input type="number" name="precio_venta" id="precio_venta" placeholder="Precio de Venta del Producto">
                
                
           
                </select>
                
                <input type="submit" value="Crear Subproducto" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
        </div>
			
	</section>

		
        
        
</body>
</html>
