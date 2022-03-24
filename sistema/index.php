<?php
	
	include "../conexion.php";

	session_start();

	if($_SESSION['rol']<1)
    {
	header('location:../');
    }


    

    
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php
		include "include/scripts.php";
	?>
	<title>Sistema de Información | TIS@</title>
	<link rel="shortcut icon" href="imagenes/icono.ico">
	
</head>
<body  >
	<?php
		include "include/header.php";
		include "include/nav.php";
	?>
	
	

<center><img src="imagenes/vision.png"></center>
			
			
		
		<?php
			include "include/footer.php";
		?>
</body>
</html>