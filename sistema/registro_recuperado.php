
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
        if(empty($_POST['descripcion']) ||  empty($_POST['codproducto']) ||  empty($_POST['peso']) )
        {
            $alert='<p class="msg_error">El Producto Recuperado debe de tener Descripción, Producto de donde se Recupera y Peso.</p>';
        }else{
                $descripcion=$_POST['descripcion'];
                $codproducto=$_POST['codproducto'];
                $precio_venta=$_POST['precio_venta'];
                $peso=$_POST['peso'];
                

                if(empty($_POST['precio_venta']) )
                {
                    $precio_venta=0;
                }
                
                 date_default_timezone_set('America/Bogota');
                $fechaactual2 = Date('Y-m-d H:i:s', time());


               
                    $query_insert=mysqli_query($conexion, "INSERT INTO recuperado(descripcion_recuperado, fecha_recuperado, 
                                                            codproducto, peso_recuperado, precioventa_recuperado)
                                                            VALUES ('$descripcion','$fechaactual2', '$codproducto',
                                                            '$peso','$precio_venta')");

                    //se afecta la existencia del producto se le resta el peso del articulo
                    $inicio1=mysqli_query($conexion, "SELECT existencia from producto WHERE codproducto='$codproducto'");
                    $datoinicio1=mysqli_fetch_array($inicio1);

                    $existencia1= $datoinicio1["existencia"];
                    $existencia1=$existencia1-$peso;
                    $query_existencia1=mysqli_query($conexion, "UPDATE producto SET existencia=$existencia1 WHERE codproducto='$codproducto'");

                    

                    if( $query_insert && $inicio1){
                        $alert='<p class="msg_error">Artículo Creado Correctamente. </p>';
                    }else{
                        $alert='<p class="msg_error">Error al Recuperar el Artículo. </p>';
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
	<title>Recuperar Artículo</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section class="contenido">
        <div class="form_register">
            <h1><i class="fas fa-plus"></i>  Recuperar Artículo</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert:''; ?> </div>

            <form action="" method="post">
                <label for="Descripción">Nombre Artículo a Recuperar</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del Artículo a Recuperar">
                
                <label for="derivaproducto">Producto de donde se Recupera</label>


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

                <label for="precio_venta">Peso Artículo Recuperado</label>
                <input type="number" step=0.01 name="peso" id="peso" placeholder="Peso del Artículo Recuperado">
                


                <label for="precio_venta">Precio de Venta</label>
                <input type="number" name="precio_venta" id="precio_venta" placeholder="Precio de Venta del Artículo">
                
                
           
                </select>
                
                <input type="submit" value="Recuperar Artículo" class="btn_save">
		<input type="button" onclick=" location.href='index.php' " value="Cancelar" name="boton" class="btn_cancelado"  />
        </div>
			
	</section>

		
        
        
</body>
</html>
