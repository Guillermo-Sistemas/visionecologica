<?php
        session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$idusuario=$_POST['idusuario'];

		//$query_delete=mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario=$idusuario");

		$query_delete=mysqli_query($conexion,"UPDATE usuario SET estatus=0 WHERE idusuario=$idusuario");

                if($query_delete){
					header("location: listar_usuario.php");
				}else{
					echo "Error al Eliminar";
				}

	}



	if(empty($_REQUEST['id']) || $_REQUEST['id']==1)
	{
		header("location: listar_usuario.php");
	}else{
		include "../conexion.php";
		$idusuario=$_REQUEST['id'];
		
		$query=mysqli_query($conexion,"SELECT u.nombre, u.usuario, r.rol
										FROM usuario u INNER JOIN rol r ON u.rol=r.idrol 
										WHERE u.idusuario=$idusuario");
                $result =mysqli_num_rows($query);

                if($result > 0){
					while($data=mysqli_fetch_array($query)){
						
						$nombre=$data['nombre'];
						$usuario=$data['usuario'];
						$rol=$data['rol'];

					}
				}else{
					
					header("location: listar_usuario.php");
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
	<title>Eliminar Usuario</title>
	
</head>
<body>
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	<section id=container>
			<div class="data_delete">
				<h2>¿Está Seguro de Eliminar el Siguiente Registro?</h2>
				<p>Nombre:<span><?php echo $nombre; ?></span></p>
				<p>Usuario:<span><?php echo $usuario; ?></span></p>
				<p>Tipo de Usuario:<span><?php echo $rol; ?></span></p>
				

				<form method="post" action="">
					<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
					<a href="listar_usuario.php" class="btn_cancel">Cancelar</a>
					<input type="submit" value="Aceptar" class="btn_ok"></a>
				</form>
			</div>	
			
			
	</section>
		<?php
			include "include/footer.php";
		?>
</body>
</html>